# 🛡️ Dokumentasi RBAC (Role-Based Access Control)

# Karyantara Solution — Panel Admin

> **Versi Dokumentasi:** 2.0.0
> **Terakhir Diperbarui:** 07 April 2026
> **Package Utama:** [`spatie/laravel-permission`](https://spatie.be/docs/laravel-permission)
> **Dibuat untuk:** Developer & Admin Karyantara Solution

---

## 📚 Daftar Isi

1. [Konsep Dasar RBAC](#-konsep-dasar-rbac)
2. [Arsitektur Sistem](#-arsitektur-sistem)
3. [God Mode — Super Admin](#-god-mode--super-admin)
4. [Penggunaan di Source Code](#️-penggunaan-di-source-code)
    - [Memproteksi Route](#1-memproteksi-url-routes)
    - [Menyembunyikan Elemen UI Blade](#2-menyembunyikan-elemen-ui-blade)
    - [Pengecekan di Controller](#3-pengecekan-izin-di-dalam-controller)
5. [Daftar Lengkap Permissions](#-daftar-lengkap-permissions)
6. [Manajemen Role & Permission via UI](#-manajemen-role--permission-via-ui)
7. [Auto-Discovery Seeder](#-auto-discovery-seeder)
8. [SOP Penambahan Menu / Fitur Baru](#-sop-penambahan-menu--fitur-baru)
9. [Konfigurasi Navigasi (config/navigation.php)](#-konfigurasi-navigasi-confignavigationphp)
10. [Troubleshooting & FAQ](#-troubleshooting--faq)
11. [Referensi & Catatan Penting](#-referensi--catatan-penting)

---

## 🧠 Konsep Dasar RBAC

**RBAC (Role-Based Access Control)** adalah pola keamanan di mana hak akses diberikan kepada **Role (Peran)**, bukan langsung kepada pengguna. Setiap pengguna kemudian diberikan satu atau lebih Role tersebut.

### Hierarki Sistem

```
User (Pengguna Admin)
  └── memiliki ──▶ Role (Peran)
                      └── memiliki ──▶ Permission (Izin/Fitur)
                                            └── mengatur akses ke ──▶ Route / UI Element
```

### Perbedaan Role vs Permission

| Aspek                  | Role (Peran)                         | Permission (Izin)                             |
| ---------------------- | ------------------------------------ | --------------------------------------------- |
| **Definisi**           | Label jabatan/kelompok pengguna      | Kunci akses ke fitur spesifik                 |
| **Contoh**             | `super_admin`, `finance`, `editor`   | `manage_projects`, `view_dashboard`           |
| **Sifat**              | Dinamis — bisa dibuat/dihapus via UI | Statis — terikat pada kode (`routes/web.php`) |
| **Tempat Konfigurasi** | Database (via UI Web)                | Source code + Database                        |
| **Siapa yang punya?**  | Diberikan ke User                    | Diberikan ke Role                             |

> **Prinsip Utama:** Satu pengguna bisa memiliki lebih dari satu Role. Satu Role bisa memiliki banyak Permission. Permission yang menempel di kode adalah **sumber kebenaran tunggal (single source of truth)** untuk keamanan fitur.

---

## 🏗️ Arsitektur Sistem

### Alur Kerja Keamanan (Request Lifecycle)

```
Browser Request
      │
      ▼
  [Middleware Stack]
      │
      ├── auth          ──▶ Apakah user sudah login? (Jika tidak → redirect Login)
      │
      └── can:<izin>    ──▶ Apakah user punya izin ini?
                              │
                              ├── [Ya, Super Admin?] ──▶ Gate::before() bypass → AKSES DIBERIKAN ✅
                              │
                              ├── [Ya, punya permission?] ──▶ AKSES DIBERIKAN ✅
                              │
                              └── [Tidak] ──▶ HTTP 403 Forbidden ❌
```

### File-file Kunci Sistem RBAC

| File                                            | Fungsi                                              |
| ----------------------------------------------- | --------------------------------------------------- |
| `app/Providers/AppServiceProvider.php`          | Konfigurasi `Gate::before` untuk Super Admin bypass |
| `routes/web.php`                                | Pendaftaran route + middleware `can:`               |
| `config/navigation.php`                         | Konfigurasi menu sidebar + mapping permission       |
| `database/seeders/RolePermissionSeeder.php`     | Seeder data role & permission awal                  |
| `app/Http/Controllers/Admin/RoleController.php` | Controller untuk manajemen Role & Permission        |
| `resources/views/admin/roles/`                   | Tampilan UI manajemen Role & Permission             |

---

## 👑 God Mode — Super Admin

User dengan Role `super_admin` mendapatkan **hak akses penuh tanpa batas** ke seluruh fitur sistem. Implementasi ini menggunakan fitur `Gate::before` bawaan Laravel.

### Konfigurasi di AppServiceProvider

```php
// app/Providers/AppServiceProvider.php

use Illuminate\Support\Facades\Gate;

public function boot(): void
{
    // ⚡ SUPER ADMIN BYPASS — Semua Gate/can check di-skip untuk super_admin
    Gate::before(function ($user, $ability) {
        if ($user->hasRole('super_admin')) {
            return true; // null = lanjutkan pengecekan normal, true = langsung izinkan
        }
    });
}
```

### Implikasi Penting God Mode

- ✅ Super Admin **tidak perlu** diberi permission satu per satu
- ✅ Super Admin tetap bisa mengakses fitur baru meskipun permission-nya belum ditambahkan ke Role-nya
- ⚠️ Hanya berikan Role `super_admin` kepada orang yang **benar-benar dipercaya**
- ⚠️ Sistem hanya boleh memiliki **maksimal 2-3** akun Super Admin aktif
- ❌ Jangan hapus kode `Gate::before` ini — akan menyebabkan Super Admin terkunci dari sistem

---

## 🛠️ Penggunaan di Source Code

### 1. Memproteksi URL (Routes)

Tambahkan middleware `can:<nama_permission>` pada setiap route yang ingin dilindungi.

#### Proteksi Route Tunggal

```php
// routes/web.php

// Hanya user dengan permission 'view_dashboard' yang bisa akses
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('can:view_dashboard')
    ->name('admin.dashboard');
```

#### Proteksi Banyak Route Sekaligus (Grouping)

```php
// Semua route di dalam group ini memerlukan permission 'manage_projects'
Route::middleware(['auth', 'can:manage_projects'])->group(function () {
    Route::resource('projects', ProjectController::class);
    Route::get('/projects/export/pdf', [ProjectController::class, 'exportPdf'])
        ->name('admin.projects.export-pdf');
    Route::post('/projects/{project}/sync-gsheet', [ProjectController::class, 'syncGsheet'])
        ->name('admin.projects.sync-gsheet');
});
```

#### Proteksi Route dengan Multiple Middleware

```php
Route::get('/laporan-keuangan', [LaporanController::class, 'index'])
    ->middleware(['auth', 'verified', 'can:manage_earnings'])
    ->name('admin.laporan.keuangan');
```

---

### 2. Menyembunyikan Elemen UI (Blade)

Gunakan directive `@can` dan `@cannot` untuk mengontrol visibilitas elemen di template Blade.

#### Penggunaan Dasar `@can`

```blade
{{-- Tombol ini HANYA muncul jika user punya permission 'manage_admins' --}}
@can('manage_admins')
    <button class="btn btn-danger">
        <i class="fa-solid fa-trash"></i> Hapus Akun Admin
    </button>
@endcan
```

#### `@can` dengan Kondisi Alternatif (`@else`)

```blade
@can('manage_settings')
    <a href="{{ route('admin.settings') }}" class="btn btn-primary">
        Ubah Pengaturan Sistem
    </a>
@else
    <p class="text-muted">
        <i class="fa-solid fa-lock"></i> Anda tidak memiliki akses ke pengaturan sistem.
    </p>
@endcan
```

#### `@cannot` (Kebalikan dari `@can`)

```blade
{{-- Pesan peringatan ini muncul HANYA JIKA user TIDAK punya permission --}}
@cannot('manage_projects')
    <div class="alert alert-warning">
        Anda hanya dapat melihat data. Hubungi Super Admin untuk akses penuh.
    </div>
@endcannot
```

#### Kombinasi Beberapa Permission di Blade

```blade
{{-- Gunakan @if + can() helper untuk logika yang lebih kompleks --}}
@if(auth()->user()->can('manage_projects') || auth()->user()->can('manage_earnings'))
    <div class="financial-section">
        {{-- Konten keuangan --}}
    </div>
@endif
```

---

### 3. Pengecekan Izin di dalam Controller

Selain middleware di route, Anda juga bisa melakukan pengecekan manual di dalam Controller untuk logika yang lebih kompleks.

```php
// app/Http/Controllers/Admin/ProjectController.php

use Illuminate\Support\Facades\Gate;

public function destroy(Project $project)
{
    // Cara 1: authorize() — otomatis throw 403 jika tidak punya izin
    $this->authorize('manage_projects');

    // Cara 2: Gate::check() — untuk pengecekan kondisional
    if (Gate::check('manage_projects')) {
        // Lakukan sesuatu hanya jika punya izin
    }

    // Cara 3: can() / cannot() helper via User model
    if (auth()->user()->cannot('manage_projects')) {
        abort(403, 'Anda tidak berhak menghapus proyek ini.');
    }

    $project->delete();
    return redirect()->back()->with('success', 'Proyek berhasil dihapus.');
}
```

---

## 📜 Daftar Lengkap Permissions

> Berikut adalah seluruh daftar izin (permissions) yang terdaftar di sistem beserta penjelasan detailnya.

### A. 👁️ Hak Melihat (View Permissions)

Izin-izin ini memberikan akses **read-only** (hanya lihat) ke halaman atau informasi tertentu.

| Permission Key   | Deskripsi Lengkap                                                                                                   | Middleware Route     |
| ---------------- | ------------------------------------------------------------------------------------------------------------------- | -------------------- |
| `view_dashboard` | Mengakses halaman utama Dashboard Admin. Menampilkan ringkasan statistik, grafik aktivitas, dan notifikasi terbaru. | `can:view_dashboard` |
| `view_ikhtiar`   | Mengakses Ruang Ikhtiar — ruang motivasi dan refleksi internal tim Karyantara.                                      | `can:view_ikhtiar`   |
| `view_struktur`  | Melihat bagan Struktur Organisasi perusahaan secara visual (jabatan, divisi, dan hierarki).                         | `can:view_struktur`  |
| `view_visitors`  | Melihat data statistik lalu lintas pengunjung situs publik (pageview, unique visitor, sumber traffic).              | `can:view_visitors`  |

---

### B. ⚙️ Hak Mengelola (Manage Permissions)

Izin-izin ini memberikan akses **CRUD penuh** (buat, lihat, edit, hapus) pada modul tertentu.

| Permission Key        | Deskripsi Lengkap                                                                                                | Sensitif? |
| --------------------- | ---------------------------------------------------------------------------------------------------------------- | --------- |
| `manage_projects`     | Full CRUD klien, proyek, tagihan (invoice), status pembayaran, dan sinkronisasi data ke Google Sheets.           | 🟡 Sedang |
| `manage_earnings`     | Akses halaman riwayat "Pendapatan Saya", laporan keuangan, rekap honorarium, dan export data.                    | 🟡 Sedang |
| `manage_meetings`     | CRUD jadwal agenda rapat, notulensi, absensi peserta, dan cetak (print) dokumen rapat resmi.                     | 🟢 Rendah |
| `manage_portfolios`   | Menambah, mengedit, dan menghapus konten portofolio hasil kerja yang ditampilkan ke publik.                      | 🟢 Rendah |
| `manage_testimonials` | Meninjau, menyetujui (ACC), menolak, mengedit, dan mengatur auto-publish testimoni dari klien.                   | 🟢 Rendah |
| `manage_positions`    | CRUD daftar master data jabatan organisasi yang digunakan di seluruh sistem.                                     | 🟡 Sedang |
| `manage_admins`       | **(SANGAT SENSITIF)** Menambah/menghapus akun Admin lain, mengatur Role, dan mengonfigurasi seluruh sistem RBAC. | 🔴 Tinggi |
| `manage_settings`     | Mengubah pengaturan inti sistem Karyantara: nama perusahaan, logo, konfigurasi email, dan parameter global.      | 🔴 Tinggi |

---

### C. 🔧 Hak Menggunakan Tools (Use Permissions)

Izin-izin ini mengatur akses ke fitur-fitur tools atau alat bantu khusus.

| Permission Key           | Deskripsi Lengkap                                                                                  | Middleware Route             |
| ------------------------ | -------------------------------------------------------------------------------------------------- | ---------------------------- |
| `use_ai_calculator`      | Akses ke halaman Kalkulator AI — termasuk fitur kalkulasi cerdas dan Text Enhancement berbasis AI. | `can:use_ai_calculator`      |
| `use_pricing_calculator` | Akses ke halaman generator PDF Penawaran Harga Layanan — membuat dokumen penawaran resmi ke klien. | `can:use_pricing_calculator` |

---

### Ringkasan Matriks Permission per Role (Contoh Rekomendasi)

| Permission               | `super_admin` | `admin` | `finance` | `editor` | `staff` |
| ------------------------ | :-----------: | :-----: | :-------: | :------: | :-----: |
| `view_dashboard`         |     ✅\*      |   ✅    |    ✅     |    ✅    |   ✅    |
| `view_ikhtiar`           |     ✅\*      |   ✅    |    ✅     |    ✅    |   ✅    |
| `view_struktur`          |     ✅\*      |   ✅    |    ✅     |    ✅    |   ✅    |
| `view_visitors`          |     ✅\*      |   ✅    |    ✅     |    ❌    |   ❌    |
| `manage_projects`        |     ✅\*      |   ✅    |    ✅     |    ❌    |   ❌    |
| `manage_earnings`        |     ✅\*      |   ✅    |    ✅     |    ❌    |   ❌    |
| `manage_meetings`        |     ✅\*      |   ✅    |    ❌     |    ✅    |   ✅    |
| `manage_portfolios`      |     ✅\*      |   ✅    |    ❌     |    ✅    |   ❌    |
| `manage_testimonials`    |     ✅\*      |   ✅    |    ❌     |    ✅    |   ❌    |
| `manage_positions`       |     ✅\*      |   ✅    |    ❌     |    ❌    |   ❌    |
| `manage_admins`          |     ✅\*      |   ❌    |    ❌     |    ❌    |   ❌    |
| `manage_settings`        |     ✅\*      |   ❌    |    ❌     |    ❌    |   ❌    |
| `use_ai_calculator`      |     ✅\*      |   ✅    |    ✅     |    ✅    |   ❌    |
| `use_pricing_calculator` |     ✅\*      |   ✅    |    ✅     |    ❌    |   ❌    |

> **✅\*** = Bypass otomatis via God Mode (tidak perlu diceklis manual di UI)

---

## 🖥️ Manajemen Role & Permission via UI

Seluruh manajemen Role dan Permission dapat dilakukan melalui antarmuka web tanpa perlu menyentuh kode atau database secara langsung.

### Lokasi Menu

```
Panel Admin ──▶ Kelola Admin & RBAC ──▶ Tab "Role" / Tab "Hak Akses"
```

### Aksi yang Tersedia

| Aksi                         | Deskripsi                                                                       |
| ---------------------------- | ------------------------------------------------------------------------------- |
| **Buat Role Baru**           | Membuat peran baru dengan nama custom (misal: `hr_manager`)                     |
| **Edit Role**                | Mengubah nama Role yang sudah ada                                               |
| **Hapus Role**               | Menghapus Role (user yang memakai role tersebut perlu diupdate manual)          |
| **Atur Permission per Role** | Centang/uncentang permission yang dimiliki sebuah Role                          |
| **Assign Role ke User**      | Memberikan Role kepada akun admin tertentu                                      |
| **Deteksi Fitur Baru**       | Scan `routes/web.php` dan tambahkan permission baru ke database secara otomatis |

### Aturan Penting Manajemen Role

> ⚠️ **JANGAN** menghapus Role `super_admin`. Role ini adalah pondasi sistem keamanan.
>
> ⚠️ **JANGAN** menghapus Permission yang sedang aktif digunakan di Route. Akan menyebabkan error 403 bagi semua pengguna role terkait.
>
> ✅ Selalu **backup database** sebelum melakukan perubahan besar pada konfigurasi Role & Permission.

---

## 🔍 Auto-Discovery Seeder

Sistem RBAC Karyantara Solution dilengkapi mekanisme **Auto-Discovery** yang secara otomatis memindai semua middleware `can:` di `routes/web.php` dan mendaftarkannya ke database.

### Cara Kerja Auto-Discovery

```
Klik Tombol "Deteksi Fitur Baru"
          │
          ▼
Sistem membaca semua route di routes/web.php
          │
          ▼
Ekstrak semua string dari middleware can:<nama_permission>
          │
          ▼
Bandingkan dengan permission yang sudah ada di database
          │
          ▼
Tambahkan permission BARU yang belum ada ke tabel permissions
          │
          ▼
Tampilkan laporan: "X permission baru ditemukan dan ditambahkan"
```

### Keuntungan Auto-Discovery

- ✅ **Tidak perlu SSH / Terminal** di server produksi (cocok untuk shared hosting seperti InfinityFree)
- ✅ **Tidak perlu** menjalankan `php artisan db:seed` manual
- ✅ Mengurangi risiko human error saat penambahan fitur baru
- ✅ Super Admin bisa langsung assign permission baru ke Role tanpa restart server

---

## 🚀 SOP Penambahan Menu / Fitur Baru

Ikuti langkah-langkah ini secara berurutan setiap kali menambahkan halaman atau fitur baru ke sistem.

---

### Langkah 1 — Buat Route + Pasang Middleware `can:`

Edit file `routes/web.php` dan tambahkan route baru dengan middleware keamanan.

```php
// routes/web.php

// Contoh: Menambahkan fitur Laporan Tahunan
Route::middleware(['auth', 'can:manage_laporan_tahunan'])->group(function () {
    Route::get('/laporan-tahunan', [LaporanController::class, 'index'])
        ->name('admin.laporan-tahunan.index');
    Route::get('/laporan-tahunan/export', [LaporanController::class, 'export'])
        ->name('admin.laporan-tahunan.export');
});
```

> 📝 **Konvensi Penamaan Permission:**
>
> - Prefix `view_` untuk halaman read-only
> - Prefix `manage_` untuk halaman dengan CRUD
> - Prefix `use_` untuk tools/fitur khusus
> - Gunakan `snake_case`, semua huruf kecil
> - Pisahkan kata dengan underscore `_`

---

### Langkah 2 — Daftarkan ke Konfigurasi Navigasi

Edit file `config/navigation.php` agar menu baru muncul di Sidebar secara otomatis.

```php
// config/navigation.php

[
    'title'        => 'Laporan Tahunan',
    'route'        => 'admin.laporan-tahunan.index',
    'active_match' => 'admin.laporan-tahunan.*',    // Pola untuk active state
    'icon'         => 'fa-solid fa-chart-pie',       // Icon FontAwesome
    'permission'   => 'manage_laporan_tahunan',      // HARUS sama persis dengan middleware!
    'badge'        => null,                          // Opsional: badge counter
],
```

> ✅ Sistem navigasi akan **otomatis menyembunyikan** menu ini dari user yang tidak punya permission `manage_laporan_tahunan`.

---

### Langkah 3 — Buat Controller & View

```bash
# Buat Controller baru
php artisan make:controller Admin/LaporanController

# Buat View (opsional, jika menggunakan artisan)
php artisan make:view admin.laporan-tahunan.index
```

Pastikan Controller sudah memiliki method yang sesuai dengan route yang didefinisikan.

---

### Langkah 4 — Deploy ke Server Produksi

Upload / deploy semua file yang diubah:

```
✅ routes/web.php
✅ config/navigation.php
✅ app/Http/Controllers/Admin/LaporanController.php
✅ resources/views/admin/laporan-tahunan/ (folder view)
```

---

### Langkah 5 — Jalankan Auto-Discovery di Server

1. Login ke Panel Admin menggunakan akun **Super Admin**
2. Buka menu: **Kelola Admin & RBAC** → Tab **Role**
3. Temukan kotak **God Mode** di bagian atas halaman
4. Klik tombol **"Deteksi Fitur Baru"** (ikon rotate/sync ♻️)
5. Sistem akan menampilkan notifikasi: _"Permission `manage_laporan_tahunan` berhasil ditambahkan"_

---

### Langkah 6 — Assign Permission ke Role yang Sesuai

1. Masih di halaman **Kelola Admin & RBAC**
2. Klik **Edit** pada Role yang ingin mendapat akses (misal: `admin`)
3. Centang (✅) permission `manage_laporan_tahunan`
4. Klik **Simpan**

---

### ✅ Checklist Penambahan Fitur Baru

```
[ ] Route sudah dibuat di routes/web.php
[ ] Middleware can:<permission_baru> sudah dipasang di route
[ ] Permission key mengikuti konvensi penamaan (snake_case, prefix yang benar)
[ ] Menu sudah didaftarkan di config/navigation.php
[ ] Field 'permission' di navigation.php SAMA PERSIS dengan middleware di route
[ ] Controller & View sudah dibuat
[ ] Semua file sudah di-deploy ke server
[ ] Tombol "Deteksi Fitur Baru" sudah diklik di server produksi
[ ] Permission baru sudah diassign ke Role yang sesuai
[ ] Diuji dengan akun yang punya role tersebut
[ ] Diuji dengan akun yang TIDAK punya role tersebut (harus muncul 403)
```

---

## ⚙️ Konfigurasi Navigasi (config/navigation.php)

File ini adalah **pusat konfigurasi tampilan Sidebar** Panel Admin. Setiap item menu yang terdaftar di sini akan dikontrol visibilitasnya secara otomatis berdasarkan permission pengguna yang sedang login.

### Struktur Lengkap Item Navigasi

```php
// config/navigation.php

return [
    'menu' => [

        // ── SECTION: Dashboard ─────────────────────────────
        [
            'title'        => 'Dashboard',
            'route'        => 'admin.dashboard',
            'active_match' => 'admin.dashboard',
            'icon'         => 'fa-solid fa-gauge-high',
            'permission'   => 'view_dashboard',
            'badge'        => null,
        ],

        // ── SECTION: Proyek & Klien ────────────────────────
        [
            'title'        => 'Manajemen Proyek',
            'route'        => 'admin.projects.index',
            'active_match' => 'admin.projects.*',
            'icon'         => 'fa-solid fa-diagram-project',
            'permission'   => 'manage_projects',
            'badge'        => null,
        ],

        // ── SECTION: Keuangan ──────────────────────────────
        [
            'title'        => 'Pendapatan Saya',
            'route'        => 'admin.earnings.index',
            'active_match' => 'admin.earnings.*',
            'icon'         => 'fa-solid fa-money-bill-trend-up',
            'permission'   => 'manage_earnings',
            'badge'        => null,
        ],

        // ── SECTION: Tools ─────────────────────────────────
        [
            'title'        => 'Kalkulator AI',
            'route'        => 'admin.ai-calculator.index',
            'active_match' => 'admin.ai-calculator.*',
            'icon'         => 'fa-solid fa-robot',
            'permission'   => 'use_ai_calculator',
            'badge'        => 'NEW',
        ],

        // ── SECTION: Administrasi ──────────────────────────
        [
            'title'        => 'Kelola Admin & RBAC',
            'route'        => 'admin.rbac.index',
            'active_match' => 'admin.rbac.*',
            'icon'         => 'fa-solid fa-user-shield',
            'permission'   => 'manage_admins',
            'badge'        => null,
        ],

    ],
];
```

### Cara Sistem Membaca Konfigurasi Ini (di Blade)

```blade
{{-- resources/views/layouts/admin/sidebar.blade.php --}}

@foreach(config('navigation.menu') as $item)
    @can($item['permission'])
        <li class="nav-item {{ request()->routeIs($item['active_match']) ? 'active' : '' }}">
            <a class="nav-link" href="{{ route($item['route']) }}">
                <i class="{{ $item['icon'] }}"></i>
                <span>{{ $item['title'] }}</span>
                @if($item['badge'])
                    <span class="badge badge-pill badge-primary">{{ $item['badge'] }}</span>
                @endif
            </a>
        </li>
    @endcan
@endforeach
```

---

## 🔧 Troubleshooting & FAQ

### ❓ "User saya mendapat error 403 padahal sudah diberi Role yang benar"

**Kemungkinan penyebab & solusi:**

1. **Cache permission belum direfresh**

    ```php
    // Jalankan di Tinker atau buat route debug sementara
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    ```

2. **Nama permission di route TIDAK SAMA dengan yang ada di database**
    - Cek ejaan di `routes/web.php` vs tabel `permissions` di database
    - Nama bersifat case-sensitive: `manage_Projects` ≠ `manage_projects`

3. **Role belum di-assign ke user tersebut**
    - Cek di halaman Kelola Admin & RBAC → Tab User → Edit user tersebut

4. **Tombol "Deteksi Fitur Baru" belum diklik setelah deploy**
    - Permission baru tidak akan otomatis ada di database sebelum Auto-Discovery dijalankan

---

### ❓ "Menu di Sidebar tetap muncul meskipun permission sudah dihapus dari Role"

**Penyebab:** Cache view atau cache config Laravel belum dibersihkan.

```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

> Di shared hosting tanpa akses terminal, cukup tunggu 5-10 menit atau hapus file cache di `storage/framework/cache/` dan `storage/framework/views/` via File Manager.

---

### ❓ "Bagaimana cara membuat Role dengan akses terbatas hanya ke 2-3 fitur?"

1. Buka **Kelola Admin & RBAC** → Tab **Role** → Klik **Tambah Role Baru**
2. Beri nama Role (contoh: `content_writer`)
3. Pada form permission, **hanya centang** permission yang diinginkan (misal: `manage_portfolios` dan `manage_testimonials`)
4. Simpan Role
5. Assign Role tersebut ke akun admin yang bersangkutan

---

### ❓ "Apakah satu user bisa memiliki lebih dari satu Role?"

**Ya.** `spatie/laravel-permission` mendukung multiple roles per user. Permission yang berlaku adalah **gabungan (union)** dari semua permission yang dimiliki seluruh Role user tersebut.

```php
// Contoh: Memberikan multiple role ke satu user
$user->assignRole(['editor', 'finance']);

// Cek apakah user punya salah satu dari dua role
$user->hasAnyRole(['admin', 'finance']); // true
```

---

### ❓ "Apakah aman menambah Permission langsung via database tanpa Auto-Discovery?"

**Tidak disarankan.** Selalu gunakan mekanisme Auto-Discovery agar konsistensi antara kode (route) dan database terjaga. Menambah permission manual ke database tanpa ada pasangan middleware di route tidak akan berpengaruh pada keamanan (tidak ada yang bisa menggunakannya), namun akan mencemari daftar permission dengan data sampah.

---

## 📎 Referensi & Catatan Penting

### Referensi Teknis

| Sumber                                | Link                                      |
| ------------------------------------- | ----------------------------------------- |
| Dokumentasi Spatie Laravel Permission | https://spatie.be/docs/laravel-permission |
| Laravel Authorization (Gate & Policy) | https://laravel.com/docs/authorization    |
| Laravel Middleware                    | https://laravel.com/docs/middleware       |

### Konvensi Penamaan Permission (Wajib Diikuti)

```
Format   : {prefix}_{nama_fitur}
Contoh   : manage_laporan_tahunan
           view_statistik_klien
           use_ai_text_enhancer

Prefix yang valid:
  - view_    : Hanya akses baca / lihat
  - manage_  : Akses CRUD penuh
  - use_     : Akses menggunakan tools/fitur

Aturan:
  ✅ Semua huruf kecil (lowercase)
  ✅ Kata dipisah underscore (_)
  ✅ Deskriptif dan spesifik
  ❌ Jangan gunakan spasi atau tanda baca lain
  ❌ Jangan gunakan camelCase atau PascalCase
```

### Versi Package yang Digunakan

```json
{
    "require": {
        "spatie/laravel-permission": "^6.0",
        "laravel/framework": "^11.0"
    }
}
```

---

<div align="center">

📁 Simpan file ini di: `docs/RBAC.md` atau gabungkan ke `README.md` utama project

---

**Karyantara Solution** — _Panel Admin v2.0_

_Dokumentasi ini adalah bagian dari source code internal Karyantara Solution._
_Harap jaga kerahasiaannya dan jangan bagikan ke pihak yang tidak berwenang._

</div>
