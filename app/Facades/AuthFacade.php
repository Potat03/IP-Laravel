<?php

namespace App\Facades;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Verification;
use App\Models\Cart;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
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
                    'customer_id' => $customer_id,
                    'email' => $customer->email
                ];
                Log::info($customer->email);
            } else {
                return ['success' => false, 'message' => 'Customer creation failed'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function sendOtp($data)
    {
        $otp = rand(100000, 999999);

        Log::info($otp);

        session(['customer_id' => $data['customer_id']]);

        Log::info('Customer ID stored in session: ' . session('customer_id'));

        $customer = Customer::where('customer_id', session('customer_id'))->first();

        Verification::where('customer_id', $data['customer_id'])
            ->where('status', 'pending')
            ->update(['status' => 'expired']);

        try {
            $verification = Verification::create([
                'customer_id' => $data['customer_id'],
                'code' => $otp,
                'status' => 'pending',
                'expired_date' => Carbon::now()->addMinutes(5), // expire in 5 minutes
            ]);

            Log::info($verification);

            Mail::to($customer->email)->send(new OtpMail($otp));

            return ['success' => true, 'message' => 'OTP had been sent'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }

        if (isset($response['success']) && $response['success']) {
            return response()->json($response, 200);
        }
    }


    public static function verifyOtp($data, $context = 'registration')
    {
        $otp = $data['otp1'] . $data['otp2'] . $data['otp3'] . $data['otp4'] . $data['otp5'] . $data['otp6'];

        $customer_id = session('customer_id');
        Log::info(session('customer_id'));

        if (!$customer_id) {
            return [
                'success' => false,
                'message' => 'Customer not found.',
            ];
        }

        $verification = Verification::where('customer_id', $customer_id)
            ->where('status', 'pending')
            ->where('expired_date', '>=', Carbon::now())
            ->first();

        Log::info($verification);

        if (!$verification) {
            return [
                'success' => false,
                'message' => 'OTP not found or has expired.',
            ];
        }

        if ($verification->code === $otp) {
            $verification->status = 'verified';
            $verification->save();

            return [
                'success' => true,
                'context' => $context,
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Invalid OTP.',
            ];
        }
    }


    public static function forgetPass($data)
    {

        $email = $data->input('email');
        $customer = Customer::where('email', $email)
            ->where('status', 'active')
            ->first();

        Log::info($customer);

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Email does not exist.'], 404);
        } else {

            return [
                'success' => true,
                'customer_id' => $customer->getId(),
            ];
        }
    }

    public static function updatePass($data)
    {
        $customer_id = session('customer_id');
        Log::info('Reach here ler');
        Log::info($customer_id);
        $customer = Customer::find($customer_id);
        Log::info($customer);

        if (!$customer) {
            Log::info("Customer not found");
            return redirect()->back()->withErrors('Customer not found.');
        }

        try {
            $customer->password = Hash::make($data['password']);
            $customer->save();
            Log::info("Save dao liao");

            return ['success' => true, 'message' => 'Password changed successfully.'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function createCart()
    {
        $customer_id = session('customer_id');

        try {
            Cart::create([
                'customer_id' => $customer_id,
            ]);

            return ['success' => true, 'message' => 'Creation fail'];
        } catch (Exception $e) {
            return ['failure' => false, 'message' => $e->getMessage()];
        }
    }

    public static function logout()
    {
        Auth::logout();
    }
}
