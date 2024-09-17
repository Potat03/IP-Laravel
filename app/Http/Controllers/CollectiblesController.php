<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contexts\ProductContext;
use App\Strategies\CollectibleStrategy;
use App\Models\Collectible;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Log;

class CollectiblesController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'supplier' => 'required|string'
        ]);

        try {
            $collectible = new Collectible();

            $collectibleStrategy = new CollectibleStrategy($collectible);

            $context = new ProductContext(specificStrategy: $collectibleStrategy);

            $context->applyStrategies(
                [
                    'supplier' => $request->supplier,
                    'product_id' => $productId,
                ]
            );

            return response()->json(['success' => true, 'message' => 'Collectible product added successfully.'], 200);

        } catch (Exception $e) {
            return response()->json(['failure' => false, 'message' => $e->getMessage()], 400);
        }
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
            // return view('shop.collectible', ['products' => $products]);

            return $this->fetchRatingsForCollectible($collectibleIds, $products);
        } catch (Exception $e) {
            Log::error('Fetching collectibles failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching collectibles failed.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'supplier' => 'required|string',
            ]);

            $collectible = Collectible::where('product_id', $id)->firstOrFail();

            $supplier = $validatedData['supplier'] ?? '';

            $collectible->update(['supplier' => $supplier]);

            $collectible->updated_at = now()->addHours(8);
            $collectible->save();

            return response()->json(['success' => true, 'message' => 'Collectible product updated successfully.'], 200);
        } catch (Exception $e) {
            Log::error('Updating collectible failed: ' . $e->getMessage());
            return response()->json(['error' => 'Updating collectible failed.'], 500);
        }
    }

    private function fetchRatingsForCollectible($collectibleIds, $products)
    {
        // Redirect to the RatingController method or handle it here
        return app('App\Http\Controllers\RatingController')->fetchRatingsForCollectible($collectibleIds, $products);
    }
}
