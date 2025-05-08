<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Product;
use App\Order;
use App\Users;
use App\Statistic;

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
        view()->composer('*',function($view){
            $min_price = Product::min('product_price');
            $max_price = Product::max('product_price');
            $max_price_range =  $max_price + 100000;
            $min_price_range =  $min_price - 100000;

            $app_product = Product::all()->count();
            $app_order = Order::all()->count();
            $app_users = Users::all()->count();

            $total_sales = Statistic::sum('sales');   
            $total_profit = Statistic::sum('profit');

            $view->with('min_price',$min_price)->with('max_price',$max_price)->with('max_price_range',$max_price_range)->with('min_price_range',$min_price_range)->with('app_product', $app_product)->with('app_order', $app_order)->with('app_users', $app_users)->with('total_sales', $total_sales)->with('total_profit', $total_profit);
        });
    }
}
