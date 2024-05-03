<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ProfileRepository;
use App\Repositories\BaseRepository;
use App\Repositories\CategoryRepoInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\SliderRepoInterface;
use App\Repositories\SliderRepository;
use App\Services\CateService;
use App\Services\SliderService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // SLider Service
        $this->app->bind(SliderRepoInterface::class, SliderRepository::class);
        $this->app->bind(SliderService::class, function ($app) {
            return new SliderService($app->make(SliderRepoInterface::class));
        });

        // Cate Service
        $this->app->bind(CategoryRepoInterface::class, CategoryRepository::class);
        $this->app->bind(CateService::class, function ($app) {
            return new CateService($app->make(CategoryRepoInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
