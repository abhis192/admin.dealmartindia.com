<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityApiController extends Controller
{
     // show data of city table
   public function list($id=null){
    return $id?City::find($id):City::whereStatus(1)->get();
   }
}
