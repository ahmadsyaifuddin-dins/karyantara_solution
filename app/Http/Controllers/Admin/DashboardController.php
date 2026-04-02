<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Project;
use App\Models\PageView;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\EarningsService;

class DashboardController extends Controller
{
    protected $earningsService;

    // Dependency Injection
    public function __construct(EarningsService $earningsService)
    {
        $this->earningsService = $earningsService;
    }

    public function index(Request $request)
    {
        // 1. STATISTIK GLOBAL
        $totalRevenue = Project::sum('net_income');
        $appRevenue = Project::sum('app_price');
        $writerRevenue = Project::sum('writer_price');
        $activeProjects = Project::where('status', '!=', 'Selesai')->count();
        $pendingTestimonials = Testimonial::where('is_approved', 0)->count();
        $totalVisitors = PageView::count();

        // 2. STATISTIK PRIBADI (MENGGUNAKAN SERVICE)
        $userId = auth()->id();
        $stats = $this->earningsService->getPersonalStats($userId);

        // 3. TABEL PROYEK TERBARU
        $priorityProjects = Project::where('status', '!=', 'Selesai')
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 4. ADMIN ONLINE
        $onlineAdmins = User::select('users.*')
            ->addSelect(['last_seen' => DB::table('sessions')
                ->select('last_activity')->whereColumn('user_id', 'users.id')
                ->orderByDesc('last_activity')->limit(1)
            ])->orderByDesc('last_seen')->get();

        // 5. CHART JS TAHUN INI
        $chartYear = $request->input('year', date('Y'));
        $projectsThisYear = Project::whereYear('created_at', $chartYear)->select('created_at', 'net_income')->get();
        $chartData = [];
        for ($month = 1; $month <= 12; $month++) {
            $chartData[] = $projectsThisYear->filter(fn($p) => $p->created_at->format('n') == $month)->sum('net_income');
        }

        // 6. CHART JS 5 TAHUN TERAKHIR
        $yearlyLabels = [];
        $yearlyValues = [];
        $currentYear = date('Y');
        for ($i = 4; $i >= 0; $i--) {
            $year = $currentYear - $i;
            $yearlyLabels[] = (string)$year;
            $yearlyValues[] = Project::whereYear('created_at', $year)->sum('net_income');
        }
        $yearlyData = ['labels' => $yearlyLabels, 'values' => $yearlyValues];

        // Ekstrak data array $stats menjadi variabel mandiri agar sesuai dengan Blade lama
        return view('dashboard', array_merge(compact(
            'totalRevenue', 'appRevenue', 'writerRevenue',
            'activeProjects', 'pendingTestimonials', 'totalVisitors',
            'priorityProjects', 'onlineAdmins', 'chartData', 'chartYear', 'yearlyData'
        ), $stats));
    }
}