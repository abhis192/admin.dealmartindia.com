<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigPayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'payout_status','payout_calculation_date'
    ];
}
