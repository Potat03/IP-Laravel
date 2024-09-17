<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contexts\ProductContext;
use App\Strategies\ConsumableStrategy;
use App\Models\Consumable;
use App\Models\Product;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ConsumablesController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'expiry_date' => 'required|date',
            'portion' => 'required|integer|min:1',
            'halal' => 'required|in:0,1'
        ]);

        try {
            // Create the specific product instance
            $consumable = new Consumable();

            // Create the specific strategy instance
            $consumableStrategy = new ConsumableStrategy($consumable);

            // Create the context with the specific strategy
            $context = new ProductContext($consumableStrategy);

            // Apply the strategies and save the product
            $context->applyStrategies(
                [
                    'expire_date' => $request->expiry_date,
                    'portion' => $request->portion,
                    'is_halal' => $request->halal,
                    'product_id' => $productId,
                ]
            );

            return response()->json(['success' => true, 'message' => 'Consumable product added successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['failure' => false, 'message' => $e->getMessage()], 400);
        }
    }

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

            $productController = new ProductController();
            $mainImages = $productController->getMainImages($consumableIds);

            $productsWithRatings = $this->fetchRatingsForConsumable($consumableIds, $products);

            return view('shop.consumable', [
                'products' => $productsWithRatings,
                'mainImages' => $mainImages,
            ]);
        } catch (Exception $e) {
            Log::error('Fetching consumables failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching consumables failed.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'expiry_date' => 'required|date_format:Y-m-d',
                'portion' => 'required|integer|min:1',
                'halal' => 'required|integer|in:0,1'
            ]);

            $consumable = Consumable::where('product_id', $id)->firstOrFail();

            $expiry_date = $validatedData['expiry_date'];
            $portion = $validatedData['portion'];
            $halal = $validatedData['halal'];

            $consumable->update([
                'expire_date' => $expiry_date,
                'portion' => $portion,
                'is_halal' => $halal,
            ]);

            $consumable->updated_at = now()->addHours(8);
            $consumable->save();

            return response()->json(['success' => true, 'message' => 'Consumable product updated successfully.'], 200);
        } catch (Exception $e) {
            Log::error('Updating consumable failed: ' . $e->getMessage());
            return response()->json(['error' => 'Updating consumable failed.'], 500);
        }
    }

    private function fetchRatingsForConsumable($consumableIds, $products)
    {
        return app('App\Http\Controllers\RatingController')->fetchRatingsForConsumable($consumableIds, $products);
    }
}
