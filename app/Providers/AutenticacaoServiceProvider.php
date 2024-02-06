<?php

namespace App\Providers;

use App\Services\AutenticacaoService;
use Illuminate\Support\ServiceProvider;

class AutenticacaoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(AutenticacaoService::class, function ($app) {
            return new AutenticacaoService();
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
