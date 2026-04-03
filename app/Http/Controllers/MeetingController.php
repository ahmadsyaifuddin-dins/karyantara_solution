<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Http\Requests\MeetingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MeetingController extends Controller
{
    public function index()
    {
        // 1. Eksekusi pengecekan & update status otomatis (On-the-fly)
        Meeting::updateAutomatedStatuses();

        // 2. Baru ambil data yang sudah up-to-date untuk ditampilkan
        $meetings = Meeting::with('creator')
                    ->orderBy('start_time', 'desc')
                    ->paginate(10);
                    
        return view('admin.meetings.index', compact('meetings'));
    }

    public function create()
    {
        return view('admin.meetings.create');
    }

    public function store(MeetingRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        // 1. Logika Oldschool Upload Foto
        if ($request->doc_type === 'upload' && $request->hasFile('documentation_file')) {
            $file = $request->file('documentation_file');
            
            // Buat nama unik agar tidak bentrok
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Pindahkan file ke public/uploads/meetings
            $file->move(public_path('uploads/meetings'), $fileName);
            
            $validated['documentation_file'] = $fileName;
            $validated['documentation_link'] = null; // Kosongkan link jika pilih upload
        } 
        // 2. Jika pilih Link G-Drive
        elseif ($request->doc_type === 'link') {
            $validated['documentation_file'] = null;
        }

        // Buang doc_type dari array karena tidak ada di tabel database
        unset($validated['doc_type']);

        Meeting::create($validated);

        return redirect()->route('admin.meetings.index')
                         ->with('success', 'Agenda rapat berhasil dijadwalkan!');
    }

    public function show(Meeting $meeting)
    {
        // 1. Eksekusi pengecekan & update status otomatis
        Meeting::updateAutomatedStatuses();

        // 2. REFRESH OBJECT MODEL (Sangat Krusial!)
        // Karena data di DB barusan mungkin berubah oleh fungsi di atas,
        // kita harus me-refresh data $meeting yang sedang dibuka agar tampilannya ikut berubah.
        $meeting->refresh();

        return view('admin.meetings.show', compact('meeting'));
    }

    public function print(Meeting $meeting)
    {
        return view('admin.meetings.print', compact('meeting'));
    }

    public function edit(Meeting $meeting)
    {
        return view('admin.meetings.edit', compact('meeting'));
    }

    public function update(MeetingRequest $request, Meeting $meeting)
    {
        $validated = $request->validated();

        // 1. Jika User Memilih Mode Upload Foto
        if ($request->doc_type === 'upload') {
            $validated['documentation_link'] = null; // Reset link

            if ($request->hasFile('documentation_file')) {
                // Hapus gambar lama dari folder public jika ada
                if ($meeting->documentation_file) {
                    $oldPath = public_path('uploads/meetings/' . $meeting->documentation_file);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                // Upload gambar baru
                $file = $request->file('documentation_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/meetings'), $fileName);
                $validated['documentation_file'] = $fileName;
            }
        } 
        // 2. Jika User Memilih Mode Link G-Drive
        elseif ($request->doc_type === 'link') {
            $validated['documentation_file'] = null; // Kosongkan nama file di DB

            // Eksekusi mati: Hapus file fisik lama jika dulunya pakai upload foto
            if ($meeting->documentation_file) {
                $oldPath = public_path('uploads/meetings/' . $meeting->documentation_file);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
        }

        unset($validated['doc_type']);

        $meeting->update($validated);

        return redirect()->route('admin.meetings.index')
                         ->with('success', 'Data rapat & notulensi berhasil diperbarui!');
    }

    public function destroy(Meeting $meeting)
    {
        // Jangan lupa: Hapus gambar fisiknya dari folder sebelum datanya lenyap dari DB
        if ($meeting->documentation_file) {
            $oldPath = public_path('uploads/meetings/' . $meeting->documentation_file);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $meeting->delete();

        return redirect()->route('admin.meetings.index')
                         ->with('success', 'Agenda rapat berhasil dihapus!');
    }
}