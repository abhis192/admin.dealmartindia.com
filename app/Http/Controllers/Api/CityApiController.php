<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityApiController extends Controller
{
     // show data of city table
   public function list($id=null){
    $city=City::whereStatus(1)->get();
    if($city->count()>0){
    $data['cities'] = $city;

    $response = [
        'success' => true,
        'message' => 'City list',
        'data' => $data,
    ];
    return response()->json($response,200);
    }
    else{
    $response = [
        'success' => true,
        'message' => 'City empty',
        'data' => '',
    ];
    return response()->json($response,200);
    }
   }
}
