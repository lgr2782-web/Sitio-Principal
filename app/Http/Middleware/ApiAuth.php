<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class ApiAuth
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('accessToken')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
