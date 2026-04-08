<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AiCalculatorController; // Alias agar tidak bentrok
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MyEarningsController;
use App\Http\Controllers\Admin\PageViewController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\RevisionTicketController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\TextEnhancementController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// HALAMAN PUBLIK (Guest)
Route::get('/', [FrontController::class, 'home'])->name('home');
Route::get('/portofolio', function () {
    return view('public.portfolio');
})->name('portfolio');
Route::get('/kontak', function () {
    return view('public.contact');
})->name('contact');
Route::get('/tentang-kami', [FrontController::class, 'about'])->name('about');
Route::get('/terms', [FrontController::class, 'terms'])->name('terms');

Route::get('/panduan/skripsi/x7y9-rules-karyantara', [FrontController::class, 'studentRules'])->name('rules.mahasiswa');

// Arahkan route testimonial publik ke FrontController
Route::get('/testimonial', [FrontController::class, 'testimonial'])->name('testimonial');

Route::get('/validate/invoice/{id}/{hash}', [ValidationController::class, 'invoice'])->name('validate.invoice');
Route::get('/validate/rekap/{date}/{hash}', [ValidationController::class, 'rekap'])->name('validate.rekap');

Route::post('/testimonial', [FrontController::class, 'storeTestimonial'])
    ->middleware('throttle:3,1') // Layer 1: Maksimal 3 request per 1 menit per IP
    ->name('testimonial.store');

Route::get('/portofolio', [FrontController::class, 'portfolio'])->name('portfolio');
Route::get('/portofolio/{portfolio}', [FrontController::class, 'showPortfolio'])->name('portfolio.show');
Route::post('/portfolio/{id}/like', [FrontController::class, 'likePortfolio'])->name('portfolio.like');

