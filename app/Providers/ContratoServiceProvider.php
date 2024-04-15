<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ContratoService;

class ContratoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ContratoService::class, function ($app) {
            return new ContratoService();
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
