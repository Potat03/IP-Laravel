<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wearable;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;

class WearableController extends Controller
{
    // Read all products
    public function index(Request $request)
    {
        try {
            $query = $request->input('search');

            if ($query) {
                $wearableIds = Wearable::where('name', 'LIKE', "%$query%")->pluck('product_id');
            } else {
                $wearableIds = Wearable::pluck('product_id');
            }

            $products = Product::whereIn('product_id', $wearableIds)->paginate(20);

            return view('shop.wearable', ['products' => $products]);
        } catch (Exception $e) {
            Log::error('Fetching wearable failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching wearable failed.'], 500);
        }
    }
}
