<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigGeneral extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name','site_email','email','mobile','address','facebook','instagram','twitter','linkedin','youtube','meta_title','meta_keywords','meta_description','topbar_header','logo','icon','tax'
    ];
}
