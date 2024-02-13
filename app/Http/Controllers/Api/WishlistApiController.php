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
        ->get();

        if($wishlists->count()>0){
            $data['wishlists'] = $wishlists;

            $response = [
                'success' => true,
                'message' => 'wishlist list',
                'data' => $data,
            ];

            return response()->json($response,200);
        }else{
        $response = [
            'success' => true,
            'message' => 'Wishlist empty',
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
             DB::commit();
             $response = [
                'success' => true,
                'message' => 'product added successfully',
                'data' => $data,
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
            // return response()->json($response,$respCode);
        }
    }

    public function destroy(string $id)
    {
        //
        $wishlists=Wishlist::find($id);
        if(is_null($wishlists)){
            $response = [
                'success' => false,
                'message' => 'wishlist empty',
                'data' => '',
            ];

            return response()->json($response,200);
        }else{
            DB::beginTransaction();
            try{
               $wishlists->delete();
               DB::Commit();
               $response = [
                'success' => true,
                'message' => 'wishlist deleted successfully',
                'data' => '',
            ];

            return response()->json($response,200);
            }catch(\Exception $err){
                DB::rollBack();
                $response = [
                    'success' => true,
                    'message' => 'Internal Server Error',
                    'data' => '',
                ];

                return response()->json($response,200);
            }
        }
        // return response()->json($response,$respCode);
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
        $response = [
            'success' => true,
            'message' => 'Moved into Cart Successfully',
            'data' => '',
        ];

        return response()->json($response,200);
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
