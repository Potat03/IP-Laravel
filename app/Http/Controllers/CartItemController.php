<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{

    
   public function addToCart(Request $request)
   {
       try {
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
            //$user = Auth::guard('customer')->user();
            //$customerID = $user->id;
            $customerID = 1;

           // Find the cart items by customer_id
           $cartItems = CartItem::where('customer_id', $customerID)->get();

           $products = [];
           $promotions= [];

           if ($cartItems->isEmpty()) {
               Log::warning('No cart items found for Customer ID: ' . $customerID);
           }else{
            
            for ($i = 0; $i < $cartItems->count(); $i++) {
                $cartItem = $cartItems[$i]; // Access the item in the collection

                if($cartItem->promotion_id == null){
                    $cartItem->product = Product::where('product_id', $cartItem->product_id)->first();
                    // $product = Product::where('product_id', $cartItem->product_id)->first(); // Use first() to get a single result
                    // $products[] = $product;
                }else{
                    $promotion = Product::where('promotion_id', $cartItem->product_id)->first(); 
                    $promotions[] = $promotion;
                }
            }
           }
   

        //    return response()->json(['cartItems'=>$cartItems, 'products'=>$products, 'promotions' => $promotions]);
           //return to view
              return view('cart', ['cartItems'=>$cartItems, 'products'=>$products, 'promotions' => $promotions]);
       } catch (Exception $e) {
           Log::error('Fetching cart items failed: ' . $e->getMessage());
           return response()->json(['error' => 'Fetching cart items failed.'], 500);
       }
   }
   

   

//    public function getCartItem($id)
//    {
//        try {
//            Log::info('Fetching cart item with ID: ' . $id);
   
//            $cartItem = CartItem::findOrFail($id);
   
//            Log::info('Cart item retrieved:', $cartItem->toArray());
   
//            return response()->json($cartItem);
//        } catch (ModelNotFoundException $e) {
//            Log::warning('Cart item not found for ID: ' . $id);
//            return response()->json(['error' => 'Product not found.'], 404);
//        } catch (Exception $e) {
//            Log::error('Fetching product failed: ' . $e->getMessage());
//            return response()->json(['error' => 'Fetching product failed.'], 500);
//        }
//    }

// public function getCartItems(Request $request)
// {
//     try {
//         // Retrieve an array of IDs from the request
//         $ids = $request->input('ids');

//         // Validate that 'ids' is an array
//         if (!is_array($ids)) {
//             throw new \InvalidArgumentException('IDs should be an array.');
//         }

//         // Log the incoming IDs
//         Log::info('Fetching cart items with IDs: ' . implode(', ', $ids));

//         // Retrieve the cart items with the given IDs
//         $cartItems = CartItem::whereIn('id', $ids)->get();

//         // Log the retrieved cart items
//         Log::info('Cart items retrieved:', $cartItems->toArray());

//         // Return the cart items directly as JSON
//         return response()->json($cartItems);
//     } catch (\InvalidArgumentException $e) {
//         Log::warning('Invalid input for IDs: ' . $e->getMessage());
//         return response()->json(['error' => 'Invalid input.'], 400);
//     } catch (Exception $e) {
//         Log::error('Fetching cart items failed: ' . $e->getMessage());
//         return response()->json(['error' => 'Fetching cart items failed.'], 500);
//     }
// }


 
}
