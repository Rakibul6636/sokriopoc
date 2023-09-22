<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProduct extends Model
{
    use HasFactory;
    protected $fillable = ['stock_id','product_name', 'sku', 'quantity'];
    //Establish the relation with Stock
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    //Establish the relation with Product.
    public function product()
    {
        return $this->belongsTo(Product::class, 'sku', 'sku');
    }
}
