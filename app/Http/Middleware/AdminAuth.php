<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AdminAuth
{
    public function handle($request, Closure $next)
    {
        // if (!Auth::guard('customer')->check()) {
        //     return redirect()->route('/login2')->withErrors(['error' => 'You must be logged in to access this page.']);
        // }
        

        return $next($request);
    }
}
