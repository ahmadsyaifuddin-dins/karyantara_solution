<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageViewController extends Controller
{
    public function index()
    {
        // 1. Ambil statistik total pengunjung unik (berdasarkan IP) per halaman
        $pageStats = PageView::select('page_name', DB::raw('count(*) as total_views'), DB::raw('MAX(created_at) as last_viewed'))
            ->groupBy('page_name')
            ->orderByDesc('total_views')
            ->get();

        // SIHIR TRANSFORM: Terjemahkan nama halaman dan cari siapa pemiliknya
        $pageStats->transform(function ($stat) {
            $stat->display_name = ucfirst($stat->page_name); // Default (Misal: 'About', 'Terms')
            $stat->owner_name = null;
            $stat->is_portfolio = false;

            // Jika halamannya adalah portofolio (contoh: 'portfolio_3')
            if (str_starts_with($stat->page_name, 'portfolio_')) {
                $stat->is_portfolio = true;
                $portfolioId = str_replace('portfolio_', '', $stat->page_name);
                
                // Cari data portofolio
                $portfolio = Portfolio::find($portfolioId);

                if ($portfolio) {
                    $stat->display_name = Str::limit($portfolio->title, 25);
                    
                    // Cari nama admin (developer) berdasarkan admin_id
                    $admin = User::find($portfolio->admin_id);
                    $stat->owner_name = $admin ? $admin->name : 'Internal Team';
                } else {
                    $stat->display_name = 'Portofolio (Terhapus)';
                }
            }
            return $stat;
        });

        // 2. Ambil log pengunjung terakhir
        $recentLogs = PageView::latest()->paginate(15);

        // Terjemahkan juga nama halaman untuk tabel log aktivitas di bawah
        $recentLogs->getCollection()->transform(function ($log) {
            $log->display_name = ucfirst($log->page_name);
            if (str_starts_with($log->page_name, 'portfolio_')) {
                $portfolioId = str_replace('portfolio_', '', $log->page_name);
                $portfolio = Portfolio::find($portfolioId);
                $log->display_name = $portfolio ? 'Portofolio: ' . Str::limit($portfolio->title, 30) : 'Portofolio (Terhapus)';
            }
            return $log;
        });

        // 3. Menghitung total pengunjung
        $totalUniqueVisitors = PageView::count();

        return view('admin.visitors.index', compact('pageStats', 'recentLogs', 'totalUniqueVisitors'));
    }
}