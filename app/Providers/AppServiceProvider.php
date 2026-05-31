<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth; 
use App\Models\Category;
use App\Models\Cart; 

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
        View::share('categories', Category::where('status', 1)->get());

        View::composer('web-layouts.app', function ($view) {
            $cartCount = 0;

            if (Auth::check()) {
                $cart = Cart::where('user_id', Auth::id())->with('items')->first();
                
                if ($cart) {
                    $cartCount = $cart->items->sum('quantity');
                }
            }

            $view->with('cartCount', $cartCount);
        }); 
    }
}