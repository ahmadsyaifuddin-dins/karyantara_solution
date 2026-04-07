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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Project::observe(ProjectObserver::class);

        // 2. GATE KHUSUS UNTUK BYPASS PENYAKIT CACHE HOSTING
        Gate::before(function ($user, $ability) {
            
            // A. God Mode untuk Super Admin
            if ($user->hasRole('super_admin')) {
                return true;
            }

            try {
                if ($user->hasPermissionTo($ability)) {
                    return true; // Buka gerbang jika punya izin!
                }
            } catch (\Exception $e) {
            }

            return null; 
        });
    }
}