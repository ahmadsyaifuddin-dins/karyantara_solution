<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MyEarningsExport;
use App\Services\EarningsService;

class MyEarningsController extends Controller
{
    protected $earningsService;

    public function __construct(EarningsService $earningsService)
    {
        $this->earningsService = $earningsService;
    }

    public function index(Request $request)
    {
        $userId = auth()->id();
        $selectedMonth = $request->input('month', 'all');
        $selectedYear = $request->input('year', date('Y'));

        // Panggil Service (Kalkulasi Otomatis!)
        $stats = $this->earningsService->getPersonalStats($userId, $selectedMonth, $selectedYear);
        
        $years = range(2024, date('Y'));

        // Gabungkan array $stats ke view
        return view('admin.earnings.index', array_merge(compact(
            'selectedMonth', 'selectedYear', 'years'
        ), $stats));
    }

    public function toggleEarningStatus(Request $request, Project $project)
    {
        $type = $request->input('type'); 
        $userId = auth()->id();

        if ($type === 'programmer' && $project->programmer_id == $userId) {
            $project->update(['is_programmer_paid' => !$project->is_programmer_paid]);
            $msg = $project->is_programmer_paid ? 'Fee Skripsi ditandai cair!' : 'Fee Skripsi ditandai belum cair.';
            return back()->with('success', $msg);
        }

        if ($type === 'writer' && $project->writer_id == $userId) {
            $project->update(['is_writer_paid' => !$project->is_writer_paid]);
            $msg = $project->is_writer_paid ? 'Fee Naskah ditandai cair!' : 'Fee Naskah ditandai belum cair.';
            return back()->with('success', $msg);
        }

        if ($type === 'umum') {
            $team = is_string($project->custom_team) ? json_decode($project->custom_team, true) : $project->custom_team;
            $updated = false;
            $statusPaid = false;

            if (is_array($team)) {
                foreach ($team as &$member) {
                    if (isset($member['user_id']) && $member['user_id'] == $userId) {
                        $member['is_paid'] = isset($member['is_paid']) ? !$member['is_paid'] : true;
                        $statusPaid = $member['is_paid'];
                        $updated = true;
                        break;
                    }
                }
            }

            if ($updated) {
                $project->update(['custom_team' => $team]);
                $msg = $statusPaid ? 'Fee Corporate ditandai cair!' : 'Fee Corporate ditandai belum cair.';
                return back()->with('success', $msg);
            }
        }

        return back()->with('error', 'Akses ditolak.');
    }

    public function exportPdf(Request $request)
    {
        $userId = auth()->id();
        $selectedMonth = $request->input('month', 'all');
        $selectedYear = $request->input('year', date('Y'));

        // Gunakan service agar PDF juga dapat data Corporate dengan mudah
        $stats = $this->earningsService->getPersonalStats($userId, $selectedMonth, $selectedYear);

        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $periode = ($selectedMonth == 'all' ? 'Semua Bulan' : $bulanIndo[(int)$selectedMonth]) . ' ' . ($selectedYear == 'all' ? 'Semua Tahun' : $selectedYear);

        $pdf = Pdf::loadView('admin.earnings.pdf', array_merge(compact('periode'), $stats))
            ->setOptions(['chroot' => base_path(), 'tempDir' => storage_path('app')]);
        
        $pdf->setPaper('A4', 'portrait');
        $namaUser = str_replace(' ', '_', auth()->user()->name);
        $waktuDownload = now()->locale('id')->translatedFormat('l_d_F_Y_H_i'); 
        
        return $pdf->stream('Slip_Karyantara_' . $namaUser . '_' . $waktuDownload . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $selectedMonth = $request->input('month', 'all');
        $selectedYear = $request->input('year', date('Y'));
        $fileName = 'Rekap_Pendapatan_' . auth()->user()->name . '_' . $selectedMonth . '_' . $selectedYear . '.xlsx';
        
        return Excel::download(new MyEarningsExport($selectedMonth, $selectedYear, auth()->id()), $fileName);
    }
}