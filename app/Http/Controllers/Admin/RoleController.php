<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        // Ambil semua role KECUALI super_admin
        $roles = Role::where('name', '!=', 'super_admin')->with('permissions')->get();
        $permissions = Permission::all();

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ], [
            'name.unique' => 'Nama Role ini sudah ada di database!',
        ]);

        // Format nama role jadi lowercase & snake_case (best practice) -> ex: "Tim Finance" jadi "tim_finance"
        $roleName = strtolower(str_replace(' ', '_', $request->name));

        Role::create(['name' => $roleName]);

        return back()->with('success', 'Role baru berhasil ditambahkan! Silakan atur hak aksesnya di bawah.');
    }

    public function update(Request $request, Role $role)
    {
        if ($role->name === 'super_admin') {
            return back()->with('error', 'Akses Ditolak! Role Super Admin tidak dapat dimodifikasi.');
        }

        $role->syncPermissions($request->permissions ?? []);

        return back()->with('success', 'Hak Akses untuk Role '.strtoupper($role->name).' berhasil diperbarui!');
    }

    public function destroy(Role $role)
    {
        // Proteksi: Role bawaan sistem dilarang dihapus
        if (in_array($role->name, ['super_admin', 'admin'])) {
            return back()->with('error', 'Role bawaan sistem tidak dapat dihapus!');
        }

        // Proteksi: Jangan hapus role kalau masih ada akun yang pakai
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Gagal! Role ini sedang digunakan oleh akun Admin.');
        }

        $role->delete();

        return back()->with('success', 'Role berhasil dihapus.');
    }

    // Method khusus untuk mengeksekusi Seeder dari UI
    public function syncPermissions()
    {
        try {
            // Memanggil perintah artisan db:seed khusus untuk file RolePermissionSeeder
            Artisan::call('db:seed', [
                '--class' => 'RolePermissionSeeder',
            ]);

            return back()->with('success', 'Sinkronisasi berhasil! Fitur/Izin baru sudah terdeteksi dan ditambahkan ke database.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal sinkronisasi: '.$e->getMessage());
        }
    }
}
