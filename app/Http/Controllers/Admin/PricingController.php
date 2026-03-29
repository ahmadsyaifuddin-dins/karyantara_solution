<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan library ini sudah di-use

class PricingController extends Controller
{
    /**
     * Menampilkan halaman kalkulator.
     */
    public function index()
    {
        return view('admin.pricing.index');
    }

    /**
     * Memproses data dari form dan meng-generate PDF.
     */
    public function generatePdf(Request $request)
    {
        // Validasi data yang dikirim dari Alpine.js
        $data = $request->validate([
            'client_name' => 'nullable|string',
            'paket_nama'  => 'required|string',
            'sumber_app'  => 'required|string',
            'kesulitan'   => 'required|string',
            'min_price'   => 'required|numeric',
            'max_price'   => 'required|numeric',
        ]);

        // Kita buat "dummy" object project agar component signature.blade.php kamu bisa berjalan normal
        // Karena view signature butuh $project->client_name, dll.
        $project = (object) [
            'id'          => 'EST-' . rand(1000, 9999), 
            'client_name' => $data['client_name'] ?: 'Klien (Belum Bernama)',
            'client_type' => 'umum',
            'npm'         => '-'
        ];

        // Load view PDF
        $pdf = Pdf::loadView('admin.pricing.pricing-pdf', compact('data', 'project'))
        ->setOptions([
                'chroot'  => base_path(),              // Izinkan baca folder laravel
                'tempDir' => storage_path('app')       // Hindari folder /tmp server yang sering diblokir
        ])
        ->setPaper('A4', 'portrait');
        
        // Return stream agar PDF terbuka di tab baru (bukan auto-download)
        return $pdf->stream('Penawaran_Karyantara_' . date('Ymd') . '.pdf');
    }
}