// ==========================================
// HALAMAN ADMIN (Harus Login & Punya Izin)
// ==========================================
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // --- DASHBOARD ---
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('can:view_dashboard')
        ->name('dashboard');

    Route::get('/ikhtiar', function () {
        return view('pages.admin.ikhtiar.index');
    })->middleware('can:view_ikhtiar')->name('ikhtiar');

    // --- OPERASIONAL & FINANSIAL ---
    Route::middleware('can:manage_projects')->group(function () {
        Route::get('/projects/export/excel', [ProjectController::class, 'exportExcel'])->name('projects.export.excel');
        Route::get('/projects/export/pdf', [ProjectController::class, 'exportPdf'])->name('projects.export.pdf');
        Route::get('/projects/{project}/invoice', [ProjectController::class, 'exportInvoice'])->name('projects.invoice');
        Route::get('projects/priority-board', [ProjectController::class, 'priorityBoard'])->name('projects.priority');
        Route::post('projects/update-priority', [ProjectController::class, 'updatePriority'])->name('projects.update-priority');

        Route::post('/admin/projects/sync-google-sheet', function () {
            try {
                Artisan::call('project:sync-sheet');

                return back()->with('success', 'Data berhasil disinkronkan ke Google Sheet!');
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal sinkronisasi: '.$e->getMessage());
            }
        })->name('projects.sync-sheet');

        Route::resource('projects', ProjectController::class);
    });

    Route::middleware('can:manage_revisions')->group(function () {
    Route::get('/revisions/board', [RevisionTicketController::class, 'board'])->name('revisions.board');
    Route::post('/revisions/update-status', [RevisionTicketController::class, 'updateStatus'])->name('revisions.update-status');
    Route::resource('revisions', RevisionTicketController::class)->except(['index', 'show']);
    
    // ROUTE BARU: Tambah Kuota Ekstra
    Route::patch('/projects/{project}/add-revision-quota', [ProjectController::class, 'addExtraRevision'])
        ->name('projects.add-revision-quota')
        ->middleware('can:add_extra_quota');
    });

    Route::middleware('can:manage_earnings')->group(function () {
        Route::get('/my-earnings', [MyEarningsController::class, 'index'])->name('earnings.index');
        Route::patch('/my-earnings/{project}/toggle-paid', [MyEarningsController::class, 'toggleEarningStatus'])->name('earnings.toggle-paid');
        Route::get('/my-earnings/export/pdf', [MyEarningsController::class, 'exportPdf'])->name('earnings.export.pdf');
        Route::get('/my-earnings/export/excel', [MyEarningsController::class, 'exportExcel'])->name('earnings.export.excel');
    });

    Route::resource('meetings', MeetingController::class)->middleware('can:manage_meetings');
    Route::get('meetings/{meeting}/print', [MeetingController::class, 'print'])->middleware('can:manage_meetings')->name('meetings.print');

    // --- TOOLS & CALCULATORS ---
    Route::middleware('can:use_ai_calculator')->group(function () {
        Route::get('/ai-calculator', [AiCalculatorController::class, 'index'])->name('ai-calculator.index');
        Route::post('/ai-calculator/calculate', [AiCalculatorController::class, 'calculate'])->name('ai-calculator.calculate');
        Route::get('/ai-calculator/history/{id}', [AiCalculatorController::class, 'showHistory'])->name('ai-calculator.history.show');
        Route::post('/ai/enhance-text', [TextEnhancementController::class, 'enhance'])
            ->middleware('throttle:30,1')
            ->name('ai.enhance');
    });

    Route::middleware('can:use_pricing_calculator')->group(function () {
        Route::get('/pricing-calculator', [PricingController::class, 'index'])->name('pricing-calculator');
        Route::post('/pricing-calculator/pdf', [PricingController::class, 'generatePdf'])->name('pricing-calculator.pdf');
    });

    // --- MANAJEMEN KONTEN ---
    Route::resource('portfolios', PortfolioController::class)->middleware('can:manage_portfolios');

    Route::middleware('can:manage_testimonials')->group(function () {
        Route::post('testimonials/bulk-action', [AdminTestimonialController::class, 'bulkAction'])->name('testimonials.bulk-action');
        Route::post('testimonials/action-all', [AdminTestimonialController::class, 'actionAll'])->name('testimonials.action-all');
        Route::patch('testimonials/{testimonial}/toggle-status', [AdminTestimonialController::class, 'toggleStatus'])->name('testimonials.toggle-status');
        Route::post('testimonials/toggle-setting', [AdminTestimonialController::class, 'toggleSetting'])->name('testimonials.toggle-setting');
        Route::resource('testimonials', AdminTestimonialController::class);
    });

    // --- SISTEM & KONFIGURASI ---
    Route::get('/struktur-organisasi', [PositionController::class, 'orgChart'])
        ->middleware('can:view_struktur')
        ->name('struktur');

    Route::resource('positions', PositionController::class)
        ->except(['show'])
        ->middleware('can:manage_positions');

    Route::resource('admins', AdminController::class)
        ->except(['show'])
        ->middleware('can:manage_admins');

    // RBAC & Roles (Satu izin dengan manage_admins atau bisa dipisah kalau mau)
    Route::middleware('can:manage_admins')->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

        // Route baru untuk Sinkronisasi Seeder
        Route::post('/roles/sync-permissions', [RoleController::class, 'syncPermissions'])->name('roles.sync-permissions');

        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    Route::get('/visitors', [PageViewController::class, 'index'])
        ->middleware('can:view_visitors')
        ->name('visitors.index');

    Route::middleware('can:manage_settings')->group(function () {
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings/{setting}/toggle', [SettingController::class, 'toggle'])->name('settings.toggle');
        Route::post('/settings/update-data', [SettingController::class, 'updateData'])->name('settings.updateData');
    });
});

// PROFILE BAWAAN BREEZE (Tidak perlu middleware can: karena semua user yang login boleh edit profile-nya sendiri)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/music', [ProfileController::class, 'updateMusic'])->name('profile.music.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
