<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\error;
use function Pest\Laravel\json;
use App\Models\Cart;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $cartItem = new CartItem();
        try {
            $customer = Auth::guard('customer')->user();
            $cartItem->customer_id = $customer->customer_id;
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'You must be logged in to add to cart'], 401);
        }

        if ($request->type == 'product') {
            $cartItem->product_id = $request->product_id;
            $validProduct = Product::find($request->product_id);
            $existingCartItem = CartItem::where('customer_id', $cartItem->customer_id)->where('product_id', $cartItem->product_id)->first();
            if ($validProduct == null) {
                return response()->json(['success' => false, 'message' => 'Invalid product'], 404);
            } else if ($validProduct->stock < $request->quantity) {
                return response()->json(['success' => false, 'message' => 'Not enough stock'], 403);
            } else if ($existingCartItem != null) {
                $existingCartItem->quantity += $request->quantity;
                $existingCartItem->subtotal += $validProduct->price;
                $existingCartItem->total += $validProduct->price;
                $existingCartItem->save();
            } else {
                $cartItem->quantity = $request->quantity;
                $cartItem->subtotal = $validProduct->price;
                $cartItem->discount = 0;
                $cartItem->details = $request->size . ',' . $request->color;
                $cartItem->total = $validProduct->price;
                $cartItem->save();
            }
        } else if ($request->type == 'promotion') {
            $cartItem->promotion_id = $request->promotion_id;
            $cartItem->quantity = $request->quantity;
            $validPromotion = Promotion::find($request->promotion_id);
            if ($validPromotion == null) {
                return response()->json(['success' => false, 'message' => 'Invalid promotion'], 404);
            } else {
                $details = [];
                foreach ($request->products as $product) {
                    $details[] = [
                        'product_id' => $product['product_id'],
                        'size' => $product['size'],
                        'color' => $product['color']
                    ];
                }
                $exists = CartItem::where('customer_id', $cartItem->customer_id)->where('promotion_id', $cartItem->promotion_id)->where('details', json_encode($details))->first();
                if($exists != null) {
                    $exists->quantity += $request->quantity;
                    $exists->subtotal += $validPromotion->original_price * $request->quantity;
                    $exists->discount = $validPromotion->discount * $request->quantity;
                    $exists->total += $validPromotion->original_price - $validPromotion->discount_amount * $request->quantity;
                    $exists->save();
                }else{
                    $cartItem->details = json_encode($details);
                    $cartItem->subtotal = $validPromotion->original_price * $request->quantity;
                    $cartItem->discount = $validPromotion->discount * $request->quantity;
                    $cartItem->total = $validPromotion->original_price - $validPromotion->discount_amount * $request->quantity;
                    $cartItem->save();
                }
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid type'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Item added to cart']);
    }

    public function updateSubtotal(Request $request)
    {
        //comunication security     
        $user = Auth::guard('customer')->user();
        $customerID = $user->customer_id;
        
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
        //comunication security     
            $user = Auth::guard('customer')->user();
            $customerID = $user->customer_id;
                        
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
          //comunication security     
          $user = Auth::guard('customer')->user();
          $customerID = $user->customer_id;
      

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
