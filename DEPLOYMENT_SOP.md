# 🚀 SOP Deployment Assets — Karyantara Solution

> Dokumentasi standar untuk memperbarui aset (CSS & JS) pada hosting InfinityFree agar terhindar dari error _404 Not Found_ atau tampilan yang tidak ter-update akibat sistem _hashing_ Vite.

---

## 🛠️ Prasyarat

Sebelum memulai, pastikan kondisi berikut sudah terpenuhi:

- ✅ Perubahan kode telah selesai dilakukan (Tailwind CSS, Alpine.js, atau modul JS lainnya)
- ✅ Akses FTP (FileZilla atau sejenisnya) ke server InfinityFree sudah siap

---

## 📋 Langkah-langkah Deployment

### Langkah 1 — Kompilasi Aset di Lokal

Jalankan perintah build di terminal/command prompt lokal untuk menghasilkan file produksi yang teroptimasi.

```bash
npm run build
```

> Vite akan memperbarui file di folder `public/build/` dan memperbarui `manifest.json`.

---

### Langkah 2 — Bersihkan Folder Build di Server

> ⚠️ **PENTING:** Jangan langsung menimpa _(overwrite)_ folder lama.

1. Buka koneksi FTP
2. Masuk ke direktori: `/htdocs/`
3. **Hapus sepenuhnya** folder `build` yang ada di sana

Langkah ini memastikan tidak ada file sampah _(hash lama)_ yang menumpuk di hosting.

---

### Langkah 3 — Unggah Folder Build Baru

Upload folder `build` yang baru saja dihasilkan dari lokal (`/public/build/`) ke dalam direktori `/htdocs/` di server.

Pastikan struktur akhirnya adalah:

```
/htdocs/build/manifest.json
```

---

### Langkah 4 — Verifikasi

1. Buka website **Karyantara Solution**
2. Lakukan **Hard Refresh** (`Ctrl + F5`) pada browser untuk membersihkan cache lama
3. Jika tampilan sudah sesuai → ✅ proses update **berhasil**

---

## ⚠️ Catatan Penting

### Kenapa Harus Hapus Folder Dulu?

Vite menggunakan _unique hash_ pada setiap build (contoh: `app-DVkcuqvs.css`). Jika folder lama tidak dihapus, `manifest.json` yang baru akan mencari file dengan nama yang berbeda dari yang tersimpan di server — menyebabkan tampilan "hancur".

### Asset Helper

Pastikan layout tetap menggunakan komponen `<x-assets />` yang sudah dikonfigurasi untuk membaca path dinamis di shared hosting.
