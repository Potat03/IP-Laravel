<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AdminAuth
{
    public function handle($request, Closure $next)
    {
        Log::info(Auth::guard('admin')->check());
        Log::info(Auth::guard('admin')->user());
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('adminChat')->withErrors(['error' => 'You must be logged in to access this page.']);
        }

        return $next($request);
    }
}
