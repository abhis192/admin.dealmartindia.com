<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id','name','value'
    ];

    public function cart()
    {
        return $this->belongsTo('App\Models\Cart');
    }
}
