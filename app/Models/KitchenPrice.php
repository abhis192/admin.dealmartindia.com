<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'kitchen_id','product_id','qty_type','qty_weight','price'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','kitchen_id','id');
    }
}
