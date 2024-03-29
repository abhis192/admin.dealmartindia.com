<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUpi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','upi_name','upi_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
