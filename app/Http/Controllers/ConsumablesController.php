<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumable;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Log;

class ConsumablesController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = $request->input('search');
            
            if ($query) {
                $consumableIds = Consumable::where('name', 'LIKE', "%$query%")->pluck('product_id');
            } else {
                $consumableIds = Consumable::pluck('product_id');
            }

            $products = Product::whereIn('product_id', $consumableIds)->paginate(20);
            return view('shop.consumable', ['products' => $products]);
        } catch (Exception $e) {
            Log::error('Fetching consumables failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching consumables failed.'], 500);
        }
    }
}

