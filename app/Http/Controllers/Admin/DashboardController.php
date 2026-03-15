<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Project;
use App\Models\PageView;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $appProjects = $appQuery->orderBy('created_at', 'desc')->get();
        $totalAppEarnings = $appProjects->sum('app_price');
        // Hitung fee aplikasi yang BELUM cair
        $unpaidAppEarnings = $appProjects->where('is_programmer_paid', false)->sum('app_price'); 

        $writerProjects = $writerQuery->orderBy('created_at', 'desc')->get();
        $totalWriterEarnings = $writerProjects->sum('writer_price');
        // Hitung fee naskah yang BELUM cair
        $unpaidWriterEarnings = $writerProjects->where('is_writer_paid', false)->sum('writer_price');

        $totalEarnings = $totalAppEarnings + $totalWriterEarnings;
        $totalUnpaidEarnings = $unpaidAppEarnings + $unpaidWriterEarnings; // Total Piutang ke Admin 2
        $totalProjects = $appProjects->count() + $writerProjects->count();

        $years = range(2024, date('Y'));

        return view('admin.earnings.index', compact(
            'appProjects', 'totalAppEarnings', 'unpaidAppEarnings',
            'writerProjects', 'totalWriterEarnings', 'unpaidWriterEarnings',
            'totalEarnings', 'totalUnpaidEarnings', 'totalProjects',
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
}