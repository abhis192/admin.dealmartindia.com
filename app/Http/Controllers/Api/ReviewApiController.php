<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewApiController extends Controller
{

    // list of reviews
    public function list(){
    $reviews=Review::get();

    if($reviews->count()>0){
        $data['reviews'] = $reviews;

        $response = [
            'success' => true,
            'message' => 'review list',
            'data' => $data,
        ];

        return response()->json($response,200);
    }else{
    $response = [
        'success' => false,
        'message' => 'No reviews Available',
        'data' => '',
    ];

    return response()->json($response,200);
 }
}

    //store review
    public function store(Request $request)
    {
        //
        $validator=Validator::make($request->all(),[
            // 'user_id'=>'required',
            'order_item_id' => 'required',
            'product_id'=>'required',
            'content'=>'required',
            'stars'=>'required',
            'status'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }else{
            $user = auth()->user();
            $data=$request->all();
            $data['user_id'] = $user->id;
            DB::beginTransaction();
            try{
             Review::create($data);
             DB::commit();
             $response = [
                'success' => true,
                'message' => 'review added successfully',
                'data' => '',
            ];
            return response()->json($response,200);

            }catch(\Exception $e){
                DB::rollBack();
                $response = [
                'success' => false,
                'message' => 'Internal Server Error',
                'data' => '',
            ];
            return response()->json($response,200);
            }
        }
        // return response()->json($response,$respCode);
    }

    public function reviewByProductId($id) {
        $review = Review::whereStatus(1)->whereProductId($id)
            // ->with('category','products','products.tags','products.prices','products.gallery','products.user:id,name', 'products.type:id,name')
            ->get();

        // return response()->json($review);
        if($review->count()>0){

            $data['reviews'] = $review;

            $response = [
                'success' => true,
                'message' => 'review list',
                'data' => $data,
            ];

            return response()->json($response,200);
            }else{
            $response = [
                'success' => true,
                'message' => 'No review available',
                'data' => '',
            ];

            return response()->json($response,200);
        }

    }
}
