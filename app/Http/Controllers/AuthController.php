<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{
    public function showAdminLoginForm()
    {
        return view('login2');
    }

    // Handle the login request
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = request(['email', 'password']);

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
        
            if (Gate::allows('login', $admin)) {
                return redirect()->intended('testchat');
            } else {
                Auth::guard('admin')->logout();
                return redirect()->back()->withErrors(['message' => 'Your account is inactive.']);
            }
        } else {
            return redirect()->back()->withErrors(['message' => 'Invalid credentials.']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
