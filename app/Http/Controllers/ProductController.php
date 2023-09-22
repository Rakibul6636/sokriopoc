<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{   //show the product form
    public function showProduct(){
        return view('addProduct');
    }
    public function create(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku|max:255',
            'product_brand' => 'required|string|max:255',
            'product_category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'usp' => 'nullable|string',
        ]);

        // Create a new product
        $product = Product::create([
            'name' => $request->input('name'),
            'sku' => $request->input('sku'),
            'product_brand' => $request->input('product_brand'),
            'product_category' => $request->input('product_category'),
            'description' => $request->input('description'),
            'usp' => $request->input('usp'),
        ]);
        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }
}
