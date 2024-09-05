<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use Exception;

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

        if (Auth::attempt($request->only('email', 'password'))) {
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

        try {
            // create a new customer
            Customer::create([
                'username' => $request->username,
                'tier' => "Basic",
                'phone_number' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => "Activated",
            ]);

            $customer = new Customer();

            $customer->username = $request->username;
            $customer->tier = "Basic";
            $customer->phone_number = $request->phone;
            $customer->email = $request->email;
            $customer->password = Hash::make($request->password);
            $customer->status = "Activated";
            $customer->save();

            return response()->json(['success' => true, 'message' => 'You have successfully registered an account'], 200);
        } catch (Exception $e) {
            return response()->json(['failure' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function logout()
    {
        Auth::logout();
    }
}
