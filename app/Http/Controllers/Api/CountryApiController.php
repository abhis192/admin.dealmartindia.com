<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryApiController extends Controller
{
    // show data of country table
   public function list($id=null){
   return $id?Country::find($id):Country::whereStatus(1)->get();
}
}
