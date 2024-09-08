<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collectible;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Log;

class CollectiblesController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = $request->input('search');
            
            if ($query) {
                $collectibleIds = Collectible::where('name', 'LIKE', "%$query%")->pluck('product_id');
            } else {
                $collectibleIds = Collectible::pluck('product_id');
            }

            $products = Product::whereIn('product_id', $collectibleIds)->paginate(20);
            return view('shop.collectible', ['products' => $products]);
        } catch (Exception $e) {
            Log::error('Fetching collectibles failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching collectibles failed.'], 500);
        }
    }
}
