<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SalesProductItem;
use App\Models\Product;


class SaleController extends Controller
{   //show the sales form
    public function showSale(){
        $products = Product::all();
        return view('addSale', ['products'=>$products]);
    }
    public function create(Request $request)
    {   //validate the data
        $request->validate([
            'total_amount' => 'required|numeric|min:0',
            'pay_amount' => 'required|numeric|min:0',
            'sales' => 'required|array|min:1',
            'sales.*.product' => 'required|string|max:255',
            'sales.*.quantity' => 'required|integer|min:1',
            'sales.*.unit' => 'required|string|max:255',
            'sales.*.sales_price' => 'required|numeric|min:0',
            'sales.*.payable' => 'required|numeric|min:0',
        ]);
        
        //create sales
        $sale = Sale::create([
            'total_amount' => $request->input('total_amount'),
            'pay_amount' => $request->input('pay_amount'),
        ]);
        //create sales product item.
        foreach ($request->input('sales') as $saleData) {
            $productItem = new SalesProductItem($saleData);
            $sale->productItems()->save($productItem);
        }

        return response()->json(['message' => 'Sales created successfully', 'sale' => $sale], 201);
    }

}
