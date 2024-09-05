<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\AuthFacade;


class AuthController extends Controller
{
    public function showForm()
    {
        return view('auth');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (AuthFacade::login($request->only('email', 'password'))) {
            return redirect()->intended('/home');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'email' => 'required|email|unique:customer,email',
            'phone' => 'required|regex:/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/',
            'password' => 'required|min:8|confirmed',
        ]);

        $response = AuthFacade::register($request->all());

        if (isset($response['success']) && $response['success']) {
            return response()->json($response, 200);
        }

        return response()->json($response, 400);
    }

    public function logout()
    {
        AuthFacade::logout();
        return redirect('/');
    }
}