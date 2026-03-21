<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Services\GoogleSheetService;
use Illuminate\Console\Command;

class SyncProjectsToGoogleSheet extends Command
{
    // Ini nama perintah yang akan kita ketik di terminal nanti
    protected $signature = 'project:sync-sheet';

    // Deskripsi perintah
    protected $description = 'Sinkronisasi seluruh data Klien & Proyek ke Google Sheet';

    public function handle(GoogleSheetService $googleSheetService)
    {
        $this->info('Memulai sinkronisasi data ke Google Sheet...');

        // HANYA AMBIL YANG is_shared = 1
        $projects = Project::where('is_shared', 1)->get();

        if ($projects->isEmpty()) {
            $this->warn('Tidak ada data proyek publik di database untuk disinkronisasi.');

            return;
        }

        $values = [];

        // HEADER SEKARANG ADA 19 KOLOM (A sampai S)
        $values[] = [
            'ID', 'TIPE KLIEN', 'NAMA KLIEN', 'PAKET', 'NPM', 'KELAS', 'DOSPEM 1', 'DOSPEM 2',
            'JUDUL SKRIPSI', 'DESKRIPSI PROYEK', 'PROGRAMMER ID', 'WRITER ID',
            'STATUS', 'CATATAN REVISI', 'TOTAL HARGA', 'TERBAYARKAN', 'SISA TAGIHAN', 'METODE', 'TANGGAL DIBUAT',
        ];

        foreach ($projects as $project) {
            $sisa_pembayaran = $project->net_income - $project->paid_amount;

            $values[] = [
                $project->id,
                $project->client_type,
                $project->client_name,
                $project->skripsi_package ?? '-',
                $project->npm ?? '-',
                $project->class_name ?? '-',
                $project->dospem_1 ?? '-',
                $project->dospem_2 ?? '-',
                $project->skripsi_title ?? '-',
                $project->project_description ?? '-',
                $project->programmer_id ?? '-',
                $project->writer_id ?? '-',
                $project->status,
                $project->revision_notes ?? '-',
                $project->net_income,
                $project->paid_amount,
                $sisa_pembayaran,
                $project->payment_method,
                $project->created_at ? $project->created_at->format('Y-m-d H:i:s') : '-',
            ];
        }

        $googleSheetService->syncAllData('Sheet1', $values);

        $this->info('Berhasil! '.count($projects).' data proyek publik telah disinkronkan.');
    }
}
