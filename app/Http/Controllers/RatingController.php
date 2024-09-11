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

            // // Log grouped ratings for debugging
            // foreach ($groupedRatings as $productId => $ratingArray) {
            //     Log::info('Product ID: ' . $productId . ' Ratings:', $ratingArray);
            // }

            $newArrivalsWithRatings = $newArrivals->map(function ($product) use ($groupedRatings) {
                $productId = (int) $product->product_id;

                $productRatings = $groupedRatings[$productId] ?? [];

                $averageRating = collect($productRatings)->avg('star_rating') ?? 0;
                // Log::info('Rating:'.$averageRating);

                $product->averageRating = $averageRating;
                $product->reviewsCount = count($productRatings);

                return $product;
            });

            return view('home', [
                'newArrivals' => $newArrivalsWithRatings,
            ]);
        } catch (Exception $e) {
            Log::error('Fetching ratings failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching ratings failed.'], 500);
        }
    }
}
