<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe; // Import Stripe class
use Stripe\Checkout\Session; // Import the Checkout Session class
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class StripeController extends Controller
{
    public function session(Request $request)
    {
        //comunication security     
        $user = Auth::guard('customer')->user();
        $customerID = $user->customer_id;

        $request->validate([
           'first_name' => 'required|regex:/^[\pL\s]+$/u',
           'last_name' => 'required|regex:/^[\pL\s]+$/u',
           'delivery_address' => 'required|string',
           'email' => 'required|email',
           'phone_number' => 'required|digits_between:10,15',
         
        ]);

        $cartItems = CartItem::where('customer_id', $customerID)->get();
        $products = [];
        $promotions= [];
        $lineItems=[];

        foreach ($cartItems as $cartItem) {
            if ($cartItem->promotion_id == null) {
                // Database security
                $cartItem->product = Product::where('product_id', $cartItem->product_id)->first();

                $lineItems[] = [
                    'price_data' => [
                        'currency'     => 'MYR', // You can dynamically set currency if needed
                        'product_data' => [
                            'name' => $cartItem->product->name,
                        ],
                        'unit_amount'  => $cartItem->product->price * 100, // Stripe expects the price in cents
                    ],
                    'quantity' => $cartItem->quantity,
                ];
            } else {
                // Database security
                $cartItem->promotion = Promotion::where('promotion_id', $cartItem->promotion_id)->first();

                $lineItems[] = [
                    'price_data' => [
                        'currency'     => 'MYR', // You can dynamically set currency if needed
                        'product_data' => [
                            'name' => $cartItem->promotion->title,
                        ],
                        'unit_amount'  => ($cartItem->promotion->original_price - $cartItem->promotion->discount_amount) * 100, // Stripe expects the price in cents
                    ],
                    'quantity' => $cartItem->quantity,
                ];
            }
        }

        $lineItems[] = [
            'price_data' => [
                'currency'     => 'MYR', // You can dynamically set currency if needed
                'product_data' => [
                    'name' => 'delivery fee',
                ],
                'unit_amount'  => 5 * 100, // Stripe expects the price in cents
            ],
            'quantity' => 1,
        ];

        // Set Stripe API key
        Stripe::setApiKey(config('services.stripe.secret')); // Use the secret from the config
       
        // Create the Checkout Session
        $session = Session::create([
           'line_items' => $lineItems, // Pass the array of line items here
        'mode'       => 'payment',
        'success_url' => route('success', [
            'first_name'      => $request->input('first_name'),
            'last_name'       => $request->input('last_name'),
            'delivery_address'=> $request->input('delivery_address'),
            'email'           => $request->input('email'),
            'phone_number'    => $request->input('phone_number'),
        ]),
                'cancel_url' => route('fail'), // Optional, if you want a cancel URL
        ]);

        // Redirect to the Stripe Checkout URL
        return redirect()->away($session->url);
    }

   
}