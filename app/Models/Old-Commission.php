<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id','seller_id','order_total','commission_rate','admin_commission','seller_earning','payment_at'
    ];

    public function orderItem()
    {
        return $this->belongsTo('App\Models\OrderItem','order_item_id','id');
    }

    public function seller()
    {
        return $this->belongsTo('App\Models\User','seller_id','id');
    }
}
