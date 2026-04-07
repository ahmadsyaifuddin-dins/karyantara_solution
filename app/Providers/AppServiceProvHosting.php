<?php

namespace App\Providers;

use App\Models\Project;
use App\Observers\ProjectObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ==========================================================
        // MENGUBAH JALUR UPLOAD UNTUK SHARED HOSTING (InfinityFree)
        // ==========================================================
        // Karena Laravel berada di dalam folder "htdocs/laravel",
        // kita paksa 'public_path' untuk mundur satu folder ke "htdocs"
        // agar file tersimpan di "htdocs/uploads/..."
        
        $this->app->usePublicPath(base_path('..'));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Mendaftarkan Observer ke Model Project
        Project::observe(ProjectObserver::class);

        // 2. GATE KHUSUS UNTUK BYPASS PENYAKIT CACHE HOSTING
        Gate::before(function ($user, $ability) {
            
            // A. God Mode untuk Super Admin
            if ($user->hasRole('super_admin')) {
                return true;
            }

            // B. Bypass Cache Hosting: Paksa nanya langsung ke fungsi Spatie
            try {
                if ($user->hasPermissionTo($ability)) {
                    return true;
                }
            } catch (\Exception $e) {
                // Abaikan jika ability tidak ada
            }

            return null; 
        });
    }
}