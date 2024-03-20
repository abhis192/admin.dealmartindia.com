<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'category_id','type_id','brand_id','sku','description', 'user_id', 'meta_title', 'meta_keywords', 'meta_description','published','featured','image','shipping_days','published','featured','in_stock'
    ];

    protected $appends = ['min_price','rating','review_count'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Type');
    }
    public function tag()
    {
        return $this->belongsTo('App\Models\ProductTag');
    }

    public function getprice()
	{
		return $this->hasMany('App\Models\ProductPrice', 'product_id', 'id');
	}

    public function prices()
	{
		return $this->hasMany('App\Models\ProductPrice', 'product_id', 'id');
	}

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

    public function gallery()
    {
        return $this->hasMany('App\Models\ProductGallery');
    }

    public function galleries()
    {
        return $this->belongsTo('App\Models\ProductGallery');
    }

    public function tags()
    {
        return $this->hasMany('App\Models\ProductTag');
    }
    public function attributes()
    {
        return $this->hasMany('App\Models\ProductAttribute');
    }
    public function categories()
    {
        return $this->hasMany('App\Models\ProductCategory');
    }

    public function pincodes()
    {
        return $this->belongsToMany(Pincode::class, 'product_pincodes');
    }

    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review')->whereStatus(1);
    }

    public function pricingRule()
    {
        return $this->hasOne(PricingRule::class, 'product_id');
    }

    public function getMinPriceAttribute() {
        $minPrice = $this->prices->min('sale_price');
        return $minPrice;
    }

    public function getRatingAttribute() {
        $res = 0;
        $reviews = $this->hasMany('App\Models\Review')->whereStatus(1)->get();
        if ($reviews->count() > 0) {
            foreach ($reviews as $key => $review) {
                $res = $res + $review->stars;
            }
            $res = round($res / $reviews->count());
        }
        return $res;
    }

    public function getReviewCountAttribute() {
        // $res = 0;
        $reviews = $this->hasMany('App\Models\Review')->whereStatus(1)->get();
        return $reviews->count();
        // if ($reviews->count() > 0) {
        //     foreach ($reviews as $key => $review) {
        //         $res = $res + $review->count();
        //     }
        //     // $res = round($res / $reviews->count());
        // }
        // return $res;
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
