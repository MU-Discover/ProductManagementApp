<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectUnauthenticated
{
    public function handle($request, Closure $next)
    {
        if (!session('email')) {
            // User is not authenticated, redirect to the login page
            return redirect('/login'); // You can customize the login page URL
        }

        return $next($request);
    }
}
