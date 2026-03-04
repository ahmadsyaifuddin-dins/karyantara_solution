<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;

class ValidationController extends Controller
{
    public function invoice($id, $hash)
    {
        // 1. Buat ulang hash rahasia berdasarkan ID dan APP_KEY server
        $expectedHash = substr(md5($id.config('app.key')), 0, 8);

        // 2. Jika hash di URL tidak sama persis, tendang!
        if ($hash !== $expectedHash) {
            abort(403, 'AKSES DITOLAK: Tautan validasi tidak sah, kedaluwarsa, atau telah dimanipulasi.');
        }

        // 3. Jika aman, baru cari datanya
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
