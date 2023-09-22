<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesProductItem extends Model
{
    use HasFactory;
    protected $fillable = [
            "product",
            "quantity",
            "unit",
            "sales_price",
            "payable"
    ];
    //Establish the relation with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    //Establish the relation with Sale.
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }
}
