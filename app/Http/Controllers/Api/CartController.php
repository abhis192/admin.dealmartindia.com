<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\Cart;
use App\Models\User;
use App\Models\City;
use App\Models\ConfigShipping;
use Hash;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    //for authenticated users
    //cartitem for auth user
    public function cart(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $uid = $user->id;
        }
            $cart = Cart::whereUserId($uid)->with('product','product.type','product.categories','product.categories','product.prices')->get();
            if($cart->count()>0){
                $data['cart'] = $cart;
                $response = [
                    'success' => true,
                    'message' => 'Cart list',
                    'data' => $data,
                ];
                return response()->json($response,200);
        } else {
            $response = [
                'success' => true,
                'message' => 'Cart empty',
                'data' => '',
            ];
            return response()->json($response,200);
        }
    }

    //add cartitem for auth user
    public function addcart(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $uid = $user->id;
        }
        if (auth()->check()) {
            // Authenticated user logic
            {
                $chkCart = Cart::where(['user_id' => $uid, 'product_id' => $request->product_id,'qty_weight'=>$request->qty_weight])->first();
                if ($chkCart) {
                    $chkCart->update(['qty'=>$chkCart->qty + 1]);
                    $response = [
                        'success' => true,
                        'message' => 'Quantity added successfully',
                        'data' => '',
                    ];
                    return response()->json($response,200);
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
                   $response = [
                    'success' => true,
                    'message' => 'Product Added in Cart Successfully',
                    'data' => '',
                ];
                return response()->json($response,200);
            }
            // return $this->addcartAuthenticated($request);
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
                // return response()->json([
                //     'message'=>'',
                //     'status'=>0
                // ], 404 );
                $response = [
                    'success' => true,
                    'message' => 'cart empty',
                    'data' => '',
                ];
                return response()->json($response,200);
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
                    // return response()->json([
                    //     'message'=>'',
                    //     'status'=>0,
                    //     'error_msg'=>$err->getMessage(),
                    // ], 500 );
                    $response = [
                        'success' => true,
                        'message' => 'Internal Server Error',
                        'data' => '',
                    ];
                    return response()->json($response,200);

                }else{
                    // return response()->json([
                    //     'message'=>'',
                    //     'status'=>1
                    // ], 200 );
                    $response = [
                        'success' => true,
                        'message' => 'Cart Updated Successfully',
                        'data' => '',
                    ];
                    return response()->json($response,200);
                }
            }
        }
    }

    //delete cart for auth user --check first
    public function destroycart(string $id)
    {
        //
        if (auth()->check()){
            $carts=Cart::find($id);
            if(is_null($carts)){
                // $response=[
                //     'message'=>'',
                //     'status'=>0
                // ];
                // $respCode=404;
                $response = [
                    'success' => true,
                    'message' => 'cart does not exists',
                    'data' => '',
                ];
                return response()->json($response,200);
            }else{
                DB::beginTransaction();
                try{
                $carts->delete();
                DB::Commit();
                // $response=[
                //     'message'=>'',
                //     'status'=>1
                // ];
                // $respCode=200;
                $response = [
                    'success' => true,
                    'message' => 'cart deleted successfully',
                    'data' => '',
                ];
                return response()->json($response,200);

                }catch(\Exception $err){
                    DB::rollBack();
                    // $response=[
                    //     'message'=>'',
                    //     'status'=>0
                    // ];
                    // $respCode=500;
                    $response = [
                        'success' => true,
                        'message' => 'Internal Serve Error',
                        'data' => '',
                    ];
                    return response()->json($response,200);
                }
            }
            // return response()->json($response,$respCode);
        }
    }

    //cartitems for auth user
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
                // $heart_shape = 0;
                // $eggless = 0;
                $grand_total = 0;
                // $cal_dicount_value=0;
                foreach ($cart as $key=> $item) {

                    if($item->discount_type=='Percentage'){
                        $cal_discount_value=((($item->discount_value)/100)*($item->regular_price));
                    }else{
                        $cal_discount_value= $item->discount_value;
                    }

                    $subtotal = $subtotal + ($item->sale_price)*($item->qty);
                    $totalbag = $totalbag + ($item->regular_price)*($item->qty);
                    // $totalbag = $totalbag + ($item->regular_price)*($item->qty) + ($cal_discount_value)*($item->qty);
                    $offer_discount = $offer_discount + ($cal_discount_value)*($item->qty);

                    // $coupon_discount = $coupon_discount + ($item->coupon_discount)*($item->qty);
                    // $heart_shape = $heart_shape + ($item->heart_shape)*($item->qty);
                    // $eggless = $eggless + ($item->eggless)*($item->qty);

                    if(!empty($item['product_id'])){
                    $item['product_name']=$item['product']['name'];

                    }
                }
                $cartcalculation['total_bag'] = $totalbag;
                $cartcalculation['offer_discount'] = $offer_discount;
                $cartcalculation['subtotal'] = $subtotal;
                // $order['coupon_discount'] = $coupon_discount;
                // $cartcalculation['heart_shape'] = $heart_shape;
                // $cartcalculation['eggless'] = $eggless;
                $cartcalculation['grand_total'] = round($totalbag - $offer_discount, 2);


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
                    $cal_discount_value=((($item->discount_value)/100)*($item->regular_price));
                }else{
                    $cal_discount_value= $item->discount_value;
                }

                $subtotal = $subtotal + ($item->sale_price)*($item->qty);
                $totalbag = $totalbag + ($item->regular_price)*($item->qty);
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




     //cartitems for auth user
     public function checkout(Request $request)
     {
         $user = auth()->user();
         if ($user) {
             $uid = $user->id;
         }

         if (auth()->check()) {
             // Authenticated user logic
             $cart = Cart::whereUserId($uid)->with('product','product.type','product.categories','product.categories','product.prices')->get();

             if($cart->count()>0){
                 $totalbag = 0;
                 $subtotal = 0;
                 $offer_discount = 0;
                 $coupon_discount = 0;
                 $delivery_charges = 0;
                 $grand_total = 0;
                 foreach ($cart as $key=> $item) {

                     if($item->discount_type=='Percentage'){
                         $cal_discount_value=((($item->discount_value)/100)*($item->regular_price));
                     }else{
                         $cal_discount_value= $item->discount_value;
                     }

                     $subtotal = $subtotal + ($item->sale_price)*($item->qty);
                     $totalbag = $totalbag + ($item->regular_price)*($item->qty);
                     $offer_discount = $offer_discount + ($cal_discount_value)*($item->qty);

                     $coupon_discount = $request->get('coupon_discount');
                     // $heart_shape = $heart_shape + ($item->heart_shape)*($item->qty);
                     // $eggless = $eggless + ($item->eggless)*($item->qty);

                     if(!empty($item['product_id'])){
                     $item['product_name']=$item['product']['name'];

                     $item['product']['image']='/storage/product/'.$item['product']['image'];
                     }
                 }
                 $grand_total = $totalbag - $offer_discount - $coupon_discount;

                 $config_shipping=ConfigShipping::first();
                  $min_order_to_ship =$config_shipping->min_order_to_ship;
                  $universal_ship_cost=$config_shipping->universal_ship_cost;
                 if($grand_total <= $min_order_to_ship){

                    $city_id = $request->get('city_id');
                    $city=City::whereId($city_id)->first();
                    $shipping_cost = $city->shipping_cost??null;

                    if($shipping_cost){
                        $grand_total = $grand_total + $shipping_cost;
                        $delivery_charges = $delivery_charges + $shipping_cost;

                    }else{
                        $grand_total = $grand_total + $universal_ship_cost;
                        $delivery_charges = $delivery_charges + $universal_ship_cost;
                    }
                 }


                 $cartcalculation['total_bag'] = $totalbag;
                 $cartcalculation['subtotal'] = $subtotal;
                 $cartcalculation['offer_discount'] = $offer_discount;
                 $cartcalculation['coupon_discount'] = $coupon_discount;
                 $cartcalculation['delivery_charges'] = $delivery_charges;
                 $cartcalculation['grand_total'] = round($grand_total, 2);


                 $data['checkout_calculation'] = $cartcalculation;
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
}
