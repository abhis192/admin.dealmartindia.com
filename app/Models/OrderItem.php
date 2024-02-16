<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id','seller_id','product_id','product_name','qty_type','qty_weight','qty','sale_price','tax','discount_type','discount','coupon_discount','refund_status','image'
    ];

    public function orderItemAttributes()
    {
        return $this->hasMany('App\Models\OrderAttribute');
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public function seller()
    {
        return $this->hasOne('App\Models\User','id','seller_id');
    }

    public function review()
    {
        return $this->hasOne('App\Models\Review','order_item_id','id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id','id');
    }

    public function refund()
    {
        return $this->belongsTo('App\Models\Refund','id','order_item_id');
    }
}
