<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController; // Alias agar tidak bentrok
use App\Http\Controllers\Admin\PortfolioController; // Import FrontController
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// --- HALAMAN PUBLIK (Guest) ---
Route::get('/', function () {
    return view('public.home');
})->name('home');
Route::get('/portofolio', function () {
    return view('public.portfolio');
})->name('portfolio');
Route::get('/kontak', function () {
    return view('public.contact');
})->name('contact');
Route::get('/tentang-kami', function () {
    return view('public.about');
})->name('about');
Route::get('/terms', function () {
    return view('public.terms');
})->name('terms');

// Arahkan route testimonial publik ke FrontController
Route::get('/testimonial', [FrontController::class, 'testimonial'])->name('testimonial');
Route::get('/portofolio', [FrontController::class, 'portfolio'])->name('portfolio');
Route::get('/portofolio/{portfolio}', [FrontController::class, 'showPortfolio'])->name('portfolio.show');
// --- HALAMAN ADMIN (Harus Login) ---
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('admins', AdminController::class)->except(['show']);
    Route::resource('portfolios', PortfolioController::class);
    // Kembalikan Route Resource untuk CRUD Admin di sini
    Route::resource('testimonials', AdminTestimonialController::class);

});

// --- PROFILE BAWAAN BREEZE ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
