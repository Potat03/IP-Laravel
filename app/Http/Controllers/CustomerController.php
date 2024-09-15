<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function profile()
    {
        $customer = Auth::guard('customer')->user();

        return view('userprofile/layout/userProfile', compact('customer'));
    }
    public function profileSec()
    {
        return view('profile.profileSec');
    }

    public function orderHistorySec()
    {
        return view('profile.orderHistorySec');
    }

    public function shippingSec()
    {
        return view('profile.shippingSec');
    }

    public function supportChatSec()
    {
        return view('profile.supportChatSec');
    }

    public function settingSec()
    {
        return view('profile.settingSec');
    }
    
}
