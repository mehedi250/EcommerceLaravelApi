<?php

namespace App\Providers;

use App\Interfaces\Service\CategoryContact;
use App\Interfaces\Service\ProductContact;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryContact::class , CategoryService::class);
        $this->app->bind(ProductContact::class , ProductService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
