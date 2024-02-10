<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Cart;
use Auth;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','product_id','qty','qty_type','qty_weight','eggless','heart_shape','photo_cake','msg_cake','cake_flavour','product_price','discount_type','discount_value','final_price'
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product','product_id','id');
    }

    public function cartAttributes()
    {
        return $this->hasMany('App\Models\CartAttribute');
    }

    public static function cartItems() {
        if (Auth::user()) {
            $cartItems = Cart::whereUserId(Auth::user()->id)->get();
        } else {
            $cartItems = Cart::whereUserId(session()->getId())->get();
        }
        return $cartItems;
    }

    public static function cartAmount($userId) {
        $cartItems = Cart::whereUserId($userId)->get();

        $finalAmt = 0;
        foreach ($cartItems as $key => $item) {
            $finalAmt = $finalAmt + ($item->qty * $item->final_price);
        }

        return $finalAmt;
    }

    public static function removeDuplicateItems($userId) {
        $cartItems = Cart::whereUserId($userId)->latest()->get();
        foreach ($cartItems as $key => $item) {
            $repeatingCartItems = Cart::whereUserId($userId)->whereProductId($item->product_id)->latest()->get();
            foreach ($repeatingCartItems as $key => $repeatingCartItem) {
                if ($key != 0) {
                    $repeatingCartItem->delete();
                }
            }
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
