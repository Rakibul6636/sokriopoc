<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Stock;
use App\Models\Department;
use App\Models\Product;
use App\Models\StockProduct;

class StockController extends Controller
{
    public function showStock(){
        $departments = Department::all();
        $products = Product::all();
        return view('addStock', ['departments' => $departments,'products'=>$products]);
    }
    public function create(Request $request)
    {
        // Validate the request
        $request->validate([
            'department_id' => 'required|string|max:255',
            'challan_no' => 'required|string|max:255',
            'products.*.productName' => 'required|string|max:255',
            'products.*.sku' => 'required|string|max:255',
            'products.*.quantity' => 'required|integer',
        ]);
    
        try {
            // Create a new stock entry
            $stock = Stock::create([
                'department_id' => $request->input('department_id'),
                'challan_no' => $request->input('challan_no'),
            ]);
            
            // Create stock product entries
            foreach ($request->input('products') as $product) {
                StockProduct::create([
                    'stock_id' => $stock->id,
                    'product_name' => $product['productName'],
                    'sku' => $product['sku'],
                    'quantity' => $product['quantity'],
                ]);
            }
    
            return response()->json(['message' => 'Stock entry created successfully', 'stock' => $stock], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create stock entry', 'error' => $e->getMessage()], 500);
        }
    }
    
}
