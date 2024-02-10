<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','slug','parent_category_id','type_id','description','status','meta_title','meta_keywords','meta_description','order','image','icon','delay'
    ];

    public function type()
    {
        return $this->belongsTo('App\Models\Type');
    }

    public function parentCategory()
    {
        return $this->belongsTo('App\Models\Category');
    }
    
    public function productCategory()
    {
        return $this->hasMany('App\Models\ProductCategory');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function subCategories()
    {
        return $this->hasMany('App\Models\Category','parent_category_id','id');
    }
}
