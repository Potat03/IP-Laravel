<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Directors\ProductDirector;
use App\Builders\CollectibleBuilder;
use App\Models\Collectible;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Log;

class CollectiblesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'supplier' => 'required|string'
        ]);

        $builder = new CollectibleBuilder();
        
        $director = new ProductDirector($builder);

        $collectible = $director->construct(
            [
                'supplier' => $request->supplier,
            ],
            $request->specificAttributes
        );

        // Save the product
        $collectible->save();

        return response()->json(['success' => true, 'message' => 'Collectible product added successfully.'], 200);
    }

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
