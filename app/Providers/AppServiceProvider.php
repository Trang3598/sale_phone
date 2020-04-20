<?php

namespace App\Providers;

use App\Cart;
use App\Category;
use App\Slide;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        $categories = Category::all();
        View::share('categories', $categories);
        $slides = Slide::all();
        View::share('slides', $slides);
        view()->composer(['client.master', 'client.cart'], function ($view) {
            if (Session('cart')) {
                    $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);
                $sum = 0;
                foreach ($cart->items as $item){
                    $sum = $sum + $item['discount']*$item['qty'];
                }
                $view->with(['cart' => Session::get('cart'),'product_cart' => $cart->items, 'totalPrice' => $cart->totalPrice, 'totalQty' => $cart->totalQty,'totalDiscount'=> $sum]);
            }
        });
    }
}
