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

        //Store data in session
        session([
            'registration_data' => [
                'email' => $request->email,
            ]
        ]);

        $response = AuthFacade::register($request->all());

        return response()->json($response, 400);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp1' => 'required|numeric',
            'otp2' => 'required|numeric',
            'otp3' => 'required|numeric',
            'otp4' => 'required|numeric',
            'otp5' => 'required|numeric',
            'otp6' => 'required|numeric',
        ]);

        $otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4 . $request->otp5 . $request->otp6;

        if (session('otp_code') == $request->otp) {
        }
    }

    public function logout()
    {
        AuthFacade::logout();
        return redirect('/');
    }
}
