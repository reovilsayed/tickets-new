<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::component('pages.magazines.checkout.layout', 'magazine-checkout-layout');
        Blade::component('pages.magazines.checkout.summary-table', 'magazine-checkout-summary-table');
        Blade::component('pages.magazines.checkout.coupon-form', 'magazine-checkout-coupon-form');
        Blade::component('pages.magazines.checkout.checkout-form', 'magazine-checkout-checkout-form');
    }
}
