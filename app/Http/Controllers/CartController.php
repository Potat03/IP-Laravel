<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Promotion;

use function Laravel\Prompts\error;
use function Pest\Laravel\json;
use App\Models\Cart;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $customer = null;
        try{
            $customer = Auth::guard('customer')->user();
        }
        catch(\Exception $e){
            return response()->redirectToRoute('auth.showForm');
        }

        $cartItem = new CartItem();

        try{
            $cartItem->customer_id = $customer->id;
        }
        catch(\Exception $e){
            return response()->redirectToRoute('auth.showForm');
        }

        if($request->type == 'product'){
            $cartItem->product_id = $request->product_id;
            $validProduct = Product::find($request->product_id);
            if($validProduct == null){
                return response()->json([
                    'error' => 'Invalid product',
                    'message' => 'Invalid product'
                ], 400);
            }else if($validProduct->stock < $request->quantity){
                    return response()->json([
                        'error' => 'Invalid quantity',
                        'message' => 'Invalid quantity'
                    ], 400);
                
            }else{
                $cartItem->quantity = $request->quantity;
                $cartItem->subtotal = $validProduct->price;
                $cartItem->discount = 0;
                $cartItem->details = $request->size . ',' . $request->color;
                $cartItem->total = $validProduct->price;
                $cartItem->save();
            }
        }
        else if($request->type == 'promotion'){
            $cartItem->promotion_id = $request->promotion_id;
            $cartItem->quantity = $request->quantity;
            $validPromotion = Promotion::find($request->promotion_id);
            if($validPromotion == null){
                return response()->json([
                    'error' => 'Invalid promotion',
                    'message' => 'Invalid promotion'
                ], 400);
            }else{
                $details = [];
                foreach($request->products as $product){
                    $details[] = [
                        'product_id' => $product['product_id'],
                        'size' => $product['size'],
                        'color' => $product['color']
                    ];
                }
                $cartItem->details = json_encode($details);
                $cartItem->subtotal = $validPromotion->original_price;
                $cartItem->discount = $validPromotion->discount;
                $cartItem->total = $validPromotion->original_price - $validPromotion->discount_amount;
                $cartItem->save();
            }
        }
        else{
            return response()->json([
                'error' => 'Invalid type',
                'message' => 'Invalid type'
            ], 400);
        }
    }
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
