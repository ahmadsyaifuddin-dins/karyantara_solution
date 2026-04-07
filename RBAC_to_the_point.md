# 🚀 SOP Cepat: Menambah Menu & Fitur Baru

**RBAC Karyantara Solution** — Simpan file ini, baca kalau lupa!

---

## 💡 Aturan Penamaan Izin (PREFIX)

Tentukan dulu seberapa besar aksesnya, baru buat route.

| Prefix           | Kapan dipakai                        | Contoh                                         |
| ---------------- | ------------------------------------ | ---------------------------------------------- |
| `view_...`       | Hanya lihat halaman, tanpa ubah data | `view_statistik`                               |
| `manage_...`     | CRUD penuh (Tambah, Edit, Hapus)     | `manage_laporan`                               |
| `use_...`        | Memakai alat / generator khusus      | `use_kalkulator`                               |
| **Custom bebas** | Aksi spesifik di luar kategori atas  | `export_pdf_keuangan`, `approve_cuti_karyawan` |

> ✅ Selalu **huruf kecil** dan pisah kata dengan **underscore** `_`. Jangan pakai spasi atau huruf kapital.

---

## 🛠️ Langkah Eksekusi (4 Step)

### Step 1 — Daftarkan Route & Izin (`routes/web.php`)

Pasang middleware `can:nama_izin_baru` di route yang baru dibuat.

```php
// Contoh: izin baru bernama 'export_pdf_laporan'
Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])
    ->middleware('can:export_pdf_laporan')
    ->name('admin.laporan.cetak');
```

---

### Step 2 — Tambahkan ke Sidebar (`config/navigation.php`)

Tambahkan array menu baru ke dalam `groups`. Field `permission` **harus sama persis** dengan middleware di Step 1.

```php
[
    'title'        => 'Cetak Laporan Keuangan',
    'route'        => 'admin.laporan.cetak',
    'active_match' => 'admin.laporan.*',
    'icon'         => 'fa-solid fa-file-pdf',
    'permission'   => 'export_pdf_laporan',   // ← Harus identik!
],
```

> 💬 **Tips:** Minta bantuan AI — _"Buatkan config navigation array untuk fitur Cetak Laporan, permission: export_pdf_laporan"_ — lalu copy-paste hasilnya.

---

### Step 3 — Jalankan Auto-Discovery (UI Web)

Tidak perlu SSH / terminal. Cukup lewat browser:

1. Buka **`https://karyantara-solution.com/admin/roles`**
2. Login sebagai **Super Admin**
3. Di kotak **"God Mode"** (paling atas), klik tombol **♻️ "Deteksi Fitur Baru"**
4. Konfirmasi → klik **"Ya, Sinkronkan"**

Sistem akan memindai `web.php` dan otomatis memasukkan `export_pdf_laporan` ke database.

---

### Step 4 — Berikan Hak Akses ke Role

Masih di halaman yang sama:

1. Scroll ke Role yang ingin diberi akses (misal: `admin`)
2. **Centang** izin baru yang baru saja muncul
3. Klik **"Simpan Hak Akses"**

---

## ✅ Selesai!

Fitur baru sudah terkunci rapat. Hanya Role yang dicentang yang bisa mengaksesnya.

```
Route ──▶ Middleware can: ──▶ Auto-Discovery ──▶ Assign ke Role ──▶ Beres 🎉
```

---

> 📁 Simpan file ini di: `RBAC_to_the_point.md`
> Untuk dokumentasi lengkap → lihat `RBAC.md`
