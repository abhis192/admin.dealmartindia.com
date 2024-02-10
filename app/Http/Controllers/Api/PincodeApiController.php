<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pincode;
use Illuminate\Http\Request;

class PincodeApiController extends Controller
{
    // show data of pincode table
   public function list($id=null){
    return $id?Pincode::find($id):Pincode::whereStatus(1)->get();
   }

   public function check(Request $request) {

    if(Pincode::whereStatus(1)->whereName($request->get('pincode'))->count()) {
        if (Pincode::whereStatus(1)->wherePincode($request->get('pincode'))->whereCityId($request->get('city_id'))->count()) {
            $pincode = Pincode::whereStatus(1)->whereName($request->get('pincode'))->whereCityId($request->get('city_id'))->get();
            $response = [
                'success' => true,
                'data' => $pincode,
                'message' => 'Delivery available for this area'
            ];
            return response()->json($response,200);
        } else {
            $response = [
                'success' => false,
                'data' => '',
                'message' => 'Need to change your location'
            ];
            return response()->json($response,200);
        }
    } else {

        $response = [
            'success' => false,
            'data' => '',
            'message' => 'Delivery not available in your location'
        ];
        return response()->json($response,200);
    }


   }
}
