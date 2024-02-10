<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','pincode_id'
    ];

    // public function pincodes()
    // {
    //     return $this->hasMany('App\Models\Pincode');
    // }
}
