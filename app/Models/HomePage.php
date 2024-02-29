<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_1', 'section_2', 'section_3', 'section_4'
    ];

     public function type()
    {
        // $type = Type
        return $this->belongsTo('App\Models\Type','section_2','id');
    }
}
