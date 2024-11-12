<?php

namespace App\Providers;

use App\Http\Controllers\Api\GambarMachineLearningController;
use App\Providers\Services\GambarService;
use Illuminate\Support\ServiceProvider;

class GambarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GambarMachineLearningController::class, function ($app) {
            $GambarService = $app->make(GambarService::class);
            return new GambarMachineLearningController($GambarService);
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
