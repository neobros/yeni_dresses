<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use DB;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View::composer('Customer.header', function ($view) {
            $cartData = Auth::guard('customer')->check()
                ? DB::table('cart')
                    ->join('item', 'cart.item_ID', '=', 'item.item_ID')
                    ->where('cart.user_ID', Auth::guard('customer')->user()->id)
                    ->select('cart.*', 'item.*', 'cart.size as cartSize', 'cart.quantity as cartQuantity', 'item.quantity as itemQuantity')
                    ->get()
                : []; 
            $view->with('cartData', $cartData);
        });
    }
}
