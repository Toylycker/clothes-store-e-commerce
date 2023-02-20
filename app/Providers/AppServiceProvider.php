<?php

namespace App\Providers;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cookie;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Model::preventLazyLoading(! $this->app->isProduction());
        Paginator::useBootstrapFive();


        View::composer('front.app.navbar', function ($view) {
            $new_orders = 0;
            if (Auth::user()) {
                $new_orders = Auth::user()->unreadNotifications->count();
            }

            return $view->with([
                'new_orders' => $new_orders
            ]);
        });

    }
}
