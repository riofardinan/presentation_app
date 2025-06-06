<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('refreshToken')) {
            if(!$request->is('login')){
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
