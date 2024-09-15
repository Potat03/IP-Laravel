<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login2');
    }

    public function aaa()
    {
        return view('adminChat');
    }

    // Handle the login request
    public function login(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('login2')->withErrors(['message' => 'Your already logged in.']);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = request(['email', 'password']);
        
        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
        
            if ($admin->status == 'active') {
                Log::info($request->session()->token());
                $request->session()->regenerate();
                return redirect()->intended('testchat');
            } else {
                return redirect()->route('login2')->withErrors(['message' => 'Your account not active']);
            }
        } else {
            return redirect()->route('login2')->withErrors(['message' => 'Wrong credentials']);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect('/');
    }
}
