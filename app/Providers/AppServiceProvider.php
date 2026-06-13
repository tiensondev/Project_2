<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Brand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    public function boot(): void
    {
        if (Schema::hasTable('categories')) {
            View::share('categories', Category::where('status', 1)->get());
        } else {
            View::share('categories', collect());
        }

        if (Schema::hasTable('brands')) {
            View::share('brands', Brand::where('status', 1)->get());
        } else {
            View::share('brands', collect());
        }

        View::composer('web-layouts.app', function ($view) {
            $cartCount = 0;

            if (Auth::check() && Schema::hasTable('carts') && Schema::hasTable('cart_items')) {
                $cart = Cart::where('user_id', Auth::id())->with('items')->first();

                if ($cart) {
                    $cartCount = $cart->items->sum('quantity');
                }
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
