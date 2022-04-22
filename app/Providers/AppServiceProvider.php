<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
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
        foreach (File::directories(app_path("Modules")) as $moduleDir) {
            View::addLocation($moduleDir . "/views");
        }

        Paginator::useBootstrap();
    }


    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
//    protected function configureRateLimiting()
//    {
////        RateLimiter::for('global', function (Request $request) {
////            return Limit::perMinute(2)->by($request->ip());
////        });
//        RateLimiter::for('ip_address', function (Request $request) {
//            return Limit::perMinute(2)->by($request->ip())->response(function() {
//                return response(_i("Sorry! You can't upload more than 1 file at minute."), 429);
//            });
//        });
//    }
}
