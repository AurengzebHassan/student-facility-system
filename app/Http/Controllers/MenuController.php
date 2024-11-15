<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class MenuController extends Controller
{
    public function menu(Request $request, $categoryId = null)
    {
        $searchQuery = trim($request->input('search', ''));

        // Fetch products
        $query = Product::where('name', 'LIKE', "%$searchQuery%")
            ->where('archive', 0);

        // Fetch products based on the selected category (if any)
        if ($categoryId) {
            $query->where('category_id', $categoryId);
            $category = Category::findOrFail($categoryId);
        } else {
            $category = null;
        }
        $products = $query->paginate(12);
        $products = $query->get();

        // Fetch all categories
        $categories = Category::all();

        return view('frontend.menu', [
            'products' => $products,
            'searchQuery' => $searchQuery,
            'categories' => $categories,
            'category' => $category
        ]);
    }

//     public function showCategorymenuofproducts()
// {
//     $categories = Category::all();
//     $products = Product::where('archive', 0)->get(); // Fetch all products not archived

//     return view('frontend.category', [
//         'categories' => $categories,
//         'products' => $products
//     ]);
// }

    

// public function showCategorymenu(Category $category)
// {
//     // Retrieve all categories
//     $categories = Category::all();

//     // Retrieve products belonging to the selected category
//     $products = $category->products()->where('archive', 0)->get();

//     // Pass the category and products to the view
//     return view('frontend.category', [
//         'categories' => $categories,
//         'category' => $category,
//         'products' => $products
//     ]);
// }

public function showCategorymenu(Category $category = null, Request $request)
{
    $searchQuery = $request->input('search');

    // Retrieve all categories
    $categories = Category::all();

    // Retrieve products based on the selected category (if any) and search query
    $productsQuery = Product::where('archive', 0);
    if ($category) {
        $productsQuery->where('category_id', $category->id);
    }
    if ($searchQuery) {
        $productsQuery->where('name', 'like', '%' . $searchQuery . '%');
    }
    $products = $productsQuery->get();

    return view('frontend.category', [
        'categories' => $categories,
        'category' => $category,
        'products' => $products,
        'searchQuery' => $searchQuery
    ]);
}

    public function checkStock()
    {
        $products = Product::where('remaining_quantity', '<', 10)->get();

        return response()->json(['products' => $products]);
    }
}
