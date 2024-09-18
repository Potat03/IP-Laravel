<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductCategory;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return $categories;
    }

    public function addCategory()
    {
        return view('admin.category_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        Category::create([
            'category_name' => $request->input('category_name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('admin.product')->with('success', 'Category added successfully.');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category_edit', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'category_name' => $request->input('category_name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('admin.product')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        ProductCategory::where('category_name', $category->category_name)->delete();

        $category->delete();

        return redirect()->route('admin.product')->with('success', 'Category deleted successfully.');
    }
}