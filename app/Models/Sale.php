<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_amount',
        'pay_amount'
    ];
    //Establish relation with SalesProductItem
    public function productItems()
    {
        return $this->hasMany(SalesProductItem::class, 'sale_id', 'id');
    }
}
