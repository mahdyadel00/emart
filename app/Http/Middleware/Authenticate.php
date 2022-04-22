<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        //dd(0);
        if (str_contains(url()->current(), '/admin') || str_contains(url()->current(), '/Admin')) {
            return 'admin/login';
        }else{
            return '/login';
        }
        //        if (!$request->expectsJson()) {
        //            return 'admin/login';
        //        }
    }
}
