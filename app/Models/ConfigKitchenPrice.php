<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigKitchenPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id','qty_type','qty_weight','price'
    ];

}
