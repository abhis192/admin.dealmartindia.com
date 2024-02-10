<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'city_id',
        'status',
        'pricing_rules',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function category()
    {
        return $this->hasMany('App\Models\Category');
    }
    // public function category()
    // {
    //     return $this->belongsTo(Category::class, 'category_id');
    // }
}
