<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrapFour();

        // Blade helper: resolve product image URL regardless of storage path format
        \Illuminate\Support\Facades\Blade::directive('productImage', function ($expression) {
            return "<?php
                \$_img = $expression;
                if (str_starts_with(\$_img, 'public/')) {
                    // Uploaded via admin panel -> storage disk
                    echo e(asset('storage/' . ltrim(str_replace('public/', '', \$_img), '/')));
                } else {
                    // Seeded or legacy path in /public
                    echo e(asset(\$_img));
                }
            ?>";
        });
    }
}
