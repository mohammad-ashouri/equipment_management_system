<?php

namespace App\Providers;

use App\Models\Catalogs\Brand;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useTailwind();
        View::composer('*', function ($view) {
            $view->with('brands', Brand::whereStatus(1)->orderBy('name')->get());
        });
    }
}
