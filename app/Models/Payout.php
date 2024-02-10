<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice','user_id','total_amt','status','payment_mode','description'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
