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
    // $pincode = Pincode::wherePincode($request->get('pincode'))->whereCityId($request->get('city_id'))->get();
    // return response()->json($pincode);

    // pincode
    if(Pincode::whereStatus(1)->wherePincode($request->get('pincode'))->count()) {
        if (Pincode::whereStatus(1)->wherePincode($request->get('pincode'))->whereCityId($request->get('city_id'))->count()) {
            $pincode = Pincode::whereStatus(1)->wherePincode($request->get('pincode'))->whereCityId($request->get('city_id'))->get();
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
                'message' => 'Need to change your location/area'
            ];
            return response()->json($response,200);
        }
    } else {
        // delivery not availble in this pincode

        $response = [
            'success' => false,
            'data' => '',
            'message' => 'Delivery not available in your area'
        ];
        return response()->json($response,200);
    }


   }
}
