<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Promotionitem;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{

    
   public function addToCart(Request $request)
   {
       try {

        //Databse security
           $request->validate([
               'customer_id' => 'required|numeric',
               'product_id' => 'required|numeric',
               'promotion_id' => 'required|numeric',
               'quantity' => 'required|numeric',
               'subtotal' => 'required|numeric',
               'discount' => 'required|numeric',
               'total' => 'required|numeric',
           ]);
        
       } catch (Exception $e) {
           return response()->json(['faillure' => false, 'message' => $e->getMessage()], 400);

       }finally{
        // Databse security
        CartItem::create([
            'customer_id' => $request->customer_id,
            'product_id' => $request->product_id,
            'promotion_id' => $request->promotion_id,
            'quantity' => $request->quantity,
            'subtotal' => $request->subtotal,
            'discount' => $request->discount,
            'total' => $request->total,
            ]);

            return response()->json(['success' => true, 'message' => 'You have successfully added a product.'], 200);
       }
   }

   public function getCartItemByCustomerID()
   {
       try {
        //communication security 
            $user = Auth::guard('customer')->user();
            $customerID = $user->customer_id;

           // Databse security
           $cartItems = CartItem::where('customer_id', $customerID)->get();

           $products = [];
           $promotions= [];

           if ($cartItems->isEmpty()) {
                $cartItems = null;
           }else{
            
            foreach ($cartItems as $cartItem) {

                if ($cartItem->promotion_id == null) {
                    // Database security
                    $cartItem->product = Product::where('product_id', $cartItem->product_id)->first();
                } else {
                    // Database security
                    $cartItem->promotion = Promotion::where('promotion_id', $cartItem->promotion_id)->first();
                    $cartItem->promotion->products = PromotionItem::where('promotion_id', $cartItem->promotion_id)->get();
                    foreach( $cartItem->promotion->products as $product){
                        $product = Product::where('product_id', $cartItem->product_id)->first();
                    }

                }
            }
            
           }

              return view('cart', ['cartItems'=>$cartItems]);
       } catch (Exception $e) {
        return response()->json(['error' => 'Unable to retreive cart at this time.'], 500);
       }
   }
   

   public function updateQuantity(Request $request, $id)
    {
    
        try{
            //Databse security
            if(
            $request->validate([
                'quantity' => 'required|integer|min:1',
            ])){

            // Databse security
            $cartItem = CartItem::find($id);
            
            if ($cartItem) {
                $cartItem->quantity = $request->input('quantity');
                $cartItem->save();

                return response()->json(['success' => true]);
            }

            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to update cart at this time.'], 500);
        }
    }

    public function updateDiscount(Request $request, $id)
    {
        try{
            //Databse security
            $request->validate([
            'discount' => 'required|numeric',
            ]);

            // Databse security
            $cartItem = CartItem::find($id);
            if ($cartItem) {
                $cartItem->discount = $request->input('discount');
                $cartItem->save();

                return response()->json(['success' => true]);
            }
        }catch (Exception $e) {
            return response()->json(['error' => 'Unable to update cart at this time.'], 500);
        }

    }

    public function updateSubtotal(Request $request, $id)
    {
       try{ //Databse security
        $request->validate([
            'subtotal' => 'required|numeric',
        ]);

        // Databse security
        $cartItem = CartItem::find($id);
        if ($cartItem) {
            $cartItem->subtotal = $request->input('subtotal');
            $cartItem->save();

            return response()->json(['success' => true]);
        }

        }catch (Exception $e) {
            return response()->json(['error' => 'Unable to update cart at this time.'], 500);
        }
    }

public function updateTotal(Request $request, $id)
{
    try{
        //Databse security
        $request->validate([
            'total' => 'required|numeric',
        ]);

        // Databse security
        $cartItem = CartItem::find($id);
        if ($cartItem) {
            $cartItem->total = $request->input('total');
            $cartItem->save();

            return response()->json(['success' => true]);
        }

    }catch (Exception $e) {
        return response()->json(['error' => 'Unable to update cart at this time.'], 500);
    }
}

public function removeCartItem(Request $request, $id){
    try {
        //communication security 
        $user = Auth::guard('customer')->user();
        $customerID = $user->customer_id;

        $cart = Cart::where('customer_id', $customerID)->first();   
        $cart->subtotal = $request->newSubtotal;  
        $cart->total = $request->newTotal;    
        $cart->total_discount = $request->newTotalDiscount;    
        $cart->save();

        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();


        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Cart item removed successfully'
        ], 200);

    } catch (Exception $e) {
        // Log::error('Fetching cart items failed: ' . $e->getMessage());
        return response()->json(['error' => 'Unable to update cart at this time.'], 500);
    
    }
}
}