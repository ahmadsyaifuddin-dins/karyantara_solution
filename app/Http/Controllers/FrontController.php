<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestTestimonialRequest;
use App\Models\PageView;
use App\Models\Portfolio;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    // Fungsi untuk menampilkan halaman
    public function home()
    {
        // Ambil maksimal 10 ulasan terbaru yang sudah di-ACC agar slider tidak terlalu berat dimuat
        $testimonials = Testimonial::where('is_approved', 1)->latest()->take(10)->get();

        return view('public.home', compact('testimonials'));
    }

    public function testimonial()
    {
        $testimonials = Testimonial::where('is_approved', 1)->latest()->get();

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

    public function storeTestimonial(StoreGuestTestimonialRequest $request)
    {
        $data = $request->validated();

        // Cek pengaturan Auto/Manual Approve
        $autoApproveSetting = DB::table('settings')->where('key', 'auto_approve_testimonial')->value('value');
        $isApproved = ($autoApproveSetting == '1') ? 1 : 0;

        // Tangkap IP Address
        $data['ip_address'] = $request->ip();
        $data['is_approved'] = $isApproved;

        // Hapus field honeypot sebelum insert ke DB
        unset($data['company_website']);

        if ($request->hasFile('profile_image')) {
            $fileName = time().'_'.$request->file('profile_image')->getClientOriginalName();
            $request->file('profile_image')->move(public_path('uploads/testimonials'), $fileName);
            $data['profile_image'] = $fileName;
        }

        Testimonial::create($data);

        $message = $isApproved
            ? 'Terima kasih! Ulasan Anda telah berhasil dipublikasikan.'
            : 'Terima kasih! Ulasan Anda telah kami terima dan sedang menunggu tinjauan admin.';

        return redirect()->route('testimonial')->with('success', $message);
    }

    // Fungsi untuk halaman Terms & Conditions
    public function terms(Request $request)
    {
        $ip = $request->ip();
        $pageName = 'terms';

        // Logika Pintar: Cek apakah IP ini sudah tercatat untuk halaman 'terms'.
        // Jika belum, buat record baru. Jika sudah, biarkan saja (tidak menambah data).
        PageView::firstOrCreate([
            'page_name' => $pageName,
            'ip_address' => $ip,
        ]);

        // Hitung total pengunjung unik halaman ini
        $viewCount = PageView::where('page_name', $pageName)->count();

        // Lempar variabel $viewCount ke view
        return view('public.terms', compact('viewCount'));
    }
}
