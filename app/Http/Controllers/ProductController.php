<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Adapters\ProductAdapter;

class ProductController extends Controller
{
    //product image upload
    public function productImageUpload(Request $request, $id)
    {
        try {
            $request->validate([
                'images' => 'required',
            ]);


            $imageName = "main.png";

            if ($id) {
                $folderPath = 'storage/images/products/' . $id;
            } else {
                $folderPath = 'storage/images/products/lol';
                // return response()->json(['success' => false, 'message' => 'Product ID is required.'], 400);
            }

            if (!file_exists(public_path($folderPath))) {
                mkdir(public_path($folderPath), 0777, true);
            }

            $images = $request->file('images');
            foreach ($images as $index => $image) {
                if ($index === 0) {
                    $imageName = 'main.' . $image->getClientOriginalExtension(); // The first image is named "main"
                } else {
                    $imageName = $index . '.' . $image->getClientOriginalExtension(); // Subsequent images are numbered
                }
                $image->move(public_path($folderPath), $imageName);
            }

            return response()->json(['success' => true, 'data' => 'You have successfully uploaded an image.'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => $e->getMessage()], 400);
        }
    }



        //display success message

    //add product to database
    public function addProduct(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'status' => 'required|string',
            ]);

            $id = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'status' => $request->status,
            ])->product_id;

            $product = new Product();

            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->status = $request->status;
            $product->save();
            $id = $product->product_id;

            //forward request
            //get the product id
            ProductController::productImageUpload($request, $id);


            return response()->json(['success' => true, 'message' => 'You have successfully added a product.'], 200);
        } catch (Exception $e) {
            return response()->json(['failure' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'product_id' => 'required|unique:product',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'created_at' => 'required|date'
            ]);

            // Create the product
            $product = Product::create($validatedData);

            // Return a response
            return response()->json($product, 201);
        } catch (Exception $e) {
            // Log the error
            Log::error('Product creation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Product creation failed.'], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $query = trim($request->input('search'));
            $priceSort = $request->input('price_sort');
            $rating = $request->input('rating');
            $available = $request->input('available');
            $newArrival = $request->input('new_arrival');

            // Debugging lines
            Log::info('Search Query:', ['query' => $query]);
            Log::info('Price Sort:', ['price_sort' => $priceSort]);
            Log::info('Rating:', ['rating' => $rating]);
            Log::info('Available:', ['available' => $available]);
            Log::info('New Arrival:', ['new_arrival' => $newArrival]);

            $queryBuilder = Product::query();

            // Search query
            if ($query) {
                $queryBuilder->where('name', 'LIKE', "%$query%");
            }

            // Availability filter
            if ($available) {
                $queryBuilder->where('availability', true); // Assuming there's an 'availability' field
            }

            // Rating filter
            if ($rating) {
                $queryBuilder->where('rating', '>=', $rating); // Assuming there's a 'rating' field
            }

            // New arrivals filter
            if ($newArrival) {
                $queryBuilder->where('is_new', true);
            }

            // Price sorting
            if ($priceSort) {
                if ($priceSort === 'low-high') {
                    $queryBuilder->orderBy('price', 'asc');
                } else if ($priceSort === 'high-low') {
                    $queryBuilder->orderBy('price', 'desc');
                }
            }

            $products = $queryBuilder->paginate(20);

            // Return a view or JSON response based on request type
            if ($request->ajax()) {
                return view('partials.products', ['products' => $products])->render();
            }

            return view('shop', ['products' => $products]);
        } catch (Exception $e) {
            Log::error('Fetching products failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching products failed.'], 500);
        }
    }

    //from home to shop page new arrival category
    public function newArrivals()
    {
        try {
            $newArrivals = Product::where('created_at', '>=', now()->subDays(30))
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            return view('shop.new-arrivals', ['newArrivals' => $newArrivals]);
        } catch (Exception $e) {
            Log::error('Fetching new arrivals failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching new arrivals failed.'], 500);
        }
    }

    public function getAll(Request $request)
    {
        try {
            $products = Product::all();

            return response()->json(['success' => true, 'data' => $products], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function getOne($id)
    {
        try {
            $product = Product::find($id);
            return response()->json(['success' => true, 'data' => $product], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function getProductImages($id)
    {
        $product = Product::find($id);

        // store images in array
        $images = [];
        $imageFiles = Storage::files('public/images/products/' . $id);
        foreach ($imageFiles as $file) {
            $images[] = basename($file);
        }

        return response()->json(['success' => true, 'data' => $images], 200);
    }

    // Read a single product
    public function show($id)
    {
        try {
            // Fetch the product by ID
            $product = Product::findOrFail($id);

            // Check if the product is active
            if ($product->status != 'active') {
                return response()->view('errors.404', [], 404);
            }

            // Fetch ratings for the product
            $ratings = Rating::where('product_id', $id)
                ->where('status', 'approved')
                ->get();

            // Calculate average rating and number of reviews
            $averageRating = $ratings->avg('star_rating') ?? 0;
            $reviewsCount = $ratings->count();

            // Return view with product and rating information
            return view('product', [
                'product' => $product,
                'averageRating' => $averageRating,
                'reviewsCount' => $reviewsCount,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->view('errors.404');
            // return response()->json(['error' => 'Product not found.'], 404);
        } catch (Exception $e) {
            // Log the error
            Log::error('Fetching product failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching product failed.'], 500);
        }
    }

    // Show product images
    public function showProductImages($id)
    {
        $product = Product::find($id);

        // Get all images for this product from the storage directory
        $imageFiles = Storage::files('public/images/products/' . $id);
        $images = array_map(function ($file) {
            return basename($file);
        }, $imageFiles);

        return view('product', compact('product', 'images'));
    }

    // Update a product
    public function update(Request $request, $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'created_at' => 'required|date'
            ]);

            // Find the product and update it
            $product = Product::findOrFail($id);
            $product->update($validatedData);

            // Return a response
            return response()->json($product);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found.'], 404);
        } catch (Exception $e) {
            // Log the error
            Log::error('Updating product failed: ' . $e->getMessage());
            return response()->json(['error' => 'Updating product failed.'], 500);
        }
    }

    // Delete a product
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found.'], 404);
        } 
    }

    // public function showNewArrivals()
    // {
    //     try {
    //         // Fetch new arrivals
    //         $newArrivals = Product::where('created_at', '>=', now()->subDays(30))
    //             ->orderBy('created_at', 'desc')
    //             ->take(10)
    //             ->get();

    //         return view('home', [
    //             'newArrivals' => $newArrivals,
    //         ]);
    //     } catch (Exception $e) {
    //         Log::error('Fetching new arrivals failed: ' . $e->getMessage());
    //         return response()->json(['error' => 'Fetching new arrivals failed.'], 500);
    //     }
    // }

    public function showNewArrivals()
    {
        try {
            // Fetch new arrivals
            $newArrivals = Product::where('created_at', '>=', now()->subDays(30))
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            // Get the IDs of new arrivals
            $newArrivalsId = $newArrivals->pluck('product_id');

            return $this->fetchRatingsForProducts($newArrivalsId, $newArrivals);
        } catch (Exception $e) {
            Log::error('Fetching new arrivals failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching new arrivals failed.'], 500);
        }
    }

    private function fetchRatingsForProducts($newArrivalsId, $newArrivals)
    {
        // Redirect to the RatingController method or handle it here
        return app('App\Http\Controllers\RatingController')->fetchRatings($newArrivalsId, $newArrivals);
    }
}
