<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = ['department_id', 'challan_no'];
    //Establish the relation with StockProduct
    public function stockProducts()
    {
        return $this->hasMany(StockProduct::class);
    }
    //Establish the relation with Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
