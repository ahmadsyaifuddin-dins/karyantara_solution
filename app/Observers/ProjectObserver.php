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
            $project->id,                                 // A: 0
            $project->client_type,                        // B: 1
            $project->client_name,                        // C: 2
            $project->skripsi_package ?? '-',             // D: 3
            $project->npm ?? '-',                         // E: 4
            $project->class_name ?? '-',                  // F: 5 (BARU)
            $project->dospem_1 ?? '-',                    // G: 6 (BARU)
            $project->dospem_2 ?? '-',                    // H: 7 (BARU)
            $project->skripsi_title ?? '-',               // I: 8
            $project->project_description ?? '-',         // J: 9 (BARU)
            $project->programmer_id ?? '-',               // K: 10 (BARU)
            $project->writer_id ?? '-',                   // L: 11 (BARU)
            $project->status,                             // M: 12
            $project->revision_notes ?? '-',              // N: 13 (BARU)
            $project->net_income,                         // O: 14
            $project->paid_amount,                        // P: 15
            $sisa_pembayaran,                             // Q: 16
            $project->payment_method,                     // R: 17
            $project->created_at ? $project->created_at->format('Y-m-d H:i:s') : '-', // S: 18
        ];
    }

    public function created(Project $project): void
    {
        // Ambil value dari setting (berupa string '0' atau '1')
        $autoSync = Setting::where('key', 'auto_sync_sheet')->value('value');

        // Jika bukan '1' (mati), hentikan proses
        if ($autoSync !== '1') {
            return;
        }

        if ($project->is_shared) {
            $this->googleSheetService->appendData('Sheet1!A:S', [$this->mapProjectData($project)]);
        }
    }

    public function updated(Project $project): void
    {
        $autoSync = Setting::where('key', 'auto_sync_sheet')->value('value');

        if ($autoSync !== '1') {
            return;
        }

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
