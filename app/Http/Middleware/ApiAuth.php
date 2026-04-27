<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class ApiAuth
{
    public function handle($request, Closure $next)
    {
        // No existe token
        if (!Session::has('accessToken')) {
            return redirect()->route('login');
        }

        // Token expirado
        if (Session::has('tokenExpire') && time() >= Session::get('tokenExpire')) {
            Session::flush();
            return redirect()->route('login');
        }

        return $next($request);
    }
}