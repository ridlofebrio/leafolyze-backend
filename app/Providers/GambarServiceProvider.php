<?php

namespace App\Providers;

use App\Http\Controllers\Api\MachineLearningImageController;
use App\Providers\Services\GambarService;
use Illuminate\Support\ServiceProvider;

class GambarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MachineLearningImageController::class, function ($app) {
            $GambarService = $app->make(GambarService::class);
            return new MachineLearningImageController($GambarService);
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
