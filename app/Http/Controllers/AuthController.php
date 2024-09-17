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

    function verifyCaptcha($captcha_response)
    {
        $captcha_secret = env('RECAPTCHA_SECRET_KEY'); // Replace with your actual secret key in .env
        $captcha_verify_url = "https://www.google.com/recaptcha/api/siteverify";
        $captcha_data = [
            'secret'   => $captcha_secret,
            'response' => $captcha_response
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $captcha_verify_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($captcha_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $captcha_verify = curl_exec($ch);
        curl_close($ch);

        Log::info('CAPTCHA Verification Response: ' . $captcha_verify);

        return json_decode($captcha_verify, true);
    }

    public function userLogin(Request $request)
    {
        $captcha_response = $request->input('g-recaptcha-response');

        Log::info('CAPTCHA Response from request: ' . $captcha_response);

        $responseKeys = $this->verifyCaptcha($captcha_response);

        if (!$responseKeys['success']) {
            return response()->json(['success' => false, 'message' => 'CAPTCHA verification failed.']);
        }

        if (AuthFacade::isLoggedIn()) {
            return response()->json(['success' => 'Message saved successfully!', 'data' => 'You have logged in']);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => ['required'],
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
        $request->validate([
            'username' => 'required|string|max:50',
            'email' => 'required|email|unique:customer,email',
            'phone' => 'required|regex:/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/',
            'password' => 'required|min:8|confirmed', //^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$
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

    public function showAdminLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return response()->redirectTo('/adminChat');
        }
        return view('admin.login');
    }

    public function adminLogin(Request $request)
    {
        try {

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
                    return response()->json(['success' => true, 'redirect' => route('adminChat')]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Sorry, your account is inactive'], 403); // 403 = forbidden (not permited)
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Sorry, we can\'t find your account'], 403);
            }
        } catch (\Exception $e) {
            Log::error('Admin login failed: ' . $e->getMessage()); // Kepp a log let developer know the problem
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again later.'], 500); // 500 = internal server error
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->intended('/userlogin');
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->intended('adminLogin');
    }

    public function simpleLogout(Request $request)
    {
        Auth::guard('customer')->logout();
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
