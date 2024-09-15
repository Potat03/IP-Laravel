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
        return view('userprofile/profile');
    }

    public function orderHistorySec()
    {
        return view('userprofile/orderHistorySec');
    }

    public function shippingSec()
    {
        return view('userprofile/shippingSec');
    }

    public function supportChatSec()
    {
        return view('userprofile/supportChatSec');
    }

    public function settingSec()
    {
        return view('userprofile/settingSec');
    }
    
}
