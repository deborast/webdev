<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            $cartCount = 0;

            if (Auth::check()) {
                $cart = Cart::with('items')
                    ->where('user_id', Auth::id())
                    ->first();

                if ($cart) {
                    $cartCount = $cart->items->sum('quantity');
                }
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
