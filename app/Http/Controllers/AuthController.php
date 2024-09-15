<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Facades\AuthFacade;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showCustomerForm()
    {
        return view('auth');
    }

    public function profile()
    {
        return view('customer.profile');
    }

    public function showAdminLoginForm()
    {
        return view('login2');
    }

    public function userLogin(Request $request)
    {
        if (Auth::guard('customer')->check()) {
            //return ['success' => false, 'message' => 'You have logged in'];
            return response()->json(['success' => 'Message saved successfully!', 'data' => 'You have logged in']);
        }

        // Validate the login form
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();

            Log::info($request->session()->token());
            Log::info(Auth::guard('customer')->user());

            return response()->json(['success' => true, 'redirect_url' => '/profile']);
        } else {
            return response()->json(['fail' => 'Message saved successfully!', 'data' => 'Wrong']);
        }
    }

    public function userRegister(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'email' => 'required|email|unique:customer,email',
            'phone' => 'required|regex:/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/',
            'password' => 'required|min:8|confirmed', //^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$
        ]);

        // session(['registration_data' => [
        //     'email' => $request->email,
        // ]]);

        $response = AuthFacade::register($request->all());

        if ($response['success']) {
            return response()->json($response, 400);
        } else {
            return response()->json($response, 200);
        }
    }

    // Handle otp
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

        if (session('otp_code') == $otp) {
            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully.',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP.',
            ], 400);
        }
    }

    // Handle user logout
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->intended('/userlogin');
    }
}
