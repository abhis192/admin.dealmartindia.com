<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigRefund extends Model
{
    use HasFactory;

    protected $fillable = [
        'refund_time'
    ];
}
