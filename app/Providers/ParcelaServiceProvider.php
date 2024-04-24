<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ParcelaService;

class ParcelaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ParcelaService::class, function ($app) {
            return new ParcelaService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
