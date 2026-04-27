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

    public function __construct(EarningsService $earningsService)
    {
        $this->earningsService = $earningsService;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;

        // 1. DATA UMUM (Bisa dilihat semua role yang masuk dashboard)
        $pendingTestimonials = Testimonial::where('is_approved', 0)->count();
        $totalVisitors = PageView::count();

        // Tabel Proyek Terbaru
        $priorityProjects = Project::where('status', '!=', 'Selesai')
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Admin Online
        $onlineAdmins = User::select('users.*')
            ->addSelect(['last_seen' => DB::table('sessions')
                ->select('last_activity')->whereColumn('user_id', 'users.id')
                ->orderByDesc('last_activity')->limit(1)
            ])->orderByDesc('last_seen')->get();


        // Agar blade tidak error "Undefined Variable" ketika bukan super_admin
        $totalRevenue = 0;
        $appRevenue = 0;
        $writerRevenue = 0;
        $activeProjects = 0;
        $stats = [];
        $chartYear = $request->input('year', date('Y'));
        $chartData = [];
        $yearlyData = ['labels' => [], 'values' => []];

        // 2. DATA FINANSIAL & SENSITIF (Hanya ditarik jika role adalah super_admin)
        if ($user->hasRole('super_admin')) {
            
            $totalRevenue = Project::sum('net_income');
            $appRevenue = Project::sum('app_price');
            $writerRevenue = Project::sum('writer_price');
            $activeProjects = Project::where('status', '!=', 'Selesai')->count();

            // Statistik Pribadi (Dompet Pendapatan)
            $stats = $this->earningsService->getPersonalStats($userId);

            // Chart JS Tahun Ini
            $projectsThisYear = Project::whereYear('created_at', $chartYear)->select('created_at', 'net_income')->get();
            for ($month = 1; $month <= 12; $month++) {
                $chartData[] = $projectsThisYear->filter(fn($p) => $p->created_at->format('n') == $month)->sum('net_income');
            }

            // Chart JS 5 Tahun Terakhir
            $currentYear = date('Y');
            for ($i = 4; $i >= 0; $i--) {
                $year = $currentYear - $i;
                $yearlyData['labels'][] = (string)$year;
                $yearlyData['values'][] = Project::whereYear('created_at', $year)->sum('net_income');
            }
        }

        // Ekstrak data array $stats menjadi variabel mandiri (jika kosong, tidak akan memecahkan blade selama di-handle Spatie)
        return view('dashboard', array_merge(compact(
            'totalRevenue', 'appRevenue', 'writerRevenue',
            'activeProjects', 'pendingTestimonials', 'totalVisitors',
            'priorityProjects', 'onlineAdmins', 'chartData', 'chartYear', 'yearlyData'
        ), $stats));
    }
}