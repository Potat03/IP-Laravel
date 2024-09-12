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

        return view('userProfile', compact('customer'));
    }
}
