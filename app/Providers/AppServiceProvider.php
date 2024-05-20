<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ProfileRepository;
use App\Repositories\BaseRepository;
use App\Repositories\BrandRepository;
use App\Repositories\Interfaces\SliderRepoInterface;
use App\Repositories\Interfaces\SubCateRepoInterface;
use App\Repositories\Interfaces\CategoryRepoInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\ChildCategoryRepository;
use App\Repositories\Interfaces\BrandRepoInterface;
use App\Repositories\Interfaces\ChildCateRepoInterface;
use App\Repositories\SliderRepository;
use App\Repositories\SubCategoryRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // SLider repository
        $this->app->bind(SliderRepoInterface::class, SliderRepository::class);
        // $this->app->bind(SliderService::class, function ($app) {
        //     return new SliderService($app->make(SliderRepoInterface::class));
        // });

        // Cate repository
        $this->app->bind(CategoryRepoInterface::class, CategoryRepository::class);

        // SubCate repository
        $this->app->bind(SubCateRepoInterface::class, SubCategoryRepository::class);

        // ChildCate repository
        $this->app->bind(ChildCateRepoInterface::class, ChildCategoryRepository::class);

        // ChildCate repository
        $this->app->bind(BrandRepoInterface::class, BrandRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
