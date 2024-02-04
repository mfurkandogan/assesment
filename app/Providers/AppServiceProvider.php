<?php

namespace App\Providers;

use App\Http\Interfaces\IOrder;
use App\Http\Interfaces\IProduct;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\ProductRepository;
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
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IOrder::class, OrderRepository::class);
        $this->app->bind(IProduct::class, ProductRepository::class);
        
    }
}
