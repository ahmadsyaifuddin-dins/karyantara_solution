<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role; // Import facade Route

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus cache bawaan Spatie biar datanya fresh
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. AUTO-DISCOVERY PERMISSIONS (Tanpa ngetik manual!)
        $permissions = [];

        // Ambil semua routes yang ada di aplikasi
        $routes = Route::getRoutes()->get();

        foreach ($routes as $route) {
            // Ambil middleware yang dipakai di setiap route
            $middlewares = $route->gatherMiddleware();

            foreach ($middlewares as $middleware) {
                // Cek apakah ada middleware yang namanya berawalan "can:"
                // Contoh: middleware('can:manage_keuangan')
                if (str_starts_with($middleware, 'can:')) {
                    // Potong teks "can:" untuk mendapatkan murni nama permission-nya
                    $permissionName = substr($middleware, 4);

                    // Masukkan ke array jika belum ada (mencegah duplikat)
                    if (! in_array($permissionName, $permissions)) {
                        $permissions[] = $permissionName;
                    }
                }
            }
        }

        // 2. SIMPAN KE DATABASE
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        // 3. PASTIKAN ROLE UTAMA ADA
        Role::updateOrCreate(['name' => 'super_admin']);
        Role::updateOrCreate(['name' => 'admin']);

        // Catatan: Role lain dan centangan izin tidak akan ter-reset,
        // karena kita tidak memakai syncPermissions() di sini. Sangat aman!
    }
}
