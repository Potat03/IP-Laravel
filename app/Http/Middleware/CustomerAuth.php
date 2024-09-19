<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('user.login')->withErrors(['error' => 'You must be logged in to access this page.']);
        }

        if ($request->route('user.login') && Auth::guard('customer')->check()) {
            return redirect()->route('user.profileSec');
        }

        return $next($request);
    }
}
