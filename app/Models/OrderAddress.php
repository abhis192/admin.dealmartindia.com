<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'label','default','name','email','mobile','state','country','city','pincode','address','landmark'
    ];

    public function Orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
