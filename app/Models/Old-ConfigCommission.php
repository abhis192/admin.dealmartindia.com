<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_commission_status','seller_commission','min_seller_withdraw','seller_commission_day'
    ];
}
