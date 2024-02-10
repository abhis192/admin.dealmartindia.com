<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_date','delivery_type','delivery_time'
    ];

    public function deliveryoption()
    {
        return $this->belongsTo('App\Models\DeliveryOption');
    }

    public function slot()
    {
        return $this->belongsTo('App\Models\Slot');
    }

    public function delivery()
    {
        return $this->belongsTo('App\Models\OrderDelivery','delivery_id','id');
    }
}
