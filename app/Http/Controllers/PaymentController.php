<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Promotion;





class PaymentController extends Controller
{
    
    public function processCheckout(Request $request)
{
  $customerID = 1;
         $request->validate([
            'first_name' => 'required|regex:/^[\pL\s]+$/u',
            'last_name' => 'required|regex:/^[\pL\s]+$/u',
            'delivery_address' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|digits_between:10,15',
            'name_on_card' => 'required|regex:/^[\pL\s]+$/u',
            'card_number' => 'required|digits:16',
            'ccv' => 'required|digits_between:3,4',
// 'expiry_date' => 'required|regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/'
         ]);

         $cart = Cart::where('customer_id', $customerID)->first();          
                 
         Order::create([
            'customer_id' => $customerID,
            'subtotal' => $cart->subtotal,
            'total_discount' => $cart->total_discount,
            'total' => $cart->total,
            'status' => 'prepare',
            'delivery_address'=> $request->delivery_address,
            'delivery_method' => 'car',
            'created_at' => now(),
            ]);


        $cartItems = CartItem::where('customer_id', $customerID)->get();
        $products = [];
        $promotions= [];

        foreach ($cartItems as $cartItem) {

            if ($cartItem->promotion_id == null) {
                // Database security
                $cartItem->product = Product::where('product_id', $cartItem->product_id)->first();
            } else {
                // Database security
                $cartItem->promotion = Promotion::where('promotion_id', $cartItem->promotion_id)->first();
            }
        }
        
          

            


         
         return response()->json(['success' => true, 'message' => 'Form submitted successfully']);




    
}


}

