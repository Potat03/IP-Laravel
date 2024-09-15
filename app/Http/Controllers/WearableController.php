<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Directors\ProductDirector;
use App\Builders\WearableBuilder;
use App\Models\Wearable;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Log;

class WearableController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'size' => 'required|string',
            'color' => 'required|string',
            'user_group' => 'required|string'
        ]);

        // Create a WearableBuilder instance
        $builder = new WearableBuilder();
        
        // Create a director with the builder
        $director = new ProductDirector($builder);

        // Construct the product
        $wearable = $director->construct(
            [
                'size' => $request->size,
                'color' => $request->color,
                'user_group' => $request->user_group,
            ],
            $request->specificAttributes
        );

        // Save the product
        $wearable->save();

        return response()->json(['success' => true, 'message' => 'Wearable product added successfully.'], 200);
    }

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

            // return view('shop.wearable', ['products' => $products]);
            return $this->fetchRatingsForWearable($wearableIds, $products);
        } catch (Exception $e) {
            Log::error('Fetching wearable failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching wearable failed.'], 500);
        }
    }

    private function fetchRatingsForWearable($wearableIds, $products)
    {
        // Redirect to the RatingController method or handle it here
        return app('App\Http\Controllers\RatingController')->fetchRatingsForWearable($wearableIds, $products);
    }
}
