<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Http\Requests\MeetingRequest;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * Tampilkan daftar agenda (List View)
     */
    public function index()
    {
        // Mengambil data meeting, diurutkan dari yang jadwalnya paling dekat
        $meetings = Meeting::with('creator')
                    ->orderBy('start_time', 'desc')
                    ->paginate(10);
                    
        return view('admin.meetings.index', compact('meetings'));
    }

    /**
     * Tampilkan form pembuatan agenda baru
     */
    public function create()
    {
        return view('admin.meetings.create');
    }

    /**
     * Simpan data agenda ke database
     */
    public function store(MeetingRequest $request)
    {
        $validated = $request->validated();
        
        // Otomatis assign siapa yang membuat (CEO atau CTO)
        $validated['created_by'] = auth()->id();

        Meeting::create($validated);

        return redirect()->route('admin.meetings.index')
                         ->with('success', 'Agenda rapat berhasil dijadwalkan!');
    }

    /**
     * Tampilkan detail agenda & notulensi
     */
    public function show(Meeting $meeting)
    {
        return view('admin.meetings.show', compact('meeting'));
    }

    /**
     * Tampilkan form edit agenda (termasuk update hasil rapat/MoM)
     */
    public function edit(Meeting $meeting)
    {
        return view('admin.meetings.edit', compact('meeting'));
    }

    /**
     * Update data agenda ke database
     */
    public function update(MeetingRequest $request, Meeting $meeting)
    {
        $meeting->update($request->validated());

        return redirect()->route('admin.meetings.index')
                         ->with('success', 'Data rapat & notulensi berhasil diperbarui!');
    }

    /**
     * Hapus data agenda
     */
    public function destroy(Meeting $meeting)
    {
        $meeting->delete();

        return redirect()->route('admin.meetings.index')
                         ->with('success', 'Agenda rapat berhasil dihapus!');
    }

    public function print(Meeting $meeting)
    {
        return view('admin.meetings.print', compact('meeting'));
    }
}