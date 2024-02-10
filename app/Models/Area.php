<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','pincode_id','city_id','state_id','country_id','status'
    ];

    public function pincode()
    {
        return $this->belongsTo('App\Models\Pincode');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }
    public function state()
    {
        return $this->belongsTo('App\Models\State');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_pincodes');
    }
}
