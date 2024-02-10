<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id','name','value'
    ];

    public function orderItem()
    {
        return $this->belongsTo('App\Models\OrderItem');
    }
}
