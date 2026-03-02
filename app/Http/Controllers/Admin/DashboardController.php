<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Project;
use App\Models\PageView;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. STATISTIK WIDGET ATAS
        $totalRevenue = Project::sum('net_income');
        $activeProjects = Project::where('status', '!=', 'Selesai')->count();
        $pendingTestimonials = Testimonial::where('is_approved', 0)->count();
        $totalVisitors = PageView::count();

        // 2. DATA TABEL PROYEK TERBARU (5 Teratas)
        $recentProjects = Project::latest()->take(5)->get();

        // 3. FITUR ADMIN ONLINE (Narik data dari tabel sessions)
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
            'totalRevenue', 
            'activeProjects', 
            'pendingTestimonials', 
            'totalVisitors', 
            'recentProjects', 
            'onlineAdmins'
        ));
    }
}