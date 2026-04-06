<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\User;
use App\Models\Position; // IMPORT MODEL POSITION
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        // Gunakan Eager Loading (with) agar tidak N+1 Query saat menampilkan nama jabatan
        $admins = User::with('position')->latest()->paginate(10);

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        // Ambil semua data posisi untuk dropdown form
        $positions = Position::orderBy('name', 'ASC')->get();
        return view('admin.admins.create', compact('positions'));
    }

    public function store(StoreAdminRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.admins.index')->with('success', 'Akun admin berhasil ditambahkan.');
    }

    public function edit(User $admin)
    {
        // Ambil semua data posisi untuk dropdown form
        $positions = Position::orderBy('name', 'ASC')->get();
        return view('admin.admins.edit', compact('admin', 'positions'));
    }

    public function update(UpdateAdminRequest $request, User $admin)
    {
        $data = $request->validated();

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $admin->update($data);

        return redirect()->route('admin.admins.index')->with('success', 'Data admin berhasil diperbarui.');
    }

    public function destroy(User $admin)
    {
        if ($admin->id === Auth::id()) {
            return redirect()->route('admin.admins.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Akun admin berhasil dihapus.');
    }
}