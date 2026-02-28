<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::latest()->paginate(10);

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(StoreAdminRequest $request)
    {
        $data = $request->validated();

        // Enkripsi password sebelum disimpan
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.admins.index')->with('success', 'Akun admin berhasil ditambahkan.');
    }

    public function edit(User $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(UpdateAdminRequest $request, User $admin)
    {
        $data = $request->validated();

        // Jika password diisi, enkripsi. Jika tidak, hapus dari array agar tidak mengubah password lama
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
        // Mencegah admin menghapus akunnya sendiri yang sedang dipakai login
        if ($admin->id === Auth::id()) {
            return redirect()->route('admin.admins.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Akun admin berhasil dihapus.');
    }
}
