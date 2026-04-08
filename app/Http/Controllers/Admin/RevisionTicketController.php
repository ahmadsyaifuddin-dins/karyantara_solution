<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RevisionTicket;
use App\Models\Project;
use Illuminate\Http\Request;

class RevisionTicketController extends Controller
{
    /**
     * Menampilkan Kanban Board
     */
    public function board()
    {
        // Ambil tiket beserta data project (klien & nama project)
        $tickets = RevisionTicket::with('project')->orderBy('sort_order')->get();

        // Kelompokkan berdasarkan status
        $board = [
            'backlog'     => $tickets->where('status', 'backlog'),
            'in_progress' => $tickets->where('status', 'in_progress'),
            'waiting'     => $tickets->where('status', 'waiting'),
            'done'        => $tickets->where('status', 'done'),
        ];

        return view('admin.revisions.board', compact('board'));
    }

    /**
     * Update status via Drag & Drop (AJAX)
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:revision_tickets,id',
            'status'    => 'required|in:backlog,in_progress,waiting,done',
            'new_order' => 'array'
        ]);

        $ticket = RevisionTicket::findOrFail($request->ticket_id);
        $ticket->update(['status' => $request->status]);

        if ($request->has('new_order')) {
            foreach ($request->new_order as $index => $id) {
                RevisionTicket::where('id', $id)->update(['sort_order' => $index]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Status tiket diperbarui!']);
    }

    /**
     * Halaman Tambah Tiket
     */
    public function create()
    {
        // Ambil project yang belum lunas/selesai (bisa disesuaikan filter statusnya)
        $projects = Project::orderBy('created_at', 'desc')->get();
        return view('admin.revisions.create', compact('projects'));
    }

    /**
     * Proses Simpan Tiket (Otomatis potong kuota revisi)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'type'        => 'required|in:app,naskah,keduanya',
            'description' => 'nullable|string',
        ]);

        // Masukkan ke kolom backlog secara default
        $validated['status'] = 'backlog';
        $validated['sort_order'] = RevisionTicket::where('status', 'backlog')->max('sort_order') + 1;

        $ticket = RevisionTicket::create($validated);

        // OTOMATIS TAMBAH USED REVISION (+1) PADA PROJECT
        $project = Project::find($validated['project_id']);
        if ($project) {
            $project->increment('used_revision');
        }
        
        return redirect()->route('admin.revisions.board')
            ->with('success', 'Tiket ditambahkan ke antrean & Kuota Revisi Klien terpakai (+1).');
    }

    /**
     * Halaman Edit Tiket
     */
    public function edit(RevisionTicket $revision)
    {
        $projects = Project::all();
        return view('admin.revisions.edit', [
            'ticket'   => $revision,
            'projects' => $projects
        ]);
    }

    /**
     * Proses Update Tiket
     */
    public function update(Request $request, RevisionTicket $revision)
    {
        $validated = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'type'        => 'required|in:app,naskah,keduanya',
            'description' => 'nullable|string',
        ]);

        $revision->update($validated);

        return redirect()->route('admin.revisions.board')->with('success', 'Data Tiket Revisi berhasil diperbarui.');
    }

    /**
     * Proses Hapus Tiket
     */
    public function destroy(RevisionTicket $revision)
    {
        // Opsional: Jika tiket dihapus karena salah input, kembalikan kuotanya (-1)
        $project = Project::find($revision->project_id);
        if ($project && $project->used_revision > 0) {
            $project->decrement('used_revision');
        }

        $revision->delete();
        
        return redirect()->route('admin.revisions.board')->with('success', 'Tiket Revisi dihapus dan kuota klien dikembalikan (+1).');
    }
}