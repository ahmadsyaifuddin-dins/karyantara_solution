<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        // Load 'position' dan 'roles' (Spatie) agar terhindar dari N+1 Query
        $admins = User::with(['position', 'roles'])->latest()->paginate(10);

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $positions = Position::orderBy('name', 'ASC')->get();

        // Ambil semua Role dinamis dari tabel Spatie
        $roles = Role::orderBy('name', 'ASC')->get();

        return view('admin.admins.create', compact('positions', 'roles'));
    }

    public function store(StoreAdminRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        // Simpan nama role dari form
        $roleName = $data['role'];

        // Create User
        $user = User::create($data);

        // Berikan Hak Akses (Role) menggunakan fungsi Spatie
        if ($roleName) {
            $user->assignRole($roleName);
        }

        return redirect()->route('admin.admins.index')->with('success', 'Akun admin berhasil ditambahkan.');
    }

    public function edit(User $admin)
    {
        $positions = Position::orderBy('name', 'ASC')->get();
        $roles = Role::orderBy('name', 'ASC')->get();

        // Ambil role Spatie yang saat ini dipakai oleh user
        // (Bisa juga pakai array jika 1 user punya banyak role, tapi umumnya 1 user 1 role)
        $userRole = $admin->roles->pluck('name')->first();

        return view('admin.admins.edit', compact('admin', 'positions', 'roles', 'userRole'));
    }

    public function update(UpdateAdminRequest $request, User $admin)
    {
        $data = $request->validated();

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $roleName = $data['role'] ?? null;

        $admin->update($data);

        // Update (Sinkronisasi) Hak Akses Role Spatie
        if ($roleName) {
            $admin->syncRoles([$roleName]);
        }

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
