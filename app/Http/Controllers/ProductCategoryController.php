<?php
/**
 *
 * Author: Lim Weng Ni
 * Date: 20/09/2024
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Log;

class ProductCategoryController extends Controller
{
    public function attach(Request $request, Product $product)
    {
        // Validate the category names and product ID
        $request->validate([
            'category_names' => 'required|array',
            'category_names.*' => 'string|max:255',
            'product_id' => 'required|integer',
        ]);

        // Retrieve the category names from the request
        $categoryNames = $request->input('category_names');

        // Process each category name
        foreach ($categoryNames as $name) {
            ProductCategory::create([
                'product_id' => $product->product_id,
                'category_name' => $name,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Product categories created successfully.'], 200);
    }

    // // Detach categories from a product
    // public function detach(Request $request, Product $product)
    // {
    //     $request->validate([
    //         'category_ids' => 'required|array',
    //         'category_ids.*' => 'exists:categories,id',
    //     ]);

    //     $product->categories()->detach($request->input('category_ids'));

    //     return redirect()->route('products.show', $product->id)->with('success', 'Categories removed successfully.');
    // }
}
