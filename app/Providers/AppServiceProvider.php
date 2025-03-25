<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Admin\Setting;
use App\Models\Customer\ProductCart;
use Illuminate\Support\Facades\Auth;


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
    public function boot()
    {
        $setting = Setting::first();
        View::share('setting', $setting);

        View::composer('*', function ($view) {
            $totalQty = Auth::check() ? ProductCart::where('customer_id', Auth::id())->sum('qty') : 0;
            $view->with('totalQty', $totalQty);
        });
    }
}
