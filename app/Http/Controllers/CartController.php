<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $customer_id = $request->input('customer_id');
        $product_id = $request->input('product_id');
        $promotion_id = $request->input('promotion_id');
        $quantity = $request->input('quantity');
        $details = $request->input('details');
        $subtotal = $request->input('subtotal');
        $discount = $request->input('discount');
        $total = $request->input('total');

        $cart_item = CartItem::create([
            'customer_id' => $customer_id,
            'product_id' => $product_id,
            'promotion_id' => $promotion_id,
            'quantity' => $quantity,
            'details' => $details,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
        ]);

        if ($cart_item) {
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully',
                'cart_item' => $cart_item
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add item to cart'
            ]);
        }
    }
}
