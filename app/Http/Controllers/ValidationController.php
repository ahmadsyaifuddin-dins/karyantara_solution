<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;

class ValidationController extends Controller
{
    public function invoice($id, $hash)
    {
        // 1. Buat ulang hash rahasia berdasarkan ID (entah itu ID Project atau ID EST-) dan APP_KEY
        $expectedHash = substr(md5($id.config('app.key')), 0, 8);

        // 2. Jika hash di URL tidak sama persis, langsung tendang!
        if ($hash !== $expectedHash) {
            abort(403, 'AKSES DITOLAK: Tautan validasi tidak sah, kedaluwarsa, atau telah dimanipulasi.');
        }

        // 3. Hash aman! Sekarang cek apakah ini dari Kalkulator Estimasi
        if (str_starts_with($id, 'EST-')) {
            // Langsung return view validasi estimasi, TANPA query ke database
            return view('validation.estimate', compact('id'));
        }

        // 4. Jika bukan 'EST-', berarti ini dokumen project asli. Cari datanya di DB!
        $project = Project::findOrFail($id);

        return view('validation.invoice', compact('project'));
    }

    public function rekap($date, $hash)
    {
        // Amankan juga halaman rekap dengan cara yang sama
        $expectedHash = substr(md5($date.config('app.key')), 0, 8);

        if ($hash !== $expectedHash) {
            abort(403, 'AKSES DITOLAK: Tautan validasi tidak sah atau telah dimanipulasi.');
        }

        $formattedDate = Carbon::parse($date)->locale('id')->translatedFormat('d F Y');

        return view('validation.rekap', compact('date', 'formattedDate'));
    }
}