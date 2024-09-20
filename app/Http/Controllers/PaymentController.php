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
use App\Models\PromotionItem;
use Stripe\Stripe;
use Stripe\Charge;




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
      
     ]);
         $cart = Cart::where('customer_id', $customerID)->first();          
                 
         Order::create([
            'customer_id' => $customerID,
            'subtotal' => $cart->subtotal,
            'total_discount' => $cart->total_discount,
            'total' => $cart->total,
            'status' => 'prepare',
            'delivery_address'=> $request->delivery_address,
            'created_at' => now(),
            ]);


        $cartItems = CartItem::where('customer_id', $customerID)->get();
        $products = [];
        $promotions= [];


        $order = Order::where('customer_id', $customerID)->first();          

        foreach ($cartItems as $cartItem) {

            if ($cartItem->promotion_id == null) {
                // Database security
                $cartItem->product = Product::where('product_id', $cartItem->product_id)->first();
                OrderItem::create([
                    'order_id'=>$order->order_id,
                    'product_id'=>$cartItem->product_id,
                    'promotion_id'=>null,
                    'quantity'=>$cartItem->quantity,
                    'subtotal'=>($cartItem->product->price *$cartItem->quantity),
                    'discount'=>null,
                    'total'=>($cartItem->product->price *$cartItem->quantity),
                ]);
                $product = Product::where('product_id', $cartItem->product_id)->first();
                if($product){
                    $newStockValue = $product->stock - $cartItem->quantity;

                    $product->stock = $newStockValue;
                    if ($newStockValue < 1){
                        $product->status = 'out of stock';
                    }

                    $product->save();
                }

                
            } else {
                // Database security
                $cartItem->promotion = Promotion::where('promotion_id', $cartItem->promotion_id)->first();
                OrderItem::create([
                    'order_id'=>$order->order_id,
                    'product_id'=>null,
                    'promotion_id'=>$cartItem->promotion_id,
                    'quantity'=>$cartItem->quantity,
                    'subtotal'=>($cartItem->promotion->original_price * $cartItem->quantity),
                    'discount'=>($cartItem->promotion->discount * $cartItem->quantity),
                    'total'=>($cartItem->promotion->discount_amount *$cartItem->quantity),
                ]);

                $promotionItems = PromotionItem::where('promotion_id', $cartItem->promotion->promotion_id)->get();
                foreach($promotionItems as $promotionItem){
                    $product = Product::where('product_id', $promotionItem->product_id)->first();
                    $newStockValue = $product->stock- ($promotionItem->quantity*$cartItem->quantity);

                    $product->stock = $newStockValue;
                    if ($newStockValue < 1){
                        $product->status = 'out of stock';
                    }

                    $product->save();
                }

            }

            $cartItem = CartItem::findOrFail($cartItem->id);
            $cartItem->delete(); 

           }
         
        return response()->json([
            'success' => true,
            'message' => 'Form submitted successfully',
            'data' => [
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'delivery_address' => $request->input('delivery_address'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
            ]
        ]);



    
}


}

