<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\OtpMail;
use App\Models\Verification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    protected $customer;

    public function __construct()
    {
        $this->customer = Auth::guard('customer')->user();
    }

    public function profileSec()
    {
        return view('userprofile.profile', ['customer' => $this->customer]);
    }

    public function orderHistorySec()
    {
        return view('userprofile.orderHistorySec', ['customer' => $this->customer]);
    }

    public function shippingSec()
    {
        return view('userprofile.shippingSec', ['customer' => $this->customer]);
    }

    public function supportChatSec()
    {
        return view('userprofile.supportChatSec', ['customer' => $this->customer]);
    }

    public function settingSec()
    {
        return view('userprofile.settingSec', ['customer' => $this->customer]);
    }
    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
        ]);

        $customer->update(['username' => $validatedData['username']]);

        return redirect()->route('user.profileSec')->with('success', 'Profile updated successfully.');
    }

    public function requestOtp(Request $request)
    {
        $otp = rand(100000, 999999);
        $id = $this->customer->customer_id;
        $email = $this->customer->email;
        Log::info($id);
        Log::info($email);

        Verification::where('customer_id', $id)
            ->where('status', 'pending')
            ->update(['status' => 'expired']);

        Verification::create([
            'customer_id' => $id,
            'code' => $otp,
            'status' => 'pending',
            'expired_date' => Carbon::now()->addMinutes(5),
        ]);

        Mail::to($email)->send(new OtpMail($otp));

        return redirect()->route('profile.otpVerification')->with('message', 'OTP has been sent to your email.');
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|integer',
        ]);

        $id = $this->customer->customer_id;

        $verification = Verification::where('customer_id', $id)
            ->where('code', $request->otp)
            ->where('status', 'pending')
            ->where('expired_date', '>=', Carbon::now())
            ->first();

        if ($verification) {
            $verification->update(['status' => 'verified']);

            return redirect()->route('profile.enterNewPassword')->with('message', 'OTP verified, please enter your new password.');
        } else {
            return back()->withErrors(['otp' => 'The OTP is invalid or has expired.']);
        }
    }


    public function enterNewPassword()
    {
        return view('userprofile.enterNewPassword');
    }

    public function otpVerification()
    {
        return view('userprofile.otpVerification');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $this->customer->password = Hash::make($request->password);
        $this->customer->save();

        return redirect()->route('user.profileSec')->with('message', 'Password has been changed successfully.');
    }
}
