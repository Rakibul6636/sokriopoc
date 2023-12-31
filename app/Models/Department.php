<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    //Establish the relation with stocks.
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
