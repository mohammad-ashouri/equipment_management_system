<?php

namespace App\Providers;

use App\Models\Catalogs\PostType;
use App\Models\User;
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
        // Share $postTypes with all views
        View::composer('*', function ($view) {
            $view->with('postTypes', PostType::where('status', 1)->get());
            $view->with('users', User::orderBy('family')->get());
        });
    }
}
