<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UnidadeConsumidoraService;

class UnidadeConsumidoraServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(UnidadeConsumidoraService::class, function ($app) {
            return new UnidadeConsumidoraService();
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
