<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'label','user_id','default','name','email','mobile','state','country','city','pincode','address','landmark','area'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
