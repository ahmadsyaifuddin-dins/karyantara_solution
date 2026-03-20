<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Project;
use App\Models\PageView;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MyEarningsExport;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. STATISTIK KEUANGAN GLOBAL (KARYANTARA)
        $totalRevenue = Project::sum('net_income');
        $appRevenue = Project::sum('app_price'); // Total omset dari bikin aplikasi
        $writerRevenue = Project::sum('writer_price'); // Total omset dari bikin naskah

        // STATISTIK UMUM
        $activeProjects = Project::where('status', '!=', 'Selesai')->count();
        $pendingTestimonials = Testimonial::where('is_approved', 0)->count();
        $totalVisitors = PageView::count();

        // 2. STATISTIK PRIBADI (PENDAPATAN ADMIN YANG SEDANG LOGIN)
        $userId = auth()->id();
        
        // Sebagai Programmer (Aplikasi)
        $myAppProjectsCount = Project::where('programmer_id', $userId)->count();
        $myAppEarnings = Project::where('programmer_id', $userId)->sum('app_price');
        
        // Sebagai Writer (Naskah)
        $myWriterProjectsCount = Project::where('writer_id', $userId)->count();
        $myWriterEarnings = Project::where('writer_id', $userId)->sum('writer_price');
        
        // Total Pendapatan Pribadi
        $myTotalEarnings = $myAppEarnings + $myWriterEarnings;
        $myTotalProjects = $myAppProjectsCount + $myWriterProjectsCount;

        // 3. DATA TABEL PROYEK TERBARU (5 Teratas)
        $recentProjects = Project::latest()->take(5)->get();

        // 4. FITUR ADMIN ONLINE
        $onlineAdmins = User::select('users.*')
            ->addSelect(['last_seen' => DB::table('sessions')
                ->select('last_activity')
                ->whereColumn('user_id', 'users.id')
                ->orderByDesc('last_activity')
                ->limit(1)
            ])
            ->orderByDesc('last_seen')
            ->get();

        return view('dashboard', compact(
            'totalRevenue', 'appRevenue', 'writerRevenue',
            'activeProjects', 
            'pendingTestimonials', 
            'totalVisitors', 
            'myAppProjectsCount', 'myAppEarnings',
            'myWriterProjectsCount', 'myWriterEarnings',
            'myTotalEarnings', 'myTotalProjects',
            'recentProjects', 
            'onlineAdmins'
        ));
    }

    public function myEarnings(Request $request)
    {
        $userId = auth()->id();
        
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));

        $appQuery = Project::where('programmer_id', $userId);
        $writerQuery = Project::where('writer_id', $userId);

        if ($selectedMonth != 'all') {
            $appQuery->whereMonth('created_at', $selectedMonth);
            $writerQuery->whereMonth('created_at', $selectedMonth);
        }
        if ($selectedYear != 'all') {
            $appQuery->whereYear('created_at', $selectedYear);
            $writerQuery->whereYear('created_at', $selectedYear);
        }

        // DATA PROGRAMMER
        $appProjects = $appQuery->orderBy('created_at', 'desc')->get();
        $totalAppEarnings = $appProjects->sum('app_price');
        $unpaidAppEarnings = $appProjects->where('is_programmer_paid', false)->sum('app_price'); 
        
        // Kalkulasi khusus proyek SELESAI
        $completedAppProjects = $appProjects->where('status', 'Selesai');
        $completedAppEarnings = $completedAppProjects->sum('app_price');

        // DATA WRITER
        $writerProjects = $writerQuery->orderBy('created_at', 'desc')->get();
        $totalWriterEarnings = $writerProjects->sum('writer_price');
        $unpaidWriterEarnings = $writerProjects->where('is_writer_paid', false)->sum('writer_price');

        // Kalkulasi khusus proyek SELESAI
        $completedWriterProjects = $writerProjects->where('status', 'Selesai');
        $completedWriterEarnings = $completedWriterProjects->sum('writer_price');

        // TOTAL KESELURUHAN
        $totalEarnings = $totalAppEarnings + $totalWriterEarnings;
        $totalUnpaidEarnings = $unpaidAppEarnings + $unpaidWriterEarnings; 
        $totalProjects = $appProjects->count() + $writerProjects->count();

        // TOTAL ESTIMASI CAIR (DARI PROYEK YANG SUDAH SELESAI)
        $totalCompletedEarnings = $completedAppEarnings + $completedWriterEarnings;
        $totalCompletedProjects = $completedAppProjects->count() + $completedWriterProjects->count();

        $years = range(2024, date('Y'));

        return view('admin.earnings.index', compact(
            'appProjects', 'totalAppEarnings', 'unpaidAppEarnings', 'completedAppEarnings',
            'writerProjects', 'totalWriterEarnings', 'unpaidWriterEarnings', 'completedWriterEarnings',
            'totalEarnings', 'totalUnpaidEarnings', 'totalProjects',
            'totalCompletedEarnings', 'totalCompletedProjects', // Variabel Baru
            'selectedMonth', 'selectedYear', 'years'
        ));
    }

    // METHOD BARU: Untuk mengubah status cair/belum
    public function toggleEarningStatus(Request $request, Project $project)
    {
        $type = $request->input('type'); // 'programmer' atau 'writer'
        $userId = auth()->id();

        if ($type === 'programmer' && $project->programmer_id == $userId) {
            $project->update(['is_programmer_paid' => !$project->is_programmer_paid]);
            $msg = $project->is_programmer_paid ? 'Fee Aplikasi ditandai sudah cair/diterima!' : 'Fee Aplikasi ditandai belum diterima.';
            return back()->with('success', $msg);
        }

        if ($type === 'writer' && $project->writer_id == $userId) {
            $project->update(['is_writer_paid' => !$project->is_writer_paid]);
            $msg = $project->is_writer_paid ? 'Fee Naskah ditandai sudah cair/diterima!' : 'Fee Naskah ditandai belum diterima.';
            return back()->with('success', $msg);
        }

        return back()->with('error', 'Akses ditolak.');
    }

    public function exportEarningsPdf(Request $request)
    {
        $userId = auth()->id();
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));

        // Query Dasar
        $appQuery = Project::where('programmer_id', $userId);
        $writerQuery = Project::where('writer_id', $userId);

        // Filter
        if ($selectedMonth != 'all') {
            $appQuery->whereMonth('created_at', $selectedMonth);
            $writerQuery->whereMonth('created_at', $selectedMonth);
        }
        if ($selectedYear != 'all') {
            $appQuery->whereYear('created_at', $selectedYear);
            $writerQuery->whereYear('created_at', $selectedYear);
        }

        $appProjects = $appQuery->orderBy('created_at', 'desc')->get();
        $writerProjects = $writerQuery->orderBy('created_at', 'desc')->get();

        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        
        $periode = ($selectedMonth == 'all' ? 'Semua Bulan' : $bulanIndo[(int)$selectedMonth]) . ' ' . ($selectedYear == 'all' ? 'Semua Tahun' : $selectedYear);

        $pdf = Pdf::loadView('admin.earnings.pdf', compact('appProjects', 'writerProjects', 'periode'))
        ->setOptions([
                      'chroot'  => base_path(),             
                      'tempDir' => storage_path('app')      
                  ]);
        
        // Atur ukuran kertas
        $pdf->setPaper('A4', 'portrait');

        $namaUser = str_replace(' ', '_', auth()->user()->name);
        $waktuDownload = now()->locale('id')->translatedFormat('l_d_F_Y_H_i'); 
        $fileName = 'Slip_Pendapatan_Karyantara_' . $namaUser . '_' . $waktuDownload . '.pdf';

        return $pdf->stream($fileName);
    }

    public function exportEarningsExcel(Request $request)
    {
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));
        
        $fileName = 'Rekap_Pendapatan_' . auth()->user()->name . '_' . $selectedMonth . '_' . $selectedYear . '.xlsx';
        
        return Excel::download(new MyEarningsExport($selectedMonth, $selectedYear, auth()->id()), $fileName);
    }
}