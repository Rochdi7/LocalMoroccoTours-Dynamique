<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

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
        Schema::defaultStringLength(191);

        // Admin theme is Bootstrap 5; use the matching paginator so the
        // default Tailwind classes (w-5/h-5, sm:hidden) don't render an
        // oversized SVG chevron and a duplicated mobile/desktop nav.
        Paginator::useBootstrapFive();
    }
}
