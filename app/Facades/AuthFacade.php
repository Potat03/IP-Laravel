<?php

namespace App\Facades;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Verification;
use Exception;

class AuthFacade
{
    public static function login($credentials, $guard = 'customer')
    {
        if (Auth::guard($guard)->attempt($credentials)) {
            return true;
        }

        return false;
    }

    public static function isLoggedIn($guard = 'customer')
    {
        return Auth::guard($guard)->check();
    }

    public static function regenerateSession($request)
    {
        $request->session()->regenerate();
    }

    public static function getUser($guard = 'customer')
    {
        return Auth::guard($guard)->user();
    }

    public static function register($data)
    {
        try {
            // Create a new customer and capture the instance
            $customer = Customer::create([
                'username' => $data['username'],
                'tier' => 'Basic',
                'phone_number' => $data['phone'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'status' => 'inactive',
            ]);

            if ($customer) {
                $customer_id = $customer->getId();

                return [
                    'success' => true,
                    'customer_id' => $customer_id
                ];
            } else {
                return ['success' => false, 'message' => 'Customer creation failed'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function verify($data)
    {
        //otp
        $otpCode = rand(100000, 999999);

        try {
            Verification::create([
                'customer_id' => $data['username'],
                'code' => $otpCode,
                'status' => "active",
            ]);
            return ['success' => true, 'message' => 'You have successfully registered an account'];
        } catch (Exception $e) {
            return ['failure' => false, 'message' => $e->getMessage()];
        }

        if (isset($response['success']) && $response['success']) {
            return response()->json($response, 200);
        }
    }

    public static function logout()
    {
        Auth::logout();
    }
}
