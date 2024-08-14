<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Adapters\ProductAdapter;

class ProductController extends Controller
{
    //product image upload
    public function productImageUpload(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            
            $imageName = "main.png";

            if($request->has('id')){
                $folderPath = 'storage/images/products/' . $request->id;
            }else{
                $folderPath = 'storage/images/products/' . time();
            }
            

            if (!file_exists(public_path($folderPath))) {
                mkdir(public_path($folderPath), 0777, true);
            }

            $request->image->move(public_path($folderPath), $imageName);
    
            return response()->json(['success' => true, 'message' => 'You have successfully uploaded an image.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

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

            Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'status' => $request->status,
            ]);

            $product = new Product();

            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->status = $request->status;
            $product->save();

    
            return response()->json(['success' => true, 'message' => 'You have successfully added a product.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function generateTable()
    {
        try {
            $products = Product::all();
            $adapter = new ProductAdapter($products);
            $rows = $adapter->toRow();
            return response()->json(['success' => true, 'data' => $rows], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
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

    // Read all products
    public function index()
    {
        try {
            $products = Product::all();
            return response()->json($products);
        } catch (Exception $e) {
            // Log the error
            Log::error('Fetching products failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching products failed.'], 500);
        }
    }

    // Read a single product
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json($product);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found.'], 404);
        } catch (Exception $e) {
            // Log the error
            Log::error('Fetching product failed: ' . $e->getMessage());
            return response()->json(['error' => 'Fetching product failed.'], 500);
        }
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
        } catch (Exception $e) {
            // Log the error
            Log::error('Deleting product failed: ' . $e->getMessage());
            return response()->json(['error' => 'Deleting product failed.'], 500);
        }
    }
}
