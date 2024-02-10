<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\Cart;
use App\Models\User;
use Hash;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    //for guest user

    //cart item for guest
    public function cartGuest(Request $request) {
        $sessionId = $request->input('session_id', null);

        if (!$sessionId) {
            $sessionId = session()->getId();
        }

        $cart = Cart::whereUserId($sessionId)->with('product','product.type','product.categories','product.categories','product.prices')->get();
        return response()->json([
            'message' => 'Guest user cart list',
            'session_id' => $sessionId,
            'cart' => $cart
        ]);
    }

    //add cart for guest
    public function addcartGuest(Request $request) {
        $sessionId = $request->input('session_id', null);

        if (!$sessionId) {
            $sessionId = session()->getId();
        }

        $chkCart = Cart::where(['user_id' => $sessionId, 'product_id' => $request->product_id,'qty_weight'=>$request->qty_weight])->first();
        if($chkCart) {
            $chkCart->update(['qty'=>$chkCart->qty + 1]);
            return response()->json(['success' => true, 'message' => 'Quantity added successfully']);

        }
        $data=$request->all();
        $data['user_id']=$sessionId;

        if($request->hasFile('photo_cake')){
            $fileImage = $request->file('photo_cake');
            $fileImageName = rand() . '.' . $fileImage->getClientOriginalName();
            $fileImage->storeAs('public/product/',$fileImageName);
            $data['photo_cake'] = $fileImageName;
        }

        Cart::create($data);
        return response()->json(['message' => 'Guest user cartitem added', 'session_id' => $sessionId]);
    }

    //update cartitem for guest
    public function updatecartGuest(Request $request, $id) {
        // Check if the user sends a session_id in the request
        // $sessionId = $request->input('session_id', null);

        // if (!$sessionId) {
        //     // If no session_id provided, create a new session
        //     $sessionId = session()->getId();
        // }
             $carts=Cart::find($id);
             if(is_null($carts)){
                return response()->json([
                    'message'=>'cart empty',
                    'status'=>0
                ],
                404
            );
        }else{
            DB::beginTransaction();
            try{
                // $useraddress=$request->all();
            //   $carts->user_id=$uid;
            //   $carts->product_id=$request['product_id'];
              $carts->qty=$request['qty'];
            //   $carts->qty_type=$request['qty_type'];
            //   $carts->qty_weight=$request['qty_weight'];
            //   $carts->eggless=$request['eggless'];
            //   $carts->heart_shape=$request['heart_shape'];
            //   $carts->photo_cake=$request['photo_cake'];
            //   $carts->msg_cake=$request['msg_cake'];
              $carts->save();

                DB::commit();
            }catch(\Exception $err){
                DB::rollBack();
                $carts=null;
            }
        }

        return response()->json(['message' => 'Guest user  cart item updated', 'cart_id' => $id]);
    }

    //delete cart item for guest
    public function destroyCartGuest(Request $request, $id) {
        // Check if the user sends a session_id in the request
        $sessionId = $request->input('session_id', null);

        if (!$sessionId) {
            // If no session_id provided, create a new session
            $sessionId = session()->getId();
        }

        $carts=Cart::find($id);
        if(is_null($carts)){
            $response=[
                'message'=>'cart does not exists',
                'status'=>0
            ];
            $respCode=404;
        }else{
            DB::beginTransaction();
            try{
               $carts->delete();
               DB::Commit();
               $response=[
                'message'=>'cart deleted successfully',
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
        // return response()->json($response,$respCode);

        // Implement your logic to update the cart item with $id based on $sessionId
        // For example, you might want to update the cart item in a database

        return response()->json(['message' => 'Guest user cart item deleted', 'session_id' => $sessionId, 'cart_id' => $id]);
    }



    //for authenticated users

    //cartitem for auth user
    public function cart(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $uid = $user->id;
        } else {
            $uid = session()->getId();
        }

        if (auth()->check()) {
            // Authenticated user logic
            $cart = Cart::whereUserId($uid)->with('product','product.type','product.categories','product.categories','product.prices')->get();
            return response()->json($cart);
            // return $this->cartAuthenticated($request);
        } else {
            // Guest user logic
            $cart = Cart::whereUserId($uid)->with('product','product.type','product.categories','product.categories','product.prices')->get();
            return response()->json($cart);
            // return $this->cartGuest($request);
        }
    }

    //add cartitem for auth user
    public function addcart(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $uid = $user->id;
        } else {
            $uid = session()->getId();
        }

        if (auth()->check()) {
            // Authenticated user logic
            {
                $chkCart = Cart::where(['user_id' => $uid, 'product_id' => $request->product_id,'qty_weight'=>$request->qty_weight])->first();
                if ($chkCart) {
                    $chkCart->update(['qty'=>$chkCart->qty + 1]);
                    return response()->json(['success' => true, 'message' => 'Quantity added successfully']);
                }
               $data=$request->all();

               $data['user_id']=$uid;

               if($request->hasFile('photo_cake')){
                $fileImage = $request->file('photo_cake');
                $fileImageName = rand() . '.' . $fileImage->getClientOriginalName();
                $fileImage->storeAs('public/product/',$fileImageName);
                $data['photo_cake'] = $fileImageName;
            }
               Cart::create($data);

               return response()->json([
                            'message'=>'Product Added in Cart Successfully',
                            'status'=>1
                       ],
                       200
                   );
            }
            // return $this->addcartAuthenticated($request);
        } else {
            // Guest user logic
            $sessionId = session()->getId();
             # Check Already Exist Aur Not
             $chkCart = Cart::where(['user_id' => $sessionId, 'product_id' => $request->product_id])->first();
             if ($chkCart) {
                 return response()->json(['success' => true, 'message' => 'Remove from cart if the item is already added']);
             }
            $data=$request->all();
            $data['user_id']=$uid;
            Cart::create($data);

            return response()->json([
                         'message'=>'Product Added in Cart Successfully',
                         'status'=>1
                    ],
                    200
                );
        //  }

            // return $this->addcartGuest($request);
        }
    }

    //update cart for auth user --check first
    public function updatecart(Request $request, string $id)
    {
        $user = Auth::user();
        if ($user) {
            $uid = $user->id;
        } else {
            $uid = session()->getId();
        }

        if (auth()->check()){

            $carts=Cart::find($id);
            if(is_null($carts)){
                return response()->json([
                    'message'=>'cart empty',
                    'status'=>0
                ], 404 );
            }else{
                DB::beginTransaction();
                try{
                    // $useraddress=$request->all();
                    //   $carts->user_id=$uid;
                    //   $carts->product_id=$request['product_id'];
                    $carts->qty=$request['qty'];
                    //   $carts->qty_type=$request['qty_type'];
                    //   $carts->qty_weight=$request['qty_weight'];
                    //   $carts->eggless=$request['eggless'];
                    //   $carts->heart_shape=$request['heart_shape'];
                    //   $carts->photo_cake=$request['photo_cake'];
                    //   $carts->msg_cake=$request['msg_cake'];
                    $carts->save();

                    DB::commit();
                }catch(\Exception $err){
                    DB::rollBack();
                    $carts=null;
                }

                if(is_null($carts)){
                    return response()->json([
                        'message'=>'Internal Server Error',
                        'status'=>0,
                        'error_msg'=>$err->getMessage(),
                    ], 500 );
                }else{
                    return response()->json([
                        'message'=>'Cart Updated Successfully',
                        'status'=>1
                    ], 200 );
                }
            }
        }

        // else
        // $sessionId = session()->getId();

        // $carts=Cart::find($id);
        // if(is_null($carts)){
        //     return response()->json([
        //         'message'=>'cart empty',
        //         'status'=>0
        //     ], 404 );
        // }else{
        //     DB::beginTransaction();
        //     try{

        //         // $useraddress=$request->all();
        //         $carts->user_id=$sessionId;
        //         $carts->product_id=$request['product_id'];
        //         $carts->qty=$request['qty'];
        //         $carts->qty_type=$request['qty_type'];
        //         $carts->qty_weight=$request['qty_weight'];
        //         $carts->eggless=$request['eggless'];
        //         $carts->heart_shape=$request['heart_shape'];
        //         $carts->photo_cake=$request['photo_cake'];
        //         $carts->msg_cake=$request['msg_cake'];

        //         $carts->save();

        //         DB::commit();
        //     }catch(\Exception $err){
        //         DB::rollBack();
        //         $carts=null;
        //     }
        //    if(is_null($carts)){
        //     return response()->json([
        //         'message'=>'Internal Server Error',
        //         'status'=>0,
        //         'error_msg'=>$err->getMessage(),
        //     ], 500 );
        //    }else{
        //         return response()->json([
        //             'message'=>'Cart Updated Successfully',
        //             'status'=>1
        //         ], 200 );
        //    }

        // }

    }

    //delete cart for auth user --check first
    public function destroycart(string $id)
    {
        //
        if (auth()->check()){
            $carts=Cart::find($id);
            if(is_null($carts)){
                $response=[
                    'message'=>'cart does not exists',
                    'status'=>0
                ];
                $respCode=404;
            }else{
                DB::beginTransaction();
                try{
                $carts->delete();
                DB::Commit();
                $response=[
                    'message'=>'cart deleted successfully',
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

        // else
        // $carts=Cart::find($id);
        // if(is_null($carts)){
        //     $response=[
        //         'message'=>'cart does not exists',
        //         'status'=>0
        //     ];
        //     $respCode=404;
        // }else{
        //     DB::beginTransaction();
        //     try{
        //     $carts->delete();
        //     DB::Commit();
        //     $response=[
        //         'message'=>'cart deleted successfully',
        //         'status'=>1
        //     ];
        //     $respCode=200;
        //     }catch(\Exception $err){
        //         DB::rollBack();
        //         $response=[
        //             'message'=>'Internal Serve Error',
        //             'status'=>0
        //         ];
        //         $respCode=500;
        //     }
        // }
        // return response()->json($response,$respCode);

    }



    // Other methods...

    // Separate methods for authenticated and guest users
    protected function cartAuthenticated(Request $request)
    {
        $userId = auth()->id();
        // Implement your logic for authenticated user's cart
        return response()->json(['message' => 'Authenticated user cart operation', 'user_id' => $userId]);
    }

    protected function addcartAuthenticated(Request $request)
    {
        $userId = auth()->id();
        // Implement your logic for authenticated user's addcart
        return response()->json(['message' => 'Authenticated user addcart operation', 'user_id' => $userId]);
    }

    // Other methods...

    // Example of another method
    public function someOtherMethod(Request $request)
    {
        if (auth()->check()) {
            // Authenticated user logic
            return $this->someOtherMethodAuthenticated($request);
        } else {
            // Guest user logic
            return $this->someOtherMethodGuest($request);
        }
    }

    protected function someOtherMethodAuthenticated(Request $request)
    {
        $userId = auth()->id();
        // Implement your logic for authenticated user's other method
        return response()->json(['message' => 'Authenticated user someOtherMethod', 'user_id' => $userId]);
    }

    protected function someOtherMethodGuest(Request $request)
    {
        $sessionId = session()->getId();
        // Implement your logic for guest user's other method
        return response()->json(['message' => 'Guest user someOtherMethod', 'session_id' => $sessionId]);
    }


    //new cartitems for auth user
    public function cartItems(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $uid = $user->id;
        }

        if (auth()->check()) {
            // Authenticated user logic
            $cart = Cart::whereUserId($uid)->with('product','product.type','product.categories','product.categories','product.prices')->get();

            if($cart->count()>0){
                $subtotal = 0;
                $totalbag = 0;
                $offer_discount = 0;
                // $coupon_discount = 0;
                $heart_shape = 0;
                $eggless = 0;
                $grand_total = 0;
                // $cal_dicount_value=0;
                foreach ($cart as $key=> $item) {

                    if($item->discount_type=='Percentage'){
                        $cal_discount_value=((($item->discount_value)/100)*($item->product_price));
                    }else{
                        $cal_discount_value= $item->discount_value;
                    }

                    $subtotal = $subtotal + ($item->final_price)*($item->qty);
                    $totalbag = $totalbag + ($item->product_price)*($item->qty);
                    // $totalbag = $totalbag + ($item->product_price)*($item->qty) + ($cal_discount_value)*($item->qty);
                    $offer_discount = $offer_discount + ($cal_discount_value)*($item->qty);

                    // $coupon_discount = $coupon_discount + ($item->coupon_discount)*($item->qty);
                    $heart_shape = $heart_shape + ($item->heart_shape)*($item->qty);
                    $eggless = $eggless + ($item->eggless)*($item->qty);

                    if(!empty($item['product_id'])){
                    $item['product_name']=$item['product']['name'];

                    }
                }
                $cartcalculation['total_bag'] = $totalbag;
                $cartcalculation['offer_discount'] = $offer_discount;
                $cartcalculation['subtotal'] = $subtotal;
                // $order['coupon_discount'] = $coupon_discount;
                $cartcalculation['heart_shape'] = $heart_shape;
                $cartcalculation['eggless'] = $eggless;
                $cartcalculation['grand_total'] = round($totalbag - $offer_discount + $heart_shape + $eggless, 2);


                $data['cart_calculation'] = $cartcalculation;
                $data['cart_items'] = $cart;

                $response = [
                    'success' => true,
                    'message' => '',
                    'data' => $data,
                ];

                return response()->json($response,200);

            }else{
                $response = [
                    'success' => false,
                    'message' => 'cart is empty',
                    'data' => '',
                ];

                return response()->json($response,200);

            }

        }
    }

    //empty cart when change city
    public function clearCart(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $uid = $user->id;
        }

        if (auth()->check()) {
            $cart = Cart::whereUserId($uid)->get();
            if($cart->count()>0){

                $cart->each->delete();

                $response = [
                    'success' => true,
                    'message' => 'All cart item has been deleted',
                ];

                return response()->json($response,200);

            }else{

                $response = [
                    'success' => false,
                    'message' => 'cart is empty',
                    'data' => '',
                ];

                return response()->json($response,200);

            }

        }
    }

     //cart item for guest
     public function cartItemsGuest(Request $request) {
        $sessionId = $request->input('session_id', null);

        if (!$sessionId) {
            $sessionId = session()->getId();
        }

        $cart = Cart::whereUserId($sessionId)->with('product','product.type','product.categories','product.categories','product.prices')->get();

        if($cart->count()>0){
            $subtotal = 0;
            $totalbag = 0;
            $offer_discount = 0;
            // $coupon_discount = 0;
            $heart_shape = 0;
            $eggless = 0;
            $grand_total = 0;

            foreach ($cart as $key=> $item) {

                if($item->discount_type=='Percentage'){
                    $cal_discount_value=((($item->discount_value)/100)*($item->product_price));
                }else{
                    $cal_discount_value= $item->discount_value;
                }

                $subtotal = $subtotal + ($item->final_price)*($item->qty);
                $totalbag = $totalbag + ($item->product_price)*($item->qty);
                $offer_discount = $offer_discount + ($cal_discount_value)*($item->qty);
                // $coupon_discount = $coupon_discount + ($item->coupon_discount)*($item->qty);
                $heart_shape = $heart_shape + ($item->heart_shape)*($item->qty);
                $eggless = $eggless + ($item->eggless)*($item->qty);

                if(!empty($item['product_id'])){
                $item['product_name']=$item['product']['name'];

                }
            }
            $cartcalculation['total_bag'] = $totalbag;
            $cartcalculation['offer_discount'] = $offer_discount;
            $cartcalculation['subtotal'] = $subtotal;
            // $order['coupon_discount'] = $coupon_discount;
            $cartcalculation['heart_shape'] = $heart_shape;
            $cartcalculation['eggless'] = $eggless;
            $cartcalculation['grand_total'] = round($totalbag - $offer_discount + $heart_shape + $eggless, 2);


            $data['cart_calculation'] = $cartcalculation;
            $data['cart_items'] = $cart;

            $response = [
                'success' => true,
                'message' => '',
                'data' => $data,
            ];

            return response()->json($response,200);

        }else{
            $response = [
                'success' => false,
                'message' => 'cart empty',
                'data' => '',
            ];

            return response()->json($response,200);

        }
    }

     //empty cart when change city
     public function clearCartGuest(Request $request)
     {
        $sessionId = $request->input('session_id', null);

        if (!$sessionId) {
            $sessionId = session()->getId();
        }

        //  if (auth()->check()) {
             $cart = Cart::whereUserId($sessionId)->get();
             if($cart->count()>0){

                 $cart->each->delete();

                 $response = [
                     'success' => true,
                     'message' => 'All cart item has been deleted',
                 ];

                 return response()->json($response,200);

             }else{

                 $response = [
                     'success' => false,
                     'message' => 'cart empty',
                     'data' => '',
                 ];

                 return response()->json($response,200);

             }

         }
    //  }
}
