<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Testimonial;

class FrontController extends Controller
{
    // Fungsi untuk menampilkan halaman testimonial ke publik
    public function testimonial()
    {
        // Pindahkan logika database ke sini
        $testimonials = Testimonial::latest()->get();

        return view('public.testimonial', compact('testimonials'));
    }

    public function portfolio()
    {
        // Mengambil semua data portofolio dari yang terbaru
        $portfolios = Portfolio::latest()->get();

        return view('public.portfolio', compact('portfolios'));
    }

    public function showPortfolio(Portfolio $portfolio)
    {
        // Ambil 3 proyek lain untuk rekomendasi (selain proyek yang sedang dibuka)
        $otherProjects = Portfolio::where('id', '!=', $portfolio->id)->latest()->take(3)->get();

        return view('public.portfolio-detail', compact('portfolio', 'otherProjects'));
    }
}
