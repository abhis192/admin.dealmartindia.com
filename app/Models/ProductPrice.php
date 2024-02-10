<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'qty_type','qty_weight','product_price','discount_type','discount_value','final_price'
    ];
}
