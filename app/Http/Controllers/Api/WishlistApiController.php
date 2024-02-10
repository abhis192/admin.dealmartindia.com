<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Http\Request;
// use Auth;
use Illuminate\Support\Facades\DB;

class WishlistApiController extends Controller
{

    // $user = auth()->user();
    public function list() {
        $user = auth()->user()->id;
        $wishlists = Wishlist::whereUserId($user)->with('user:id,name', 'product','product.tags','product.type:id,name','product.categories.category:id,name','product.prices','product.gallery','product.reviews')
        ->paginate(10);

        // foreach ($wishlists as $key => $wishlist) {
            // $wishlists[$key]['product']['image'] = '/storage/product/' . $wishlists['product']['image'];
        // }


        return response()->json($wishlists);
    }

    //store review
    public function store(Request $request)
    {
        //
        $validator=Validator::make($request->all(),[
            // 'user_id'=>'required',
            'product_id'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }else{
            // $data=$request->all();
            $user = auth()->user();
            $data=$request->all();
            $data['user_id']=$user->id;
            DB::beginTransaction();
            try{
             Wishlist::create($data);
             $response=[
                'message'=>'wishlist added successfully',
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
            return response()->json($response,$respCode);
        }
    }

    public function destroy(string $id)
    {
        //
        $wishlists=Wishlist::find($id);
        if(is_null($wishlists)){
            $response=[
                'message'=>'wishlist does not exists',
                'status'=>0
            ];
            $respCode=404;
        }else{
            DB::beginTransaction();
            try{
               $wishlists->delete();
               DB::Commit();
               $response=[
                'message'=>'wishlist deleted successfully',
                'status'=>1
               ];
               $respCode=200;
            }catch(\Exception $err){
                DB::rollBack();
                $response=[
                    'message'=>'Internal Serve Error',
                    'status'=>0
                   ];
                   $respCode=500;
            }
        }
        return response()->json($response,$respCode);
    }

    public function wishlistMoveToCart($id) {
        $wishlist = Wishlist::findOrFail($id);
        if ($wishlist) {
            $cartCount = Cart::whereUserId($wishlist->user_id)->whereProductId($wishlist->product_id)->count();
            if ($cartCount == 0) {
                $data['user_id'] = $wishlist->user_id;
                $data['product_id'] = $wishlist->product_id;
                $data['qty'] = 1;

                Cart::create($data);
                $wishlist->delete();
            } else {
                return response()->json(['error' => 'Already added in the Cart.'], 200);
                // return redirect()->route('wishlist')->with('failure','Already added in the Cart.');
            }
        }
        // return redirect()->route('wishlist')->with('success','Moved into Cart Successfully.');
        return response()->json(['success' => 'Moved into Cart Successfully.'], 200);
    }


    public function wishlistAdd($productId){
        $user = auth()->user();
        $wishlist = Wishlist::whereUserId($user->id)->whereProductId($productId)->first();
        if (isset($wishlist)) {
            return response()->json(['error' => 'Already added in the Wishlist.'], 200);
        }
        Wishlist::create(['user_id'=>$user->id, 'product_id'=>$productId]);
        return response()->json(['success' => 'Moved into Wishlist Successfully.'], 200);
        // $wishlist = Wishlist::findOrFail($id);
        // if ($wishlist) {
        //     $cartCount = Cart::whereUserId($wishlist->user_id)->whereProductId($wishlist->product_id)->count();
        //     if ($cartCount == 0) {
        //         $data['user_id'] = $wishlist->user_id;
        //         $data['product_id'] = $wishlist->product_id;
        //         $data['qty'] = 1;

        //         Cart::create($data);
        //         $wishlist->delete();
        //     } else {
        //         return response()->json(['error' => 'Already added in the Cart.'], 200);
        //         // return redirect()->route('wishlist')->with('failure','Already added in the Cart.');
        //     }
        // }
        // // return redirect()->route('wishlist')->with('success','Moved into Cart Successfully.');
        // return response()->json(['success' => 'Moved into Cart Successfully.'], 200);
    }


}
