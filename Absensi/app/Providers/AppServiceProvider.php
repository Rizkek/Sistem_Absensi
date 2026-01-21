<?php

namespace App\Providers;

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
        // Load Material Symbols dari Google Fonts untuk Filament
        \Filament\Support\Facades\FilamentAsset::register([
            \Filament\Support\Assets\Css::make('material-symbols', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200'),
        ]);

        // ========== PERFORMANCE OPTIMIZATION ==========

        // Query Logging untuk Development (debug performance)
        if (env('APP_DEBUG')) {
            \Illuminate\Support\Facades\DB::listen(function ($query) {
                if ($query->time > 100) { // Log queries > 100ms
                    \Illuminate\Support\Facades\Log::warning('Slow Query (' . $query->time . 'ms): ' . $query->sql, $query->bindings);
                }
            });
        }

        // Model-level Optimization - set pagination defaults
        \Illuminate\Pagination\Paginator::useBootstrap();
    }
}
