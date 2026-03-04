<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestTestimonialRequest;
use App\Models\PageView;
use App\Models\Portfolio;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth; // Tambahkan Facade Auth

class FrontController extends Controller
{
    public function home()
    {
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
        // 1. Urutkan dari Views terbanyak, lalu Likes terbanyak, baru yang terbaru
        $portfolios = Portfolio::orderByDesc('views_count')
                                ->orderByDesc('likes_count')
                                ->latest()
                                ->get();
        return view('public.portfolio', compact('portfolios'));
    }

    // HALAMAN DETAIL PORTOFOLIO
    public function showPortfolio(Portfolio $portfolio, Request $request)
    {
        $pageName = 'portfolio_' . $portfolio->id;
        
        // 1. Catat IP. Jika ini pengunjung BARU yang unik, fungsi akan me-return TRUE
        $isNewUniqueView = $this->recordPageView($pageName, $request);
        
        // 2. Jika pengunjung baru (bukan bos, dan unik), tambahkan counter di tabel portfolio
        if ($isNewUniqueView) {
            $portfolio->increment('views_count');
        }

        $viewCount = $portfolio->views_count;
        $likeCount = $portfolio->likes_count;

        // Ambil project lain yang juga lagi ngetren
        $otherProjects = Portfolio::where('id', '!=', $portfolio->id)
                                  ->orderByDesc('views_count')
                                  ->take(3)->get();

        return view('public.portfolio-detail', compact('portfolio', 'otherProjects', 'viewCount', 'likeCount'));
    }

    // FITUR TOMBOL LIKE (AJAX)
    public function likePortfolio(Request $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        
        // Cek pakai Session agar 1 browser cuma bisa like 1 kali
        $sessionKey = 'liked_portfolio_' . $id;

        if (!$request->session()->has($sessionKey)) {
            $portfolio->increment('likes_count');
            $request->session()->put($sessionKey, true);
            
            return response()->json([
                'success' => true, 
                'likes' => $portfolio->likes_count,
                'message' => 'Terima kasih atas apresiasinya! ❤️'
            ]);
        }

        return response()->json([
            'success' => false, 
            'message' => 'Anda sudah menyukai proyek ini sebelumnya.'
        ]);
    }

    public function about(Request $request)
    {
        $this->recordPageView('about', $request);
        $viewCount = PageView::where('page_name', 'about')->count();

        return view('public.about', compact('viewCount'));
    }

    public function storeTestimonial(StoreGuestTestimonialRequest $request)
    {
        $data = $request->validated();
        $autoApproveSetting = DB::table('settings')->where('key', 'auto_approve_testimonial')->value('value');
        $isApproved = ($autoApproveSetting == '1') ? 1 : 0;

        $data['ip_address'] = $request->ip();
        $data['user_agent'] = $request->userAgent();
        $data['is_approved'] = $isApproved;
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

    public function terms(Request $request)
    {
        $this->recordPageView('terms', $request);
        $viewCount = PageView::where('page_name', 'terms')->count();

        return view('public.terms', compact('viewCount'));
    }

    /**
     * ==========================================
     * FUNGSI HELPER UNTUK MENCATAT VIEWER (DIPERBARUI)
     * ==========================================
     */
    private function recordPageView($pageName, Request $request)
    {
        // 1. PENGECUALIAN BOS (Ahmad Syaifuddin tidak akan pernah di-track)
        if (Auth::check() && (Auth::user()->name === 'Ahmad Syaifuddin' || Auth::id() === 1)) {
            return false; // Hentikan fungsi dan jangan hitung view_count portofolio
        }

        $ip = $request->ip();

        // 2. CEK IDENTITAS VISITOR (Admin Lain vs Publik/Guest)
        $visitorType = 'Guest';
        $visitorName = 'Anonim';

        if (Auth::check()) {
            $visitorType = 'Admin';
            $visitorName = Auth::user()->name; // Catat nama admin lain
        }

        // Cek apakah IP ini sudah berkunjung ke halaman ini
        $existingView = PageView::where('page_name', $pageName)->where('ip_address', $ip)->first();

        // JIKA PENGUNJUNG BARU (BELUM ADA DI DATABASE)
        if (! $existingView) {
            $agent = $request->userAgent();

            // Deteksi OS
            $os = 'Unknown OS';
            if (preg_match('/windows/i', $agent)) $os = 'Windows';
            elseif (preg_match('/macintosh|mac os x/i', $agent)) $os = 'Mac OS';
            elseif (preg_match('/linux/i', $agent)) $os = 'Linux';
            elseif (preg_match('/android/i', $agent)) $os = 'Android';
            elseif (preg_match('/iphone|ipad|ipod/i', $agent)) $os = 'iOS';

            // Deteksi Browser
            $browser = 'Unknown Browser';
            if (preg_match('/Edg/i', $agent)) $browser = 'Edge';
            elseif (preg_match('/Chrome/i', $agent)) $browser = 'Chrome';
            elseif (preg_match('/Firefox/i', $agent)) $browser = 'Firefox';
            elseif (preg_match('/Safari/i', $agent)) $browser = 'Safari';
            elseif (preg_match('/Opera|OPR/i', $agent)) $browser = 'Opera';

            $deviceType = preg_match('/mobile|android|iphone|ipad|ipod/i', $agent) ? 'Mobile' : 'Desktop';

            $location = 'Unknown';
            $isp = 'Unknown';

            if ($ip !== '127.0.0.1' && $ip !== '::1') {
                try {
                    $response = Http::timeout(2)->get("https://ipapi.co/{$ip}/json/");
                    if ($response->successful()) {
                        $data = $response->json();
                        $location = ($data['city'] ?? '').', '.($data['country_name'] ?? '');
                        $isp = $data['org'] ?? 'Unknown ISP';
                    }
                } catch (\Exception $e) {
                    // Abaikan jika API timeout/limit
                }
            } else {
                $location = 'Localhost';
                $isp = 'Local Network';
            }

            // 3. SIMPAN KE DATABASE (Tabel page_views)
            PageView::create([
                'page_name'      => $pageName,
                'ip_address'     => $ip,
                'browser'        => $browser,
                'os'             => $os,
                'device_type'    => $deviceType,
                'location'       => trim($location, ', '),
                'isp'            => $isp,
                'visitor_type'   => $visitorType,
                'visitor_name'   => $visitorName,
                'raw_user_agent' => $agent,
            ]);

            // PENTING: Beri sinyal TRUE agar sistem tahu ini viewer unik baru,
            // sehingga angka views_count di portfolio bisa ditambah (+1).
            return true; 
        }

        // PENTING: Jika sudah pernah berkunjung, kembalikan FALSE.
        // Agar sistem tidak menambah (+1) views_count di portfolio lagi.
        return false; 
    }
}