<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\Setting;
use App\Services\GoogleSheetService;

class ProjectObserver
{
    protected $googleSheetService;

    public function __construct(GoogleSheetService $googleSheetService)
    {
        $this->googleSheetService = $googleSheetService;
    }

    private function mapProjectData(Project $project)
    {
        $sisa_pembayaran = $project->net_income - $project->paid_amount;

        return [
            '=ROW()-1',                                   // A: 0 (NOMOR URUT OTOMATIS)
            $project->id,                                 // B: 1
            $project->client_type,                        // C: 2
            $project->client_name,                        // D: 3
            $project->skripsi_package ?? '-',             // E: 4
            $project->npm ?? '-',                         // F: 5
            $project->class_name ?? '-',                  // G: 6
            $project->dospem_1 ?? '-',                    // H: 7
            $project->dospem_2 ?? '-',                    // I: 8
            $project->skripsi_title ?? '-',               // J: 9
            $project->project_description ?? '-',         // K: 10
            $project->programmer ? $project->programmer->name : '-', // L: 11 (PERBAIKAN BUG NAMA)
            $project->writer ? $project->writer->name : '-',         // M: 12 (PERBAIKAN BUG NAMA)
            $project->status,                             // N: 13
            $project->revision_notes ?? '-',              // O: 14
            $project->net_income,                         // P: 15 (HARGA SEKARANG DI P)
            $project->paid_amount,                        // Q: 16
            $sisa_pembayaran,                             // R: 17
            $project->payment_method,                     // S: 18
            $project->created_at ? $project->created_at->format('Y-m-d H:i:s') : '-', // T: 19
        ];
    }

    public function created(Project $project): void
    {
        $autoSync = Setting::where('key', 'auto_sync_sheet')->value('value');
        if ($autoSync !== '1') return;

        if ($project->is_shared) {
            // Jangkauan diubah jadi A:T
            $this->googleSheetService->appendData('Sheet1!A:T', [$this->mapProjectData($project)]);
        }
    }

    public function updated(Project $project): void
    {
        $autoSync = Setting::where('key', 'auto_sync_sheet')->value('value');
        if ($autoSync !== '1') return;

        if ($project->is_shared) {
            $this->googleSheetService->updateDataById('Sheet1', $project->id, [$this->mapProjectData($project)]);
        } else {
            $this->googleSheetService->clearRowById('Sheet1', $project->id);
        }
    }

    public function deleted(Project $project): void
    {
        // Biarkan kosong untuk history, KECUALI Anda ingin menghapusnya juga.
    }
}
