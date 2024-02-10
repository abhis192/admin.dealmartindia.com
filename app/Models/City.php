<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','description','state_id','status'
    ];

    public function state()
    {
        return $this->belongsTo('App\Models\State');
    }

    public function pincodes()
    {
        return $this->hasMany('App\Models\Pincode');
    }

    public function cityMapping()
    {
        return $this->belongsTo(CityMapping::class, 'city_id');
    }

    public function mappings()
    {
        return $this->hasMany('App\Models\CityMapping');
    }
}
