<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wearable;
use App\Models\Collectible;
use App\Models\Consumable;
use App\Models\Rating;
use App\Contexts\ProductContext;
use App\Strategies\WearableStrategy;
use App\Strategies\CollectibleStrategy;
use App\Strategies\ConsumableStrategy;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Adapters\ProductAdapter;

class ProductController extends Controller
{
    //product image upload(for create product)
    public function productImageUpload(Request $request, $id)
    {
        try {
            $request->validate([
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'filesArray' => 'nullable|string',
            ]);

            $folderPath = $id ? 'storage/images/products/' . $id : 'storage/images/products/lol';

            if (!file_exists(public_path($folderPath))) {
                mkdir(public_path($folderPath), 0777, true);
            }

            $images = $request->file('images');
            if ($images) {
                foreach ($images as $index => $image) {
                    $imageName = $index === 0
                        ? 'main.' . $image->getClientOriginalExtension()
                        : $index . '.' . $image->getClientOriginalExtension();

                    $image->move(public_path($folderPath), $imageName);
                }

                return response()->json(['success' => true, 'data' => 'Images have been successfully uploaded.'], 200);
            }

            return response()->json(['success' => false, 'data' => 'No images were uploaded.'], 400);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => $e->getMessage()], 400);
        }
    }

    //for update product
    public function productImageUploadUpdate(Request $request, $id)
    {
        try {
            $request->validate([
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'existingImages' => 'nullable|string',
                'filesArray' => 'nullable|string',
            ]);

            $folderPath = 'storage/images/products/' . $id;
            $folderFullPath = public_path($folderPath);

            if (!file_exists($folderFullPath)) {
                mkdir($folderFullPath, 0777, true);
            }

            // Get list of existing images in the folder
            $existingImages = array_map('basename', glob($folderFullPath . '/*'));

            $existingImagesFromRequest = json_decode($request->input('existingImages', '[]'), true);
            $filesArrayFromRequest = json_decode($request->input('filesArray', '[]'), true);

            $mainImageExists = false;
            foreach (['jpg', 'png', 'jpeg'] as $extension) {
                if (in_array('main.' . $extension, $existingImages)) {
                    $mainImageExists = true;
                    break;
                }
            }

            // Remove images that are not in the existing images list
            foreach ($existingImages as $image) {
                if (!in_array($image, $existingImagesFromRequest)) {
                    if ($mainImageExists && in_array($image, ['main.jpg', 'main.png', 'main.jpeg'])) {
                        // The main image is being deleted
                        $mainImageExists = false; // Update flag
                        Log::info('Deleted main image: ' . $image);
                    }
                    unlink($folderFullPath . '/' . $image);
                    Log::info('Deleted image: ' . $image);
                }
            }

            $images = $request->file('images');
            $newMainImage = null;

            if ($images) {
                foreach ($images as $index => $image) {
                    $extension = $image->getClientOriginalExtension();
                    $imageName = '';

                    // If no main image exists, assign 'main' name to the first uploaded image
                    if (!$mainImageExists) {
                        $imageName = 'main.' . $extension;
                        $newMainImage = $imageName;
                        $mainImageExists = true; // Mark that we have assigned a main image
                    } else {
                        // Generate a unique name for the image
                        $imageName = $this->generateUniqueName($existingImages, $extension);
                    }

                    // Move the image to the folder
                    $image->move($folderFullPath, $imageName);
                    Log::info('Uploaded image: ' . $imageName);

                    // Add the new image to the existing images list
                    $existingImages[] = $imageName;
                }

                // If a new main image was assigned, log the action
                if ($newMainImage) {
                    Log::info('Assigned new main image: ' . $newMainImage);
                }
            }

            // If no new images were uploaded and no main image exists, find a new main image
            if (!$images && !$mainImageExists) {
                $remainingImages = array_diff($existingImages, ['main.jpg', 'main.png', 'main.jpeg']);
                if (!empty($remainingImages)) {
                    $newMainImage = reset($remainingImages);
                    $newMainImageExtension = pathinfo($newMainImage, PATHINFO_EXTENSION);
                    $newMainImageName = 'main.' . $newMainImageExtension;
                    rename($folderFullPath . '/' . $newMainImage, $folderFullPath . '/' . $newMainImageName);
                    Log::info('Assigned new main image from existing images: ' . $newMainImageName);
                } else {
                    Log::info('No images available to assign as main image.');
                }
            }

            return response()->json(['success' => true, 'data' => 'Images have been successfully updated.'], 200);
        } catch (Exception $e) {
            Log::error('Error updating images: ' . $e->getMessage());
            return response()->json(['success' => false, 'data' => $e->getMessage()], 400);
        }
    }

    private function generateUniqueName(array $existingImages, string $extension): string
    {
        $counter = 1;
        $uniqueName = $counter . '.' . $extension;

        while (in_array($uniqueName, $existingImages)) {
            $counter++;
            $uniqueName = $counter . '.' . $extension;
        }

        return $uniqueName;
    }

    public function addProduct()
    {
        return view('admin.product_add');
    }

    // Add product to database
    public function createProduct(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'status' => 'required|string',
                'isWearable' => 'nullable|numeric',
                'isConsumable' => 'nullable|numeric',
                'isCollectible' => 'nullable|numeric',
                'sizes' => 'nullable|string',
                'colors' => 'nullable|string',
                'expiry_date' => 'nullable|date',
                'portion' => 'nullable|string',
                'halal' => 'nullable|boolean',
                'supplier' => 'nullable|string',
                'selected_groups' => 'nullable|string',
            ]);

            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->status = $request->status;
            $product->created_at = now()->addHours(8);
            $product->save();

            // Check for specific attributes
            if ($request->has('isWearable')) {
                $this->createWearable($product, $request);
            }

            if ($request->has('isConsumable')) {
                $this->createConsumable($product, $request);
            }

            if ($request->has('isCollectible')) {
                $this->createCollectible($product, $request);
            }

            // Forward request for image upload
            // ProductController::productImageUpload($request, $id);

            return response()->json(['success' => true, 'message' => 'Product created successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['failure' => false, 'message' => $e->getMessage()], 400);
        }
    }

    protected function createWearable($product, Request $request)
    {
        $sizes = $request->input('sizes', []);
        $colors = $request->input('colors', []);
        $userGroups = $request->input('selected_groups', '');

        $sizesString = is_array($sizes) ? implode(',', $sizes) : $sizes;
        $colorsString = is_array($colors) ? implode(',', $colors) : $colors;

        $wearableObj = new WearableController();

        $wearableObj->store($request, $product->product_id);
    }

    protected function createConsumable($product, Request $request)
    {
        $consumableObj = new ConsumablesController();

        $consumableObj->store($request, $product->product_id);
    }

    protected function createCollectible($product, Request $request)
    {
        $collectibleObj = new CollectiblesController();

        $collectibleObj->store($request, $product->product_id);
    }

    public function editProduct($id)
    {
        try {
            $product = Product::findOrFail($id);

            return view('admin.product_edit', ['product' => $product]);
        } catch (Exception $e) {
            return view('errors.404');
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
            // Log::info('Search Query:', ['query' => $query]);
            // Log::info('Price Sort:', ['price_sort' => $priceSort]);
            // Log::info('Rating:', ['rating' => $rating]);
            // Log::info('Available:', ['available' => $available]);
            // Log::info('New Arrival:', ['new_arrival' => $newArrival]);

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

            // Get the IDs
            $productsCollection = collect($products->items());
            $productsId = $productsCollection->pluck('product_id');

            // Return a view or JSON response based on request type
            // if ($request->ajax()) {
            //     return view('partials.products', ['products' => $products])->render();
            // }

            // return view('shop', ['products' => $products]);

            return $this->fetchRatingsForShop($productsId, $products);
        } catch (Exception $e) {
            Log::error('Fetching products failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching products failed.'], 500);
        }
    }

    public function getAll(Request $request)
    {
        try {
            $products = Product::all();

            return view('admin.product', ['products' => $products]);
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

        $mainImageExtension = $this->getMainImageExtension($id);

        // Get all images for this product from the storage directory
        $imageFiles = Storage::files('public/images/products/' . $id);
        $images = array_map(function ($file) {
            return basename($file);
        }, $imageFiles);

        return view('product', compact('product', 'images', 'mainImageExtension'));
    }

    // Show product images for admin product
    public function showProductImagesAdmin($id)
    {
        $product = Product::find($id);

        if ($product) {
            $imagePath = storage_path('app/public/images/products/' . $product->product_id);
            $images = array_map('basename', glob($imagePath . '/*'));
            return response()->json($images);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // // Get all images for this product from the storage directory
        // $imageFiles = Storage::files('public/images/products/' . $id);
        // $images = array_map(function ($file) {
        //     return basename($file);
        // }, $imageFiles);

        // return response()->json(['success' => true, 'data' => $images], 200);
    }

    public function getMainImageExtension($productId)
    {
        $folderPath = public_path('storage/images/products/' . $productId);
        $extensions = ['jpg', 'jpeg', 'png'];

        foreach ($extensions as $extension) {
            $mainImage = 'main.' . $extension;
            if (file_exists($folderPath . '/' . $mainImage)) {
                return $extension;
            }
        }

        return null; // No main image found
    }

    // Update a product
    public function updateProduct(Request $request, $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'status' => 'required|string|in:active,inactive',
                'isWearable' => 'nullable|numeric',
                'isConsumable' => 'nullable|numeric',
                'isCollectible' => 'nullable|numeric',
                'sizes' => 'nullable|string',
                'colors' => 'nullable|string',
                'expiry_date' => 'nullable|date',
                'portion' => 'nullable|string',
                'halal' => 'nullable|boolean',
                'supplier' => 'nullable|string',
                'selected_groups' => 'nullable|string',
            ]);

            $this->productImageUploadUpdate($request, $id);

            $product = Product::findOrFail($id);
            $product->update($validatedData);

            $product->updated_at = now()->addHours(8);
            $product->save();

            if ($request->has('isWearable') && $request->input('isWearable')) {

                $this->updateWearableAttributes($product, $request);
            }

            if ($request->has('isConsumable') && $request->input('isConsumable')) {
                $this->updateConsumableAttributes($product, $request);
            }

            if ($request->has('isCollectible') && $request->input('isCollectible')) {
                $this->updateCollectibleAttributes($product, $request);
            }

            return response()->json(['success' => true, 'message' => 'Product updated successfully.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found.'], 404);
        } catch (Exception $e) {
            // Log the error
            Log::error('Updating product failed: ' . $e->getMessage());
            return response()->json(['error' => 'Updating product failed.'], 500);
        }
    }

    protected function updateWearableAttributes($product, Request $request)
    {
        $sizes = $request->input('sizes', []);
        $colors = $request->input('colors', []);
        $userGroups = $request->input('selected_groups', '');

        $sizesString = is_array($sizes) ? implode(',', $sizes) : $sizes;
        $colorsString = is_array($colors) ? implode(',', $colors) : $colors;

        $wearable = $product->wearable;
        $wearableObj = new WearableController();

        if ($wearable) {
            $wearableObj->update($request, $product->product_id);
        } else {
            Log::warning('Wearable not found for product ID: ' . $product->product_id);
        }
    }

    protected function updateConsumableAttributes($product, Request $request)
    {
        $consumable = $product->consumable;
        $consumableObj = new ConsumablesController();

        if ($consumable) {
            $consumableObj->update($request, $product->product_id);
        } else {
            Log::warning('Consumable not found for product ID: ' . $product->product_id);
        }
    }

    protected function updateCollectibleAttributes($product, Request $request)
    {
        $collectible = $product->collectible;
        $collectibleObj = new CollectiblesController();

        if ($collectible) {
            $collectibleObj->update($request, $product->product_id);
        } else {
            Log::warning('Collectible not found for product ID: ' . $product->product_id);
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

    //at home page new arrival section
    public function showNewArrivals()
    {
        try {
            $newArrivals = Product::where('created_at', '>=', now()->subDays(30))
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            $newArrivalsId = $newArrivals->pluck('product_id');

            return $this->fetchRatingsForProducts($newArrivalsId, $newArrivals);
        } catch (Exception $e) {
            Log::error('Fetching new arrivals failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching new arrivals failed.'], 500);
        }
    }

    //from home to shop page new arrival category
    public function newArrivals()
    {
        try {
            $newArrivals = Product::where('created_at', '>=', now()->subDays(30))
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            $newArrivalsId = $newArrivals->pluck('product_id');

            return $this->fetchRatingsForNewArrivals($newArrivalsId, $newArrivals);
        } catch (Exception $e) {
            Log::error('Fetching new arrivals failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching new arrivals failed.'], 500);
        }
    }

    private function fetchRatingsForProducts($newArrivalsId, $newArrivals)
    {
        return app('App\Http\Controllers\RatingController')->fetchRatings($newArrivalsId, $newArrivals);
    }

    private function fetchRatingsForNewArrivals($newArrivalsId, $newArrivals)
    {
        return app('App\Http\Controllers\RatingController')->fetchRatingsForNewArrival($newArrivalsId, $newArrivals);
    }

    private function fetchRatingsForShop($productsId, $products)
    {
        return app('App\Http\Controllers\RatingController')->fetchRatingsForShop($productsId, $products);
    }
}
