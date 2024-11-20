<?php

namespace App\Providers;

use App\Services\ArticleService;
use App\Services\AuthService;
use App\Services\DetectionService;
use App\Services\Interfaces\ArticleServiceInterface;
use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\DetectionServiceInterface;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\ProductService;
use App\Services\ProfileService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(ArticleServiceInterface::class, ArticleService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(DetectionServiceInterface::class, DetectionService::class);
        $this->app->bind(ProfileServiceInterface::class, ProfileService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}