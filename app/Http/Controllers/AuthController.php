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

    public function userLogin(Request $request)
    {
        if (AuthFacade::isLoggedIn()) {
            return response()->json(['success' => 'Message saved successfully!', 'data' => 'You have logged in']);
        }

        // Validate the login form
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
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

            return response()->json(['success' => true, 'redirect_url' => '/profile']);
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

        $response = AuthFacade::register($request->all());

        if ($response['success']) {
            $otp = rand(100000, 999999);

            Log::info($response);
            Log::info($otp);

            session(['customer_id' => $response['customer_id']]);
            Log::info('Customer ID stored in session: ' . session('customer_id'));


            $verification = Verification::create([
                'customer_id' => $response['customer_id'],
                'code' => $otp,
                'status' => 'pending',
                'expired_date' => Carbon::now()->addMinutes(5), // expire 5 minutes
            ]);

            Log::info($verification);

            Mail::to($request->email)->send(new OtpMail($otp));

            return response()->json(['success' => true, 'redirect_url' => route('user.verify')]);
        } else {
            return redirect()->back()->withErrors($response['message']);
        }
    }

    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:customer,email',
        ]);

        $response = AuthFacade::register($request->all());

        if ($response['success']) {

            return response()->json(['success' => true, 'redirect_url' => route('user.verify')]);
        } else {
            return redirect()->back()->withErrors($response['message']);
        }
    }

    // Handle otp
    public function verify(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'otp1' => 'required|numeric',
            'otp2' => 'required|numeric',
            'otp3' => 'required|numeric',
            'otp4' => 'required|numeric',
            'otp5' => 'required|numeric',
            'otp6' => 'required|numeric',
        ]);

        $otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4 . $request->otp5 . $request->otp6;

        $customer_id = session('customer_id');
        Log::info(session('customer_id'));

        if (!$customer_id) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.',
            ], 404);
        }

        $verificationQuery = Verification::where('customer_id', $customer_id)
            ->where('status', 'pending')
            ->where('expired_date', '>=', Carbon::now());

        Log::info($verificationQuery->toSql());
        Log::info($verificationQuery->getBindings());

        $verification = Verification::where('customer_id', $customer_id)
            ->where('status', 'pending')
            ->where('expired_date', '>=', Carbon::now())
            ->first();

        Log::info($verification);

        if (!$verification) {
            return response()->json([
                'success' => false,
                'message' => 'OTP not found or has expired.',
            ], 400);
        }

        if ($verification->code === $otp) {
            $verification->status = 'verified';
            $verification->save();

            $customer = Customer::find($customer_id);
            if ($customer->status !== 'active') {
                $customer->status = 'active';
                $customer->save();
            }

            return redirect()->route(route: 'user.login')->with('message', 'Verification complete, please proceed with login');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP.',
            ], 400);
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
        return view('admin.login');
    }

    public function adminLogin(Request $request)
    {
        try {
            if (Auth::guard('admin')->check()) {
                return response()->json(['success' => true, 'data' => 'Sorry, You already logged in'], 200); // 200 = process success
            }

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
