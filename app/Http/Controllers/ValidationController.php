<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;

class ValidationController extends Controller
{
    public function invoice($id, $hash)
    {
        $expectedHash = substr(md5($id.config('app.key')), 0, 8);

        if ($hash !== $expectedHash) {
            abort(403, 'AKSES DITOLAK: Tautan validasi tidak sah, kedaluwarsa, atau telah dimanipulasi.');
        }

        if (str_starts_with($id, 'EST-')) {
            return view('validation.estimate', compact('id'));
        }

        $project = Project::with('admin')->findOrFail($id);
        
        // 1. Tangkap parameter dari URL (default ke 'admin' jika kosong)
        $scanType = request()->query('scan_type', 'admin');

        // 2. Logika Pengecekan Eksekutif
        $isExecutive = false;
        $executiveRole = null;

        if ($project->admin) {
            if ($project->admin->name === 'Ahmad Syaifuddin') {
                $isExecutive = true;
                $executiveRole = 'Co-Founder & Chief Technology Officer';
            } elseif ($project->admin->name === 'Abdan Mustaqim Wardana') {
                $isExecutive = true;
                $executiveRole = 'Co-Founder & Chief Executive Officer';
            }
        }

        return view('validation.invoice', compact('project', 'isExecutive', 'executiveRole', 'scanType'));
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