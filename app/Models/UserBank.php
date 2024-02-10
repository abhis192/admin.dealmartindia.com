<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','holders_name','account_no','bank_name','ifsc_code','branch_name'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
