<?php
//Loo Wee Kiat
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\StaffOtpMail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        $staff = Admin::all();
        return view('admin.staff_list', ['staff' => $staff]);
    }

    public function showCreateForm()
    {
        return view('admin.create_staff');
    }

    public function showVerifyOtpForm(Request $request)
    {
        Log::info('Request Query: ', $request->query());
        $email = $request->query('email');
        Log::info('Email extracted: ' . $email);

        return view('admin.verify_otp', ['email' => $email]);
    }


    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'role' => 'required|string|max:255',
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:admin,email',
        ]);

        $admin = Admin::create([
            'role' => $validatedData['role'],
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => '',
            'status' => 'pending',
        ]);

        $otpCode = Str::random(6);
        $expiry = Carbon::now()->addMinutes(15);

        AdminVerification::create([
            'admin_id' => $admin->admin_id,
            'code' => $otpCode,
            'status' => 'pending',
            'expired_date' => $expiry,
        ]);

        Mail::to($admin->email)->send(new StaffOtpMail($admin->email, $otpCode));

        return redirect()->route('admin.staff')->with('success', 'Verification email sent! Please check your email.');
    }

    public function verifyOtp(Request $request)
    {
        Log::info('verifyOtp function triggered', $request->all());

        $validatedData = $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        Log::info('Email in verifyOtp: ' . $validatedData['email']);

        $admin = Admin::where('email', $request->email)->first();

        Log::info($admin);

        if (!$admin) {
            return redirect()->back()->with('error', 'Admin not found.');
        }

        $adminVerification = AdminVerification::where('admin_id', $admin->admin_id)
            ->where('code', $request->otp)
            ->where('status', 'pending')
            ->where('expired_date', '>=', Carbon::now())
            ->first();

        if (!$adminVerification) {
            return redirect()->back()->with('error', 'Invalid or expired OTP.');
        }

        return view('admin.staff_setPassword', ['email' => $request->email, 'otp' => $request->otp]);
    }


    public function setPassword(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'password' => 'required|string|min:3|confirmed',
            'email' => 'required|string|email',
            'otp' => 'required|string',
        ]);
    
        $admin = Admin::where('email', $validatedData['email'])->first();
    
        if (!$admin) {
            return redirect()->route('admin.staff')->with('error', 'Admin not found.');
        }
    
        $adminVerification = AdminVerification::where('admin_id', $admin->admin_id)
            ->where('code', $validatedData['otp'])
            ->where('status', 'pending') 
            ->where('expired_date', '>=', Carbon::now())
            ->first();
    
        if (!$adminVerification) {
            return redirect()->back()->with('error', 'Invalid or expired OTP. Please try again.');
        }
    
        $admin->password = Hash::make($validatedData['password']);
        $admin->status = 'active';
        $admin->save();
    
        $adminVerification->status = 'verified';
        $adminVerification->save();
    
        return redirect()->route('admin.staff')->with('success', 'Password set and staff verified successfully!');
    }
    

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Staff member not found'], 404);
        }

        $validatedData = $request->validate([
            'role' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        $admin->role = $validatedData['role'];
        $admin->status = $validatedData['status'];
        $admin->save();

        return response()->json(['success' => true, 'message' => 'Staff updated successfully']);
    }
}
