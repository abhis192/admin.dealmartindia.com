<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewApiController extends Controller
{

     // show data of country table
    public function list($id=null){
    return $id?Review::find($id):Review::whereStatus(1)->get();
    }

    //store review
    public function store(Request $request)
    {
        //
        $validator=Validator::make($request->all(),[
            'user_id'=>'required',
            'order_item_id' => 'required',
            'product_id'=>'required',
            'content'=>'required',
            'stars'=>'required',
            'status'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }else{
            $data=$request->all();
            DB::beginTransaction();
            try{
             Review::create($data);
             $response=[
                'message'=>'review added successfully',
                'status'=>1
               ];
               $respCode=200;
             DB::commit();
            }catch(\Exception $e){
                DB::rollBack();
                $response=[
                    'message'=>'Internal Server Error',
                    'status'=>0
                   ];
                   $respCode=500;
            }
        }
        return response()->json($response,$respCode);
    }

    public function reviewByProductId($id) {
        $review = Review::whereStatus(1)->whereProductId($id)
            // ->with('category','products','products.tags','products.prices','products.gallery','products.user:id,name', 'products.type:id,name')
            ->paginate(10);

        return response()->json($review);
    }
}
