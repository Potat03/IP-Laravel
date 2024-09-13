<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    public function updateSubtotal(Request $request)
    {
        //$user = Auth::guard('customer')->user();
        //$customerID = $user->id;
            
        $customerID = 1;
        
        //Databse security
        $request->validate([
            'subtotal' => 'required|numeric',
        ]);
    
        //Databse security
        $cart = Cart::where('customer_id', $customerID)->first();
        if ($cart) {
            $cart->subtotal = $request->input('subtotal');
            $cart->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 404);
    }

    public function updateTotal(Request $request)
    {
              //$user = Auth::guard('customer')->user();
            //$customerID = $user->id;
            
            $customerID = 1;
            
        //Databse security
        $request->validate([
            'total' => 'required|numeric',
        ]);
    
        //Databse security
        $cart = Cart::where('customer_id', $customerID)->first();
        if ($cart) {
            $cart->total = $request->input('total');
            $cart->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 404);
    }

    public function updateDiscount(Request $request)
    {
              //$user = Auth::guard('customer')->user();
            //$customerID = $user->id;
            
            $customerID = 1;

        //Databse security
        $request->validate([
            'discount' => 'required|numeric',
        ]);
    
        //Databse security
        $cart = Cart::where('customer_id', $customerID)->first();
        if ($cart) {
            $cart->total_discount = $request->discount;
            $cart->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 404);
    }
}
