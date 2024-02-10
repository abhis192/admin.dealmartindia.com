<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'option_name','delivery_charge','time_slot_inside','description','status','cod'
    ];

    public function slot()
    {
        return $this->belongsTo('App\Models\Slot');
    }
}
