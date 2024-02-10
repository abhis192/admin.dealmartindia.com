<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Pincode;
use Illuminate\Http\Request;

class AreaApiController extends Controller
{
   // show data of area table
   public function list($id=null){
    return $id?Area::find($id):Area::whereStatus(1)->get();
   }

   // show data of pincode table
   public function locations(){

    $areas = Area::whereStatus(1)->with('country','state','city','pincode')
    ->paginate(10);


    // $areas = Area::with('country','state','city','pincode')
    // ->paginate(10);

    return response()->json($areas);

   }


    // show data of pincode table
    public function location($id){

        $pincode = Pincode::wherePincode($id)->first();
        if (!$pincode) {
            return response(['message'=>'Pincode is not Available']);
        }

        if ($pincode) {
            $areas = Area::whereStatus(1)->wherePincodeId($pincode->id)
                                ->with('country','state','city','pincode')
                                ->paginate(10);
        // $areas = Area::with('country','state','city','pincode')
        // ->paginate(10);


        // $areas = Area::with('country','state','city','pincode')
        // ->paginate(10);

         return response()->json($areas);
       }
}
}
