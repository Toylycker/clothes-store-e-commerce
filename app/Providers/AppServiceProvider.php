<?php

namespace App\Providers;

use App\Models\Age;
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


        View::composer('*', function ($view) {
            $basket = [];
            if(Cookie::has('store_outfits')){
                $basket = explode(",", Cookie::get('store_outfits'));
                array_shift($basket);

            }
            // dd(Cookie::get('store_outfits'));

            return $view->with([
                'basket' => $basket
            ]);
        });
    }
}
