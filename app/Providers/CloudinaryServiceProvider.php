<?php

namespace App\Providers;

use App\Services\CloudinaryService;
use App\Services\Interfaces\CloudinaryServiceInterface;
use Illuminate\Support\ServiceProvider;

class CloudinaryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CloudinaryServiceInterface::class, CloudinaryService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}