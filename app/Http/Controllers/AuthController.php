<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Facades\AuthFacade;
use Illuminate\Support\Facades\Log;
use App\Models\Verification;
use Carbon\Carbon;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Customer;
use App\Rules\Recaptcha;


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
        if (AuthFacade::isLoggedIn()) {
            return response()->json(['success' => 'Message saved successfully!', 'data' => 'You have logged in']);
        }

        // Validate the login form
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => ['required', new Recaptcha],
        ]);

        $credentials = $request->only('email', 'password');

        $user = Customer::where('email', $credentials['email'])->first();

        if (!$user || $user->status != 'active') {
            return response()->json(['success' => false, 'message' => 'Your account is inactive or does not exist.'], 403);
        }

        if (AuthFacade::login($credentials)) {
            AuthFacade::regenerateSession($request);

            Log::info($request->session()->token());
            Log::info(AuthFacade::getUser());

            return response()->json(['success' => true, 'redirect_url' => '/profileSec']);
        } else {
            return response()->json(['success' => false, 'message' => 'Wrong credentials']);
        }
    }

    public function userRegister(Request $request)
    {

        Log::info('Recaptcha URL', ['url' => 'https://www.google.com/recaptcha/api/siteverify']);
        
        $request->validate([
            'username' => 'required|string|max:50',
            'email' => 'required|email|unique:customer,email',
            'phone' => 'required|regex:/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/',
            'password' => 'required|min:8|confirmed', //^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$
            'g-recaptcha-response' => ['required', new Recaptcha],
        ]);

        Log::info('Recaptcha URL', ['url' => 'https://www.google.com/recaptcha/api/siteverify']);

        $response = AuthFacade::register($request->all());

        if ($response['success']) {
            session(['otp_context' => 'registration']);
            AuthFacade::sendOtp($response);

            return response()->json(['success' => true, 'redirect_url' => route('user.verify')]);
        } else {
            return redirect()->back()->withErrors($response['message']);
        }
    }

    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $response = AuthFacade::forgetPass($request);

        if ($response['success']) {

            session(['otp_context' => 'forget_password']);
            $sendOtp_response = AuthFacade::sendOtp($response);

            if ($sendOtp_response['success']) {
                return response()->json(['success' => true, 'redirect_url' => route('user.verify')], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to send OTP.'], 500);
            }
        } else {
            return redirect()->back()->withErrors(['email' => $response['message']]);
        }
    }

    // handle otp
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

        $context = session('otp_context', 'forget_password');

        $response = AuthFacade::verifyOtp($request, $context);
        $customer_id = session('customer_id');

        if ($response['success']) {
            $customer = Customer::find($customer_id);
            if ($customer->status !== 'active') {
                $customer->status = 'active';
                $customer->save();
            }

            if (!$customer) {
                return redirect()->back()->withErrors($response['message']);
            } else {
                if ($context === 'forget_password') {
                    return redirect()->route('user.enterForget')->with('message', 'Please enter your new password');
                } else {
                    return redirect()->route('user.login')->with('message', 'Verification complete, please proceed with login');
                }
            }
        } else {
            return back()->withErrors(['otp' => $response['message']]);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
    
        $response = AuthFacade::updatePass($request->all());
    
        if ($response['success']) {
            return response()->json(['success' => true, 'redirect_url' => route('user.login')], 200);
        } else {
            return response()->json(['success' => false, 'message' => $response['message']], 400);
        }
    }
    
    public function resendOtp(Request $request)
    {
        $email = $request->input('email');

        $customer = Customer::where('email', $email)->first();

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found.']);
        }

        $otp = rand(100000, 999999);
        Verification::updateOrCreate(
            ['customer_id' => $customer->id],
            ['code' => $otp, 'status' => 'pending', 'expired_date' => now()->addMinutes(10)]
        );

        Mail::to($customer->email)->send(new OtpMail($otp));

        return response()->json(['success' => true, 'message' => 'OTP resent successfully.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->intended('/userlogin');
    }
}
