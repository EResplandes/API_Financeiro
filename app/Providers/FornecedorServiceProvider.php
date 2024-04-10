<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FornecedorService;

class FornecedorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FornecedorService::class, function ($app) {
            return new FornecedorService();
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
