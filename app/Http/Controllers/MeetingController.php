<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetingRequest;
use App\Mail\MeetingInvitation;
use App\Models\Meeting;
use App\Models\User;
use App\Services\GoogleCalendarService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MeetingController extends Controller
{
    public function index()
    {
        // 1. Eksekusi pengecekan & update status otomatis (On-the-fly)
        Meeting::updateAutomatedStatuses();

        // 2. HITUNG STATISTIK BIAYA (Baru)
        $stats = [
            'total_all'   => Meeting::sum('consumption_cost'),
            'total_year'  => Meeting::whereYear('start_time', now()->year)->sum('consumption_cost'),
            'total_month' => Meeting::whereMonth('start_time', now()->month)
                                    ->whereYear('start_time', now()->year)
                                    ->sum('consumption_cost'),
            'total_today' => Meeting::whereDate('start_time', now()->today())->sum('consumption_cost'),
        ];

        // 3. Ambil data meetings
        $meetings = Meeting::with('creator')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        // Kirim $stats ke view
        return view('admin.meetings.index', compact('meetings', 'stats'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.meetings.create', compact('users'));
    }

    public function store(MeetingRequest $request, GoogleCalendarService $calendarService)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        // 1. Logika Oldschool Upload Foto
        if ($request->doc_type === 'upload' && $request->hasFile('documentation_file')) {
            $file = $request->file('documentation_file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/meetings'), $fileName);

            $validated['documentation_file'] = $fileName;
            $validated['documentation_link'] = null;
        }
        // 2. Jika pilih Link G-Drive
        elseif ($request->doc_type === 'link') {
            $validated['documentation_file'] = null;
        }

        unset($validated['doc_type']);

        // Simpan ke database
        $meeting = Meeting::create($validated);

        // PROSES GOOGLE CALENDAR & EMAIL ICS
        try {
            // 1. Buat Event di Kalender Karyantara
            $eventId = $calendarService->createEvent($meeting);
            $meeting->update(['google_event_id' => $eventId]);

           // 2. Kirim Email Undangan Berisi File .ICS ke Karyawan
            $karyawanEmails = $meeting->attendee_emails ?? []; // Tarik dari database!

            foreach ($karyawanEmails as $email) {
                Mail::to($email)->send(new MeetingInvitation($meeting, $email));
            }

        } catch (\Exception $e) {
            Log::error('GAGAL SYNC GOOGLE CALENDAR ATAU EMAIL: '.$e->getMessage());

            return redirect()->route('admin.meetings.index')
                ->with('success', 'Agenda tersimpan di database, TAPI gagal sync ke Kalender/Email. Cek laravel.log.');
        }

        return redirect()->route('admin.meetings.index')
            ->with('success', 'Agenda rapat berhasil dijadwalkan, disinkronkan, & Undangan terkirim!');
    }

    public function show(Meeting $meeting)
    {
        Meeting::updateAutomatedStatuses();
        $meeting->refresh();

        return view('admin.meetings.show', compact('meeting'));
    }

    public function print(Meeting $meeting)
    {
        return view('admin.meetings.print', compact('meeting'));
    }

   public function edit(Meeting $meeting)
    {
        $users = User::all();
        return view('admin.meetings.edit', compact('meeting', 'users'));
    }

    public function update(MeetingRequest $request, Meeting $meeting, GoogleCalendarService $calendarService)
    {
        $validated = $request->validated();

        if ($request->doc_type === 'upload') {
            $validated['documentation_link'] = null;

            if ($request->hasFile('documentation_file')) {
                if ($meeting->documentation_file) {
                    $oldPath = public_path('uploads/meetings/'.$meeting->documentation_file);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }
                $file = $request->file('documentation_file');
                $fileName = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/meetings'), $fileName);
                $validated['documentation_file'] = $fileName;
            }
        } elseif ($request->doc_type === 'link') {
            $validated['documentation_file'] = null;

            if ($meeting->documentation_file) {
                $oldPath = public_path('uploads/meetings/'.$meeting->documentation_file);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
        }

        unset($validated['doc_type']);

        $meeting->update($validated);

        // UPDATE KE GOOGLE CALENDAR
        try {
            if ($meeting->google_event_id) {
                $calendarService->updateEvent($meeting);
            } else {
                $eventId = $calendarService->createEvent($meeting);
                $meeting->update(['google_event_id' => $eventId]);
            }

            // Opsional: Jika Anda ingin kirim ulang email kalau jadwal direvisi,
            // Anda bisa meletakkan logika Mail::to(...)->send(...) di sini juga.

        } catch (\Exception $e) {
            Log::error('GAGAL UPDATE GOOGLE CALENDAR: '.$e->getMessage());

            return redirect()->route('admin.meetings.index')
                ->with('success', 'Data rapat berhasil diperbarui, TAPI gagal sync ke Kalender. Cek laravel.log.');
        }

        return redirect()->route('admin.meetings.index')
            ->with('success', 'Data rapat berhasil diperbarui & disinkronkan ke Kalender!');
    }

    public function destroy(Meeting $meeting, GoogleCalendarService $calendarService)
    {
        // 1. Hapus gambar fisik
        if ($meeting->documentation_file) {
            $oldPath = public_path('uploads/meetings/'.$meeting->documentation_file);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        // 2. Hapus event di Google Calendar
        try {
            if ($meeting->google_event_id) {
                $calendarService->deleteEvent($meeting->google_event_id);
            }
        } catch (\Exception $e) {
            Log::error('GAGAL HAPUS GOOGLE CALENDAR: '.$e->getMessage());

            // JANGAN DI-RETURN DI SINI!
            // Kita simpan pesan peringatan saja di session, lalu biarkan kodenya jalan ke bawah untuk menghapus DB.
            session()->flash('warning', 'Agenda dihapus dari database, TAPI gagal dihapus di Kalender (mungkin sudah terhapus manual).');
        }

        // 3. Hapus data di Database secara mutlak (Pasti Tereksekusi!)
        $meeting->delete();

        // Jika tidak ada error (pesan warning tidak terset), tampilkan pesan sukses biasa
        if (! session()->has('warning')) {
            session()->flash('success', 'Agenda rapat dan event di kalender berhasil dihapus!');
        }

        return redirect()->route('admin.meetings.index');
    }
}
