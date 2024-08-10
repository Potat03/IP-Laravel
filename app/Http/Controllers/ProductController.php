<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
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
}
