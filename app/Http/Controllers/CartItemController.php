<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;

class CartItemController extends Controller
{
   //product image upload
   public function addToCart(Request $request)
   {
       try {
        //    $request->validate([
        //        'customer_id' => 'required|string',
        //        'product_id' => 'required|string',
        //        'promotion_id' => 'required|string',
        //        'quantity' => 'required|numberic',
        //        'subtotal' => 'required|numberic',
        //        'discount' => 'required|numberic',
        //        'total' => 'required|numberic',
        //    ]);

           CartItem::create([
               'customer_id' => $request->customer_id,
               'product_id' => $request->product_id,
               'prmotion_id' => $request->prmotion_id,
               'quantity' => $request->quantity,
               'subtotal' => $request->subtotal,
               'discount' => $request->discount,
               'total' => $request->total,
           ]);

   
           return response()->json(['success' => true, 'message' => 'You have successfully added a product.'], 200);
       } catch (Exception $e) {
           return response()->json(['faillure' => false, 'message' => $e->getMessage()], 400);
       }
   }

}
