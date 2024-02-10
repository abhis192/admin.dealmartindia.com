<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigShipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'free_shipping_status','min_order_to_ship','universal_ship_status','universal_ship_cost','universal_shipping_days'
    ];
}
