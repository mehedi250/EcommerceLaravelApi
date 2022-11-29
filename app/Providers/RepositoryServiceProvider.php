<?php

namespace App\Providers;

use App\Interfaces\Repository\CategoryRepository;
use App\Interfaces\Repository\ProductRepository;
use App\Interfaces\Repository\UserRepository;
use App\Repositories\CategoryRepositoryEloquent;
use App\Repositories\ProductRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryRepository::class, CategoryRepositoryEloquent::class);
        $this->app->bind(ProductRepository::class, ProductRepositoryEloquent::class);
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
