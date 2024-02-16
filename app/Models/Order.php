<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_no','seller_id','user_id','order_address_id','delivery_id','order_status','order_mode','shipping_rate','commission_rate','coupon_id','transaction_id'
    ];

    // protected $total_discount = ['total_discount'];
    // protected $appends = ['subtotal'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function seller()
    {
        return $this->belongsTo('App\Models\User','seller_id','id');
    }

    public function OrderItems()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\OrderAddress','order_address_id','id');
    }

    public function statuses()
    {
        return $this->hasMany('App\Models\OrderStatus','order_id','id')->latest();
    }
    public function order_delivery()
    {
        return $this->hasMany('App\Models\OrderDelivery','order_id','id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\OrderStatus','order_id','id')->latest();
    }
    public function orderAddress()
    {
        return $this->belongsTo('App\Models\OrderAddress','order_address_id','id');
    }
    public function delivery()
    {
        return $this->belongsTo('App\Models\OrderDelivery','delivery_id','id');
    }


    public function userAddress()
    {
        return $this->belongsTo('App\Models\UserAddress','order_address_id','id');
    }

    public function orderDeliveryOption()
    {
        return $this->belongsTo('App\Models\OrderDelivery','delivery_id','id');
    }

    // public function getTotalDiscountAttribute() {
    //     $res = 0;
    //     $order_items = $this->hasMany('App\Models\OrderItem')->get();
    //     if ($order_items->count() > 0) {
    //         foreach ($order_items as $key => $order_item) {
    //             $res = $res + ($order_item->discount);
    //         }
    //     }
    //     return $res;
    // }

    // public function getSubtotalAttribute() {

    //     $res = 0;
    //     $order_items = $this->hasMany('App\Models\OrderItem')->get();
    //     if ($order_items->count() > 0) {
    //         foreach ($order_items as $key => $order_item) {
    //             $res = $res + ($order_item->price*$order_item->qty);
    //         }
    //     }
    //     return $res;
    // }


    // }

//     function getMinPriceAttribute($order)
// {
// 	$res = orderSubTotal($order->orderItems) - orderItemDiscount($order->orderItems) - orderItemCouponDiscount($order->orderItems) + $order->shipping_rate + orderItemsTax($order->orderItems);
// 	return asFloat($res);
// }
}
