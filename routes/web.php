<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController; // Alias agar tidak bentrok
use App\Http\Controllers\Admin\PageViewController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// HALAMAN PUBLIK (Guest)
Route::get('/', [FrontController::class, 'home'])->name('home');
Route::get('/portofolio', function () {
    return view('public.portfolio');
})->name('portfolio');
Route::get('/kontak', function () {
    return view('public.contact');
})->name('contact');
Route::get('/tentang-kami', function () {
    return view('public.about');
})->name('about');
Route::get('/terms', [FrontController::class, 'terms'])->name('terms');

// Arahkan route testimonial publik ke FrontController
Route::get('/testimonial', [FrontController::class, 'testimonial'])->name('testimonial');

Route::post('/testimonial', [FrontController::class, 'storeTestimonial'])
    ->middleware('throttle:3,1') // Layer 1: Maksimal 3 request per 1 menit per IP
    ->name('testimonial.store');

Route::get('/portofolio', [FrontController::class, 'portfolio'])->name('portfolio');
Route::get('/portofolio/{portfolio}', [FrontController::class, 'showPortfolio'])->name('portfolio.show');

// HALAMAN ADMIN (Harus Login)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    Route::post('testimonials/bulk-action', [AdminTestimonialController::class, 'bulkAction'])->name('testimonials.bulk-action');
    Route::post('testimonials/action-all', [AdminTestimonialController::class, 'actionAll'])->name('testimonials.action-all');

    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('admins', AdminController::class)->except(['show']);
    Route::resource('portfolios', PortfolioController::class);

    Route::patch('testimonials/{testimonial}/toggle-status', [AdminTestimonialController::class, 'toggleStatus'])->name('testimonials.toggle-status');
    // Route untuk mengubah settingan Global (Auto/Manual Publish)
    Route::post('testimonials/toggle-setting', [AdminTestimonialController::class, 'toggleSetting'])->name('testimonials.toggle-setting');
    Route::resource('testimonials', AdminTestimonialController::class);

    Route::get('/visitors', [PageViewController::class, 'index'])->name('visitors.index');
});

// PROFILE BAWAAN BREEZE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
