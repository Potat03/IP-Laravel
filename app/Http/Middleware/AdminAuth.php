<?php
// Author: Loh Thiam Wei
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('auth.admin.login');
        }

        $valid = true;

        // Check if session ID matches the one stored in the DB
        if (Auth::guard('admin')->user()->session_id !== session()->getId()) {
            $request->session()->flash('message', 'You have been logged out because your account was accessed from another device.');
            $valid = false;
        } else if (Auth::guard('admin')->user()->status !== 'active') {
            $request->session()->flash('message', 'You have been logged out because your account become inactive.');
            $valid = false;
        }

        if (!$valid) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('auth.admin.login');
        }


        $response = $next($request);
        $response->headers->add([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
        return $response;
    }
}
