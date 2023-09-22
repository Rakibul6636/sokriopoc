<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'sku',
        'product_brand',
        'product_category',
        'description',
        'usp',
    ];
    //Establish the relation with StockProduct
    public function stockProduct()
    {
        return $this->hasMany(StockProduct::class, 'sku', 'sku');
    }
    //Establish the relation with SaleProductItem
    public function saleProductItems()
    {
        return $this->hasMany(SaleProductItem::class);
    }
}
