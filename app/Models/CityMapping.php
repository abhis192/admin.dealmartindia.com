<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id','delivery_option'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function deliveryOption()
    {
        return $this->belongsTo(DeliveryOption::class, 'delivery_option', 'id');
    }
}
