<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Exception;
use Illuminate\Support\Facades\Log;

class RatingController extends Controller
{
    public function fetchRatings($newArrivalsId)
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

            // Return grouped ratings
            return $groupedRatings;
        } catch (Exception $e) {
            Log::error('Fetching ratings failed: ' . $e->getMessage());
            return []; // Return an empty array in case of failure
        }
    }

    public function fetchRatingsForWearable($ids, $products)
    {
        try {
            $ratings = Rating::whereIn('product_id', $ids)
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

            $products->getCollection()->transform(function ($product) use ($groupedRatings) {
                $productId = (int) $product->product_id;

                $productRatings = $groupedRatings[$productId] ?? [];

                $averageRating = collect($productRatings)->avg('star_rating') ?? 0;
                $product->averageRating = $averageRating;
                $product->reviewsCount = count($productRatings);

                return $product;
            });

            return $products;
        } catch (Exception $e) {
            Log::error('Fetching ratings failed: ' . $e->getMessage());
            throw new Exception('Fetching ratings failed.');
        }
    }

    public function fetchRatingsForConsumable($id, $products)
    {
        try {
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

            $products->getCollection()->transform(function ($product) use ($groupedRatings) {
                $productId = (int) $product->product_id;

                $productRatings = $groupedRatings[$productId] ?? [];

                $averageRating = collect($productRatings)->avg('star_rating') ?? 0;
                $product->averageRating = $averageRating;
                $product->reviewsCount = count($productRatings);

                return $product;
            });

            return $products;
        } catch (Exception $e) {
            Log::error('Fetching ratings failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching ratings failed.'], 500);
        }
    }

    public function fetchRatingsForCollectible($ids, $products)
    {
        try {
            $ratings = Rating::whereIn('product_id', $ids)
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

            $products->getCollection()->transform(function ($product) use ($groupedRatings) {
                $productId = (int) $product->product_id;

                $productRatings = $groupedRatings[$productId] ?? [];

                $averageRating = collect($productRatings)->avg('star_rating') ?? 0;
                $product->averageRating = $averageRating;
                $product->reviewsCount = count($productRatings);

                return $product;
            });

            return $products;
        } catch (Exception $e) {
            Log::error('Fetching ratings failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching ratings failed.'], 500);
        }
    }

    public function fetchRatingsForShop($ids, $products)
    {
        try {
            $ratings = Rating::whereIn('product_id', $ids)
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

            $products->getCollection()->transform(function ($product) use ($groupedRatings) {
                $productId = (int) $product->product_id;

                $productRatings = $groupedRatings[$productId] ?? [];

                $averageRating = collect($productRatings)->avg('star_rating') ?? 0;
                $product->averageRating = $averageRating;
                $product->reviewsCount = count($productRatings);

                return $product;
            });

            return $products;
        } catch (Exception $e) {
            Log::error('Fetching ratings failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching ratings failed.'], 500);
        }
    }
}
