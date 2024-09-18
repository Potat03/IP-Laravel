<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Exception;
use Illuminate\Support\Facades\Log;

class RatingController extends Controller
{
    public function fetchRatings($newArrivalsId, $newArrivals)
    {
        try {
            // Fetch ratings for all new arrivals
            $ratings = Rating::whereIn('product_id', $newArrivalsId)
                ->where('status', 'approved')
                ->get();

            $groupedRatings = [];
            foreach ($ratings as $rating) {
                $productId = (int) $rating->product_id;

                if (!isset($groupedRatings[$productId])) {
                    $groupedRatings[$productId] = [];
                }
                $groupedRatings[$productId][] = $rating;
            }

            // Attach average rating and review count to each product
            $newArrivalsWithRatings = $newArrivals->map(function ($product) use ($groupedRatings) {
                $productId = (int) $product->product_id;

                $productRatings = $groupedRatings[$productId] ?? [];

                $averageRating = collect($productRatings)->avg('star_rating') ?? 0;
                $product->averageRating = $averageRating;
                $product->reviewsCount = count($productRatings);

                return $product;
            });

            // Return the correct view based on the passed parameter
            return view('home', [
                'newArrivals' => $newArrivalsWithRatings,
            ]);
        } catch (Exception $e) {
            Log::error('Fetching ratings failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching ratings failed.'], 500);
        }
    }

    public function fetchRatingsForNewArrival($newArrivalsId, $newArrivals)
    {
        try {
            // Fetch ratings for all new arrivals
            $ratings = Rating::whereIn('product_id', $newArrivalsId)
                ->where('status', 'approved')
                ->get();

            $groupedRatings = [];
            foreach ($ratings as $rating) {
                $productId = (int) $rating->product_id;

                if (!isset($groupedRatings[$productId])) {
                    $groupedRatings[$productId] = [];
                }
                $groupedRatings[$productId][] = $rating;
            }

            // Modify each item in the paginated collection without converting it to a regular collection
            $newArrivals->getCollection()->transform(function ($product) use ($groupedRatings) {
                $productId = (int) $product->product_id;

                $productRatings = $groupedRatings[$productId] ?? [];

                $averageRating = collect($productRatings)->avg('star_rating') ?? 0;
                $product->averageRating = $averageRating;
                $product->reviewsCount = count($productRatings);

                return $product;
            });

            // Pass the paginated collection with ratings to the view
            return view('shop.new-arrivals', [
                'newArrivals' => $newArrivals,  // The original pagination is preserved
            ]);
        } catch (Exception $e) {
            Log::error('Fetching ratings failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching ratings failed.'], 500);
        }
    }

    public function fetchRatingsForWearable($id, $products)
    {
        try {
            // Fetch ratings for all new arrivals
            $ratings = Rating::whereIn('product_id', $id)
                ->where('status', 'approved')
                ->get();

            $groupedRatings = [];
            foreach ($ratings as $rating) {
                $productId = (int) $rating->product_id;

                if (!isset($groupedRatings[$productId])) {
                    $groupedRatings[$productId] = [];
                }
                $groupedRatings[$productId][] = $rating;
            }

            // Modify each item in the paginated collection without converting it to a regular collection
            $products->getCollection()->transform(function ($product) use ($groupedRatings) {
                $productId = (int) $product->product_id;

                $productRatings = $groupedRatings[$productId] ?? [];

                $averageRating = collect($productRatings)->avg('star_rating') ?? 0;
                $product->averageRating = $averageRating;
                $product->reviewsCount = count($productRatings);

                return $product;
            });

            // Pass the paginated collection with ratings to the view
            return view('shop.wearable', [
                'products' => $products,  // The original pagination is preserved
            ]);
        } catch (Exception $e) {
            Log::error('Fetching ratings failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching ratings failed.'], 500);
        }
    }

    public function fetchRatingsForConsumable($id, $products)
    {
        try {
            // Fetch ratings for all new arrivals
            $ratings = Rating::whereIn('product_id', $id)
                ->where('status', 'approved')
                ->get();

            $groupedRatings = [];
            foreach ($ratings as $rating) {
                $productId = (int) $rating->product_id;

                if (!isset($groupedRatings[$productId])) {
                    $groupedRatings[$productId] = [];
                }
                $groupedRatings[$productId][] = $rating;
            }

            // Modify each item in the paginated collection without converting it to a regular collection
            $products->getCollection()->transform(function ($product) use ($groupedRatings) {
                $productId = (int) $product->product_id;

                $productRatings = $groupedRatings[$productId] ?? [];

                $averageRating = collect($productRatings)->avg('star_rating') ?? 0;
                $product->averageRating = $averageRating;
                $product->reviewsCount = count($productRatings);

                return $product;
            });

            // Pass the paginated collection with ratings to the view
            return view('shop.consumable', [
                'products' => $products,  // The original pagination is preserved
            ]);
        } catch (Exception $e) {
            Log::error('Fetching ratings failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching ratings failed.'], 500);
        }
    }

    public function fetchRatingsForCollectible($id, $products)
    {
        try {
            // Fetch ratings for all new arrivals
            $ratings = Rating::whereIn('product_id', $id)
                ->where('status', 'approved')
                ->get();

            $groupedRatings = [];
            foreach ($ratings as $rating) {
                $productId = (int) $rating->product_id;

                if (!isset($groupedRatings[$productId])) {
                    $groupedRatings[$productId] = [];
                }
                $groupedRatings[$productId][] = $rating;
            }

            // Modify each item in the paginated collection without converting it to a regular collection
            $products->getCollection()->transform(function ($product) use ($groupedRatings) {
                $productId = (int) $product->product_id;

                $productRatings = $groupedRatings[$productId] ?? [];

                $averageRating = collect($productRatings)->avg('star_rating') ?? 0;
                $product->averageRating = $averageRating;
                $product->reviewsCount = count($productRatings);

                return $product;
            });

            // Pass the paginated collection with ratings to the view
            return view('shop.collectible', [
                'products' => $products,  // The original pagination is preserved
            ]);
        } catch (Exception $e) {
            Log::error('Fetching ratings failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching ratings failed.'], 500);
        }
    }

    public function fetchRatingsForShop($id, $products)
    {
        try {
            // Fetch ratings for all new arrivals
            $ratings = Rating::whereIn('product_id', $id)
                ->where('status', 'approved')
                ->get();

            $groupedRatings = [];
            foreach ($ratings as $rating) {
                $productId = (int) $rating->product_id;

                if (!isset($groupedRatings[$productId])) {
                    $groupedRatings[$productId] = [];
                }
                $groupedRatings[$productId][] = $rating;
            }

            // Modify each item in the paginated collection without converting it to a regular collection
            $products->getCollection()->transform(function ($product) use ($groupedRatings) {
                $productId = (int) $product->product_id;

                $productRatings = $groupedRatings[$productId] ?? [];

                $averageRating = collect($productRatings)->avg('star_rating') ?? 0;
                $product->averageRating = $averageRating;
                $product->reviewsCount = count($productRatings);

                return $product;
            });

            // Pass the paginated collection with ratings to the view
            return view('shop', [
                'products' => $products,  // The original pagination is preserved
            ]);
        } catch (Exception $e) {
            Log::error('Fetching ratings failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching ratings failed.'], 500);
        }
    }
}
