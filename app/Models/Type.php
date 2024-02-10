<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug','description','order','image','icon','meta_title','meta_keywords','meta_description','status'
    ];

    public function categories()
    {
        return $this->hasMany('App\Models\Category');
    }

    public function homepages()
    {
        return $this->hasMany('App\Models\HomePage');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
