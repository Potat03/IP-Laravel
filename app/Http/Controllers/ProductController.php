<?php

/**
 *
 * Author: Lim Weng Ni
 * Date: 20/09/2024
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Wearable;
use App\Models\Collectible;
use App\Models\Consumable;
use App\Models\Category;
use App\Models\Rating;
use App\Models\OrderItem;
use App\Models\APIkey;
use App\Contexts\ProductContext;
use App\Strategies\WearableStrategy;
use App\Strategies\CollectibleStrategy;
use App\Strategies\ConsumableStrategy;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Adapters\ProductAdapter;
use Illuminate\Support\Facades\Response;
use DOMDocument;
use XSLTProcessor;

class ProductController extends Controller
{
    //product image upload(for create product)
    public function productImageUpload(Request $request, $id)
    {
        try {
            $request->validate([
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'filesArray' => 'nullable|string',
            ]);

            $folderPath = $id ? 'storage/images/products/' . $id : 'storage/images/products/lol';

            if (!file_exists(public_path($folderPath))) {
                mkdir(public_path($folderPath), 0777, true);
            }

            $images = $request->file('images');
            if ($images) {
                $isFirstImage = true;
                $imageCounter = 1;
                foreach ($images as $index => $image) {
                    if ($isFirstImage) {
                        $imageName = 'main.' . $image->getClientOriginalExtension();
                        $isFirstImage = false;
                    } else {
                        $imageName = $imageCounter . '.' . $image->getClientOriginalExtension();
                        $imageCounter++;
                    }

                    $image->move(public_path($folderPath), $imageName);
                }
                return response()->json(['success' => true, 'data' => 'Images have been successfully uploaded.'], 200);
            }

            return response()->json(['success' => false, 'data' => 'No images were uploaded.'], 400);
        } catch (ValidationException $e) {
            Log::error('Validation failed for request', [
                'errors' => $e->errors(),
                'input' => $request->all(),
            ]);

            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => $e->getMessage()], 400);
        }
    }

    //for update product
    public function productImageUploadUpdate(Request $request, $id)
    {
        try {
            $request->validate([
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'existingImages' => 'nullable|string',
                'filesArray' => 'nullable|string',
            ]);

            $folderPath = 'storage/images/products/' . $id;
            $folderFullPath = public_path($folderPath);

            if (!file_exists($folderFullPath)) {
                mkdir($folderFullPath, 0777, true);
            }

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

            foreach ($existingImages as $image) {
                if (!in_array($image, $existingImagesFromRequest)) {
                    if ($mainImageExists && in_array($image, ['main.jpg', 'main.png', 'main.jpeg'])) {
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

                    if (!$mainImageExists) {
                        $imageName = 'main.' . $extension;
                        $newMainImage = $imageName;
                        $mainImageExists = true;
                    } else {
                        $imageName = $this->generateUniqueName($existingImages, $extension);
                    }

                    $image->move($folderFullPath, $imageName);
                    Log::info('Uploaded image: ' . $imageName);

                    $existingImages[] = $imageName;
                }

                if ($newMainImage) {
                    Log::info('Assigned new main image: ' . $newMainImage);
                }
            }

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
        } catch (ValidationException $e) {
            Log::error('Validation failed for request', [
                'errors' => $e->errors(),
                'input' => $request->all(),
            ]);

            return response()->json(['errors' => $e->errors()], 422);
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
        $categoryController = new CategoryController();
        $categories = $categoryController->index();

        return view('admin.product_add', ['categories' => $categories]);
    }

    // Add product to database
    public function createProduct(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0.01',
                'stock' => 'required|integer|min:1',
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
                'user_groups' => 'nullable|string',
                'categories' => 'required|string',
            ]);

            $product = new Product();
            $product->name = trim($request->name);
            $product->description = htmlspecialchars($request->description, ENT_QUOTES, 'UTF-8');
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->status = trim($request->status);
            $product->created_at = now()->addHours(8);
            $product->save();

            if ($request->has('isWearable')) {
                $this->createWearable($product, $request);
            }

            if ($request->has('isConsumable')) {
                $this->createConsumable($product, $request);
            }

            if ($request->has('isCollectible')) {
                $this->createCollectible($product, $request);
            }

            if ($request->has('categories')) {
                $categoryNames = json_decode($request->input('categories'), true);

                // Merge the category names and product_id into the request
                $mergedRequest = $request->merge([
                    'category_names' => $categoryNames,
                    'product_id' => $product->product_id
                ]);

                // Pass the merged request to the attach method
                $productCatControl = new ProductCategoryController();
                $productCatControl->attach($mergedRequest, $product);
            }

            ProductController::productImageUpload($request, $product->product_id);

            return response()->json(['success' => true, 'message' => 'Product created successfully.'], 200);
        } catch (ValidationException $e) {
            Log::error('Validation failed for request', [
                'errors' => $e->errors(),
                'input' => $request->all(),
            ]);

            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception $e) {
            Log::error('Adding product failed: ' . $e->getMessage());

            return response()->json(['failure' => false, 'message' => $e->getMessage()], 400);
        }
    }

    protected function createWearable($product, Request $request)
    {
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

    //for customer side
    public function index(Request $request)
    {
        try {
            $query = $request->input('search');
            $categoryNames = $request->input('categories', []);

            $productQuery = Product::query();

            if ($query) {
                $productQuery->where('name', 'LIKE', "%$query%");
            }

            if (!empty($categoryNames)) {
                $productQuery->whereIn('product_id', function ($subQuery) use ($categoryNames) {
                    $subQuery->select('product_id')
                        ->from('product_category')
                        ->whereIn('category_name', $categoryNames)
                        ->groupBy('product_id')
                        ->havingRaw('COUNT(DISTINCT category_name) = ?', [count($categoryNames)]);
                });
            }

            $products = $productQuery->paginate(20);

            $productIds = $products->items();
            $productIds = collect($productIds)->pluck('product_id')->toArray();

            $productController = new ProductController();
            $mainImages = $productController->getMainImages($productIds);

            $ratingController = new RatingController();
            $productsWithRatings = $ratingController->fetchRatingsForShop($productIds, $products);

            $categories = Category::all();

            // use AJAX request return for searching
            if ($request->ajax()) {
                return view('shop.partials.product-list', [
                    'products' => $productsWithRatings,
                    'mainImages' => $mainImages,
                    'categories' => $categories,
                ]);
            }

            // return the main view (if not AJAX)
            return view('shop', [
                'products' => $productsWithRatings,
                'mainImages' => $mainImages,
                'categories' => $categories,
            ]);
        } catch (Exception $e) {
            Log::error('Fetching products failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching products failed.'], 500);
        }
    }

    //admin side
    public function getAll(Request $request)
    {
        try {
            $productQuery = Product::query();

            $query = $request->input('search');

            if ($query) {
                $productQuery->where('name', 'LIKE', "%$query%");
            }

            $products = $productQuery->get();

            $categoryController = new CategoryController();
            $categories = $categoryController->index();

            // use AJAX request return for searching
            if ($request->ajax()) {
                return view('admin.partials.data-holder', [
                    'products' => $products,
                ]);
            }

            return view('admin.product', ['products' => $products, 'categories' => $categories]);
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
            $images[] = Storage::url($file);
        }

        return response()->json(['success' => true, 'data' => $images], 200);
    }

    public function getMainImages($ids)
    {
        $images = [];
        foreach ($ids as $id) {
            $imageFiles = Storage::files('public/images/products/' . $id);

            $mainImage = null;

            foreach ($imageFiles as $file) {
                $filename = basename($file);

                if (strpos($filename, 'main') !== false && preg_match('/\.(jpg|jpeg|png)$/i', $filename)) {
                    $mainImage = Storage::url($file);
                    break;
                }
            }

            if (!$mainImage) {
                $mainImage = Storage::url('public/images/products/default.jpg'); // Ensure default image exists
            }

            $images[$id] = $mainImage;
        }

        return $images;
    }

    // Read a single product
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);

            $ratings = Rating::where('product_id', $id)
                ->where('status', 'approved')
                ->get();

            $averageRating = $ratings->avg('star_rating') ?? 0;
            $reviewsCount = $ratings->count();

            $imageFiles = Storage::files('public/images/products/' . $id);
            $images = array_map(function ($file) {
                return Storage::url($file);
            }, $imageFiles);

            $mainImageExtension = $this->getMainImageExtension($id);

            return view('product', [
                'product' => $product,
                'averageRating' => $averageRating,
                'reviewsCount' => $reviewsCount,
                'images' => $images,
                'mainImageExtension' => $mainImageExtension,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->view('errors.404', [], 404);
        } catch (Exception $e) {
            Log::error('Fetching product failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching product failed.'], 500);
        }
    }

    //Show product images
    // public function showProductImages($id)
    // {
    //     $product = Product::find($id);

    //     $mainImageExtension = $this->getMainImageExtension($id);

    //     // Get all images for this product from the storage directory
    //     $imageFiles = Storage::files('public/images/products/' . $id);
    //     $images = array_map(function ($file) {
    //         return basename($file);
    //     }, $imageFiles);

    //     return view('product', compact('product', 'images', 'mainImageExtension'));
    // }

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
        $folderPath = 'public/images/products/' . $productId;
        $extensions = ['jpg', 'jpeg', 'png'];

        foreach ($extensions as $extension) {
            $mainImage = 'main.' . $extension;
            if (Storage::exists($folderPath . '/' . $mainImage)) {
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
                'description' => 'required|string',
                'price' => 'required|numeric|min:0.01',
                'stock' => 'required|integer|min:1',
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

            $validatedData['name'] = trim($validatedData['name']);
            $validatedData['description'] = trim($validatedData['description']);
            $validatedData['description'] = htmlspecialchars($validatedData['description'], ENT_QUOTES, 'UTF-8');

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
        } catch (ValidationException $e) {
            // Log validation errors
            Log::error('Validation failed for request', [
                'errors' => $e->errors(),
                'input' => $request->all(),
            ]);

            // Return validation error response
            return response()->json(['errors' => $e->errors()], 422);
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

    // // Delete a product
    // public function deleteProduct($id)
    // {
    //     try {
    //         $product = Product::findOrFail($id);

    //         // Fetch the folder path for the product images
    //         $folderFullPath = public_path('storage/images/products/' . $id);

    //         // Check if the folder exists
    //         if (file_exists($folderFullPath) && is_dir($folderFullPath)) {
    //             $this->deleteDirectory($folderFullPath);
    //         }

    //         $product->delete();

    //         return response()->json(null, 204);
    //     } catch (ModelNotFoundException $e) {
    //         return response()->json(['error' => 'Product not found.'], 404);
    //     }
    // }

    // private function deleteDirectory($dir)
    // {
    //     if (!file_exists($dir) || !is_dir($dir)) {
    //         return;
    //     }

    //     $items = array_diff(scandir($dir), ['.', '..']);

    //     foreach ($items as $item) {
    //         $path = $dir . '/' . $item;
    //         if (is_dir($path)) {
    //             $this->deleteDirectory($path);
    //         } else {
    //             unlink($path);
    //         }
    //     }

    //     rmdir($dir);
    // }

    //at home page new arrival section
    public function showNewArrivals()
    {
        try {
            $newArrivals = Product::where('created_at', '>=', now()->subDays(30))
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            $newArrivalsIds = $newArrivals->pluck('product_id')->toArray();

            $mainImages = $this->getMainImages($newArrivalsIds);

            $ratingcontroller = new RatingController();

            $groupedRatings = $ratingcontroller->fetchRatings($newArrivalsIds);

            $data = $newArrivals->map(function ($product) use ($mainImages, $groupedRatings) {
                $productId = (int) $product->product_id;
                $productRatings = $groupedRatings[$productId] ?? [];

                $averageRating = collect($productRatings)->avg('star_rating') ?? 0;
                $reviewsCount = count($productRatings);

                return [
                    'product' => $product,
                    'mainImage' => $mainImages[$productId] ?? '',
                    'averageRating' => $averageRating,
                    'reviewsCount' => $reviewsCount,
                ];
            });

            return view('home', ['newArrivals' => $data]); // Pass data to the view
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
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            $newArrivalsIds = $newArrivals->pluck('product_id')->toArray();

            $mainImages = $this->getMainImages($newArrivalsIds);

            $ratingController = new RatingController();

            $groupedRatings = $ratingController->fetchRatings($newArrivalsIds);

            $data = $newArrivals->getCollection()->map(function ($product) use ($mainImages, $groupedRatings) {
                $productId = (int) $product->product_id;
                $productRatings = $groupedRatings[$productId] ?? [];

                $averageRating = collect($productRatings)->avg('star_rating') ?? 0;
                $reviewsCount = count($productRatings);

                return [
                    'product' => $product,
                    'mainImage' => $mainImages[$productId] ?? '', // Fallback image
                    'averageRating' => $averageRating,
                    'reviewsCount' => $reviewsCount,
                ];
            });

            $newArrivals->setCollection($data);

            return view('shop.new-arrivals', ['newArrivals' => $newArrivals]);
        } catch (Exception $e) {
            Log::error('Fetching new arrivals failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching new arrivals failed.'], 500);
        }
    }

    public function generateProductReport()
    {
        $products = Product::all();

        $totalValue = Product::sum(DB::raw('price * stock'));

        $cogs = OrderItem::select(DB::raw('SUM(order_items.quantity * product.price) as total'))
            ->join('product', 'order_items.product_id', '=', 'product.product_id')
            ->whereMonth('order_items.created_at', '=', date('m'))
            ->value('total');

        $averageInventory = Product::avg('stock');
        $inventoryTurnoverRate = $averageInventory ? $cogs / $averageInventory : 0;

        $monthlySales = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereMonth('created_at', '=', date('m'))
            ->groupBy('product_id')
            ->pluck('total_sold', 'product_id');

        $averageMonthlySales = OrderItem::select('product_id', DB::raw('AVG(quantity) as average_sold'))
            ->groupBy('product_id')
            ->pluck('average_sold', 'product_id');

        $reorderRecommendations = [];
        $leadTimeMonths = 3;

        foreach ($products as $product) {
            $averageSold = $averageMonthlySales[$product->product_id] ?? 0;
            $currentStock = $product->stock;

            if ($averageSold > 0) {
                $recommendedQuantity = ($averageSold * $leadTimeMonths) - $currentStock;
                if ($recommendedQuantity > 0) {
                    $reorderRecommendations[$product->product_id] = $recommendedQuantity;
                }
            }
        }

        $xmlContent = $this->generateXMLContentForBasicProductInfo($products, $monthlySales, $totalValue, $inventoryTurnoverRate, $reorderRecommendations);

        $xslt = new \DOMDocument();
        $xslt->load(storage_path('app/xslt/product_report.xslt'));

        $xml = new \DOMDocument();
        $xml->loadXML($xmlContent);

        $proc = new \XSLTProcessor();
        $proc->importStylesheet($xslt);

        $html = $proc->transformToXML($xml);

        return view('admin.product_report', [
            'html' => $html,
            'products' => $products,
            'totalValue' => $totalValue,
            'inventoryTurnoverRate' => $inventoryTurnoverRate,
        ]);
    }

    private function generateXMLContentForBasicProductInfo($products, $monthlySales, $totalValue, $inventoryTurnoverRate, $reorderRecommendations)
    {
        $xml = new \SimpleXMLElement('<report/>');

        $xml->addChild('total_value', $totalValue);
        $xml->addChild('inventory_turnover_rate', $inventoryTurnoverRate);

        $productsNode = $xml->addChild('products');
        foreach ($products as $product) {
            $productNode = $productsNode->addChild('product');
            $productNode->addChild('id', $product->product_id);
            $productNode->addChild('name', $product->name);
            $type = $product->getProductType();
            $productNode->addChild('type', $type);
            $productNode->addChild('price', $product->price);
            $productNode->addChild('stock', $product->stock);
            $productNode->addChild('status', $product->status);

            $totalSold = $monthlySales[$product->product_id] ?? 0;
            $productNode->addChild('total_sold', $totalSold);

            $recommendedQuantity = $reorderRecommendations[$product->product_id] ?? 0;
            $productNode->addChild('restock_recommendation', $recommendedQuantity);
        }

        return $xml->asXML();
    }

    //python api
    // public function getAllProducts(Request $request)
    // {
    //     try {
    //         $api = APIKEY::where('api_key', $request->api_key)->first();

    //         if (!$api) {
    //             return response()->json(['success' => false, 'message' => 'invalid request'], 400);
    //         }

    //         $products = Product::all();

    //         $categoryController = new CategoryController();
    //         $categories = $categoryController->index();

    //         return response()->json([
    //             'success' => true,
    //             'data' => [
    //                 'products' => $products,
    //                 'categories' => $categories
    //             ]
    //         ], 200);
    //     } catch (Exception $e) {
    //         return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
    //     }
    // }

    public function monthlyProductReport(Request $request)
    {
        try {
            $api = APIKEY::where('api_key', $request->api_key)->first();

            if (!$api) {
                return response()->json(['success' => false, 'message' => 'invalid request'], 400);
            }

            $products = Product::all();

            $totalValue = Product::sum(DB::raw('price * stock'));

            $cogs = OrderItem::select(DB::raw('SUM(order_items.quantity * product.price) as total'))
                ->join('product', 'order_items.product_id', '=', 'product.product_id')
                ->whereMonth('order_items.created_at', '=', date('m'))
                ->value('total');

            $averageInventory = Product::avg('stock');
            $inventoryTurnoverRate = $averageInventory ? $cogs / $averageInventory : 0;

            $monthlySales = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
                ->whereMonth('created_at', '=', date('m'))
                ->groupBy('product_id')
                ->pluck('total_sold', 'product_id');

            $averageMonthlySales = OrderItem::select('product_id', DB::raw('AVG(quantity) as average_sold'))
                ->groupBy('product_id')
                ->pluck('average_sold', 'product_id');

            $reorderRecommendations = [];
            $leadTimeMonths = 3;

            foreach ($products as $product) {
                $averageSold = $averageMonthlySales[$product->product_id] ?? 0;
                $currentStock = $product->stock;

                if ($averageSold > 0) {
                    $recommendedQuantity = ($averageSold * $leadTimeMonths) - $currentStock;
                    if ($recommendedQuantity > 0) {
                        $reorderRecommendations[$product->product_id] = $recommendedQuantity;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'products' => $products,
                    'totalValue' => $totalValue,
                    'inventoryTurnoverRate' => $inventoryTurnoverRate,
                    'reorderRecommendations' => $reorderRecommendations,
                    'monthlySales' => $monthlySales
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function restock(Request $request)
    {
        try {
            $apiKey = $request->header('Authorization');

            if (strpos($apiKey, 'Bearer ') === 0) {
                $apiKey = substr($apiKey, 7);
            }

            $api = APIKEY::where('api_key', $apiKey)->first();

            if (!$api) {
                return response()->json(['success' => false, 'message' => 'Invalid API key'], 400);
            }

            $request->validate([
                'productId' => 'required|integer|exists:product,product_id',
                'quantity' => 'required|integer|min:1',
            ]);

            $productId = $request->input('productId');
            $quantity = $request->input('quantity');
            $product = Product::find($productId);

            if ($product) {
                $product->stock += $quantity;
                $product->save();

                return response()->json(['success' => true, 'message' => 'Product restocked successfully.']);
            }

            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
