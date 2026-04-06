<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $department = $request->input('department');

        // Gunakan withCount('users') agar jumlah user dihitung di level database, bukan di looping Blade!
        $query = Position::with('parent')->withCount('users');

        // Fitur Pencarian berdasarkan nama jabatan
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Fitur Filter berdasarkan divisi (department)
        if ($department) {
            $query->where('department', $department);
        }

        // Jangan lupa withQueryString() agar saat pindah halaman (pagination), filternya tidak hilang
        $positions = $query->orderBy('department', 'ASC')->paginate(10)->withQueryString();
        
        // Ambil daftar divisi unik untuk dropdown filter
        $departments = Position::whereNotNull('department')->distinct()->pluck('department');

        return view('admin.positions.index', compact('positions', 'departments'));
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