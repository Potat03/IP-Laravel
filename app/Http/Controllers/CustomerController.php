<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Customer;

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
}
