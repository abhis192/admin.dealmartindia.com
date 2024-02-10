<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','code','use','type','product_based','category_id','product_id','discount','min_price','max_price','start_date','end_date','status'
    ];
}
