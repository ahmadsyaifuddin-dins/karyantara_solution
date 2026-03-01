<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestTestimonialRequest;
use App\Models\PageView;
use App\Models\Portfolio;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
        $data['user_agent'] = $request->userAgent();
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

        // Cek apakah IP ini sudah berkunjung
        $existingView = PageView::where('page_name', $pageName)->where('ip_address', $ip)->first();

        if (! $existingView) {
            // 1. Parsing User-Agent (Browser, OS, Device)
            $agent = $request->userAgent();

            // Deteksi OS Sederhana
            $os = 'Unknown OS';
            if (preg_match('/windows/i', $agent)) {
                $os = 'Windows';
            } elseif (preg_match('/macintosh|mac os x/i', $agent)) {
                $os = 'Mac OS';
            } elseif (preg_match('/linux/i', $agent)) {
                $os = 'Linux';
            } elseif (preg_match('/android/i', $agent)) {
                $os = 'Android';
            } elseif (preg_match('/iphone|ipad|ipod/i', $agent)) {
                $os = 'iOS';
            }

            // Deteksi Browser Sederhana
            $browser = 'Unknown Browser';
            if (preg_match('/Edg/i', $agent)) {
                $browser = 'Edge';
            } elseif (preg_match('/Chrome/i', $agent)) {
                $browser = 'Chrome';
            } elseif (preg_match('/Firefox/i', $agent)) {
                $browser = 'Firefox';
            } elseif (preg_match('/Safari/i', $agent)) {
                $browser = 'Safari';
            } elseif (preg_match('/Opera|OPR/i', $agent)) {
                $browser = 'Opera';
            }

            // Deteksi Device
            $deviceType = preg_match('/mobile|android|iphone|ipad|ipod/i', $agent) ? 'Mobile' : 'Desktop';

            // 2. Fetch ISP dan Lokasi dari API Pihak Ketiga (ipapi.co)
            // Khusus IP Localhost (127.0.0.1) API tidak bisa melacak, jadi kita beri default
            $location = 'Unknown';
            $isp = 'Unknown';

            if ($ip !== '127.0.0.1' && $ip !== '::1') {
                try {
                    // Gunakan timeout(2) agar website tidak lambat jika API error
                    $response = Http::timeout(2)->get("https://ipapi.co/{$ip}/json/");
                    if ($response->successful()) {
                        $data = $response->json();
                        $location = ($data['city'] ?? '').', '.($data['country_name'] ?? '');
                        $isp = $data['org'] ?? 'Unknown ISP'; // "org" biasanya berisi nama provider seperti Telkomsel / Indihome
                    }
                } catch (\Exception $e) {
                    // Abaikan jika error/timeout agar user tetap bisa masuk
                }
            } else {
                $location = 'Localhost';
                $isp = 'Local Network';
            }

            // Simpan Data Super Lengkap
            PageView::create([
                'page_name' => $pageName,
                'ip_address' => $ip,
                'browser' => $browser,
                'os' => $os,
                'device_type' => $deviceType,
                'location' => trim($location, ', '),
                'isp' => $isp,
            ]);
        }

        // Hitung total pengunjung
        $viewCount = PageView::where('page_name', $pageName)->count();

        return view('public.terms', compact('viewCount'));
    }
}
