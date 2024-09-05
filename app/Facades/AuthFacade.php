<?php

namespace App\Facades;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use Exception;

class AuthFacade
{
    public static function login($credentials)
    {
        if (Auth::attempt($credentials)) {
            return true;
        }

        return false;
    }

    public static function register($data)
    {
        try {
            Customer::create([
                'username' => $data['username'],
                'tier' => 'Basic',
                'phone_number' => $data['phone'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'status' => 'Activated',
            ]);
            return ['success' => true, 'message' => 'You have successfully registered an account'];
        } catch (Exception $e) {
            return ['failure' => false, 'message' => $e->getMessage()];
        }
    }

    public static function verify($data) {}

    public static function logout()
    {
        Auth::logout();
    }
}
