<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use Illuminate\Support\Facades\DB;

class PageViewController extends Controller
{
    public function index()
    {
        // Mengambil statistik total pengunjung unik (berdasarkan IP) per halaman
        $pageStats = PageView::select('page_name', DB::raw('count(*) as total_views'), DB::raw('MAX(created_at) as last_viewed'))
            ->groupBy('page_name')
            ->orderByDesc('total_views')
            ->get();

        // Mengambil log 15 pengunjung terakhir untuk tabel riwayat
        $recentLogs = PageView::latest()->paginate(15);

        // Menghitung total keseluruhan pengunjung unik dari semua halaman
        $totalUniqueVisitors = PageView::count();

        return view('admin.visitors.index', compact('pageStats', 'recentLogs', 'totalUniqueVisitors'));
    }
}
