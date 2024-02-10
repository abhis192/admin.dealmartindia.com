<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartAttributeValue extends Model
{
    use HasFactory;

    public function cart()
    {
        return $this->belongsTo('App\Models\Cart');
    }

    public function attribute()
    {
        return $this->hasOne('App\Models\AttributeValues','id','attribute_value_id');
    }
}
