<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Promotion;

use function Laravel\Prompts\error;
use function Pest\Laravel\json;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $customer = null;
        $cartItem = new CartItem();
        try {
            $customer = Auth::guard('customer')->user();
            $cartItem->customer_id = $customer->id;
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['success' => false, 'message' => 'You must be logged in to add to cart'], 401);
        }

        if ($request->type == 'product') {
            $cartItem->product_id = $request->product_id;
            $validProduct = Product::find($request->product_id);
            if ($validProduct == null) {
                return response()->json(['success' => false, 'message' => 'Invalid product'], 404);
            } else if ($validProduct->stock < $request->quantity) {
                return response()->json(['success' => false, 'message' => 'Not enough stock'], 400);
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
                $cartItem->details = json_encode($details);
                $cartItem->subtotal = $validPromotion->original_price;
                $cartItem->discount = $validPromotion->discount;
                $cartItem->total = $validPromotion->original_price - $validPromotion->discount_amount;
                $cartItem->save();
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid type'], 404);
        }
    }
}
