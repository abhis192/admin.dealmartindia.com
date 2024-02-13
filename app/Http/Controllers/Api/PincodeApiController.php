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
        if (Pincode::whereStatus(1)->whereName($request->get('pincode'))->whereCityId($request->get('city_id'))->count()) {
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

     // show data of pincode table
     public function location($id){

     $resp = Pincode::where('status', 1)->whereName($id)
     ->with(['city' => function ($query) {
        $query->where('status', 1)
            ->with('state');
     }])
     ->get();

     if($resp->count()>0){
        $data['location'] = $resp;

        $response = [
            'message' => 'location',
            'success' => true,
            'data' => $data,
        ];

        return response()->json($response,200);
     }else{
        $response = [
            'message' => 'not available',
            'success' => false,
            'data' => '',
        ];

        return response()->json($response,200);
    }
}
}
