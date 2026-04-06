<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        // Menampilkan daftar jabatan, sekalian load relasi 'parent' (atasannya)
        $positions = Position::with('parent')->orderBy('department', 'ASC')->paginate(10);
        
        return view('admin.positions.index', compact('positions'));
    }

    public function create()
    {
        // Ambil semua jabatan untuk dijadikan opsi "Atasan Langsung" (Parent)
        $parentPositions = Position::orderBy('name', 'ASC')->get();
        return view('admin.positions.create', compact('parentPositions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:positions,id',
            'icon' => 'nullable|string|max:255',
            'color_bg' => 'nullable|string|max:255',
            'color_text' => 'nullable|string|max:255',
        ]);

        Position::create($validated);

        return redirect()->route('admin.positions.index')->with('success', 'Data Jabatan berhasil ditambahkan.');
    }

    public function edit(Position $position)
    {
        // Ambil posisi untuk atasan, TETAPI kecualikan dirinya sendiri agar tidak terjadi loop (Inception)
        $parentPositions = Position::where('id', '!=', $position->id)->orderBy('name', 'ASC')->get();
        return view('admin.positions.edit', compact('position', 'parentPositions'));
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:positions,id|not_in:' . $position->id,
            'icon' => 'nullable|string|max:255',
            'color_bg' => 'nullable|string|max:255',
            'color_text' => 'nullable|string|max:255',
        ]);

        $position->update($validated);

        return redirect()->route('admin.positions.index')->with('success', 'Data Jabatan berhasil diperbarui.');
    }

    public function destroy(Position $position)
    {
        // Cek apakah jabatan ini sedang dipakai oleh user
        if ($position->users()->count() > 0) {
            return redirect()->route('admin.positions.index')->with('error', 'Gagal dihapus! Jabatan ini sedang digunakan oleh akun Admin.');
        }

        // Cek apakah jabatan ini punya bawahan
        if ($position->children()->count() > 0) {
            return redirect()->route('admin.positions.index')->with('error', 'Gagal dihapus! Jabatan ini masih memiliki divisi/jabatan bawahan.');
        }

        $position->delete();

        return redirect()->route('admin.positions.index')->with('success', 'Jabatan berhasil dihapus.');
    }

    public function orgChart()
    {
        $structure = Position::whereNull('parent_id')
            ->with([
                'users',                   
                'children.users',          
                'children.children.users' 
            ]) 
            ->get();

        return view('pages.admin.struktur.index', compact('structure'));
    }
}