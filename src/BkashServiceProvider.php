<?php

namespace Softrang\BkashPayment;

use Illuminate\Support\ServiceProvider;

class BkashServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // ✅ Load routes
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // ✅ Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'bkash');

        // ✅ Publish config + views
        $this->publishes([
            __DIR__ . '/../config/bkash.php' => config_path('bkash.php'),
        ], 'bkash-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/bkash'),
        ], 'bkash-views');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/bkash.php',
            'bkash'
        );

        $this->app->singleton('bkash', function () {
            return new BkashPayment();
        });
    }
}
