<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\Cart;
use App\Models\User;
use Hash;
use Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function view() {
        $user=Auth()->user();
        $profile = User::whereId($user->id)->first();

        if ($profile) {
            $modifiedProfile = [
                'id' => $profile->id,
                'role_id' => $profile->role_id,
                'name' => $profile->name,
                'email' => $profile->email,
                'mobile' => $profile->mobile,
                'dob'=>$profile->dob,
                'gender'=>$profile->gender,
                'email_verified_at'=>$profile->email_verified_at,
                'seller_verified_at'=>$profile->seller_verified_at,

                'avatar' => '/storage/user/' . $profile->avatar,
                'business'=>$profile->business,
                'address'=>$profile->address,
                'gst_no'=>$profile->gst_no,
                'gst_name'=>$profile->gst_name,

                'addresses' => $profile->addresses
            ];
            // return response()->json($modifiedProfile);
            $data['user_detail'] = $modifiedProfile;

            $response = [
                'success' => true,
                'message' => 'user detail',
                'data' => $data,
            ];

            return response()->json($response,200);
        } else {
            $response = [
                'success' => false,
                'message' => 'User not found.',
                'data' => $data,
            ];
            return response()->json($response,200);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        // return response()->json($user->addresses);

        if($user->addresses->count()>0){
        $data['addresses'] = $user->addresses;

        $response = [
            'success' => true,
            'message' => 'address list',
            'data' => $data,
        ];
        return response()->json($response,200);

        }else
        $response = [
            'success' => false,
            'message' => 'no address available',
            'data' => '',
        ];
        return response()->json($response,200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator=Validator::make($request->all(),[
            'label'=>'required',
            'name' => 'required',
            'email'=>'required',
            'mobile'=>'required',
            'country'=>'required',
            'state'=>'required',
            'city'=>'required',
            'pincode'=>'required',
            'address'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }else{
            $user = auth()->user();
            $data=$request->all();
            $data['user_id']=$user->id;
            DB::beginTransaction();
            try{
            // Setting default
            if ($data['default'] == 1) {
                $otherAddresses = UserAddress::whereUserId($data['user_id'])->get();
                $otherAddresses->each->update(['default'=>0]);
            }
             DB::commit();
             UserAddress::create($data);
             $response = [
              'success' => true,
              'message' => 'Address added successfully',
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $useraddress=UserAddress::find($id);
        if(is_null($useraddress)){
            $response = [
                'success' => false,
                'message' => 'User Address does not exists',
                'data' => '',
            ];
            return response()->json($response,200);
        }else{
            DB::beginTransaction();
            try{
            $address = UserAddress::findOrFail($id);
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;

            $data['default'] = 0;
            if (!empty($request->default)) {
                $otherAddresses = UserAddress::whereUserId($data['user_id'])->get();
                $otherAddresses->each->update(['default'=>0]);
                $data['default'] = 1;
            }

            $address->update($data);

            DB::commit();
            }catch(\Exception $err){
                DB::rollBack();
                $useraddress=null;
            }
           if(is_null($useraddress)){
            $response = [
                'success' => false,
                'message' => 'Internal Server Error',
                'data' => '',
            ];
            return response()->json($response,200);
           }else{
            $response = [
                'success' => true,
                'message' => 'User Address Updated Successfully',
                'data' => '',
            ];
            return response()->json($response,200);
           }

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $useraddress=UserAddress::find($id);
        if(is_null($useraddress)){
            $response = [
                'success' => false,
                'message' => 'User address does not exists',
                'data' => '',
            ];
            return response()->json($response,200);
        }else{
            DB::beginTransaction();
            try{
               $useraddress->delete();
               DB::Commit();
               $response = [
                'success' => true,
                'message' => 'user address deleted successfully',
                'data' => '',
            ];
            return response()->json($response,200);

            }catch(\Exception $err){
                DB::rollBack();
                   $response = [
                    'success' => false,
                    'message' => 'Internal Serve Error',
                    'data' => '',
                ];
                return response()->json($response,200);
            }
        }
    }

    public function cart() {
        $user = auth()->user();
        $cart = Cart::whereUserId($user->id)->with('product','product.type','product.categories','product.categories','product.prices')->get();
        $data['cart'] = $cart;

        $response = [
            'success' => true,
            'message' => 'Cart list',
            'data' => $data,
        ];

        return response()->json($response,200);
    }

 # Product Save In Cart
 public function addcart(Request $request)
 {
     $user = Auth::user();
     dd($user);
     if ($user) {
         $uid = $user->id;
     } else {
         $uid = session()->getId();
     }

     # Check Already Exist Aur Not
     $chkCart = Cart::where(['user_id' => $uid, 'product_id' => $request->product_id])->first();
     if ($chkCart) {
         return response()->json(['success' => true, 'message' => 'Remove from cart if the item is already added']);
     }
    //  $product = Product::find($request->productid);
    //  if ($request->size_name) {
    //      $getsizename = implode(', ', $request->size_name);
    //  } else {
    //      $getsizename = '';
    //  }
    //  if ($request->size) {
    //      $getsize = implode(', ', $request->size);
    //  } else {
    //      $getsize = '';
    //  }
    //  $cart = new Cart;
    //  $cart->user_id = $uid;
    //  $cart->product_id = $request->product_id;
    //  $cart->qty = isset($request->qty) ? $request->qty : 1;
    // //  $cart->int_id = $request->int_id;
    // //  $cart->color = $request->color;
    // //  $cart->size_name = $getsizename;
    // //  $cart->size = $getsize;
    //  $cart->save();

    $data=$request->all();
    $data['user_id']=$uid;
    Cart::create($data);

    return response()->json([
                 'message'=>'Product Added in Cart Successfully',
                 'status'=>1
            ],
            200
        );
    //  if ($cart->save()) {
    //      return response()->json(['success' => true, 'message' => 'Product Added In Your Cart Successfully']);
    //  } else {
    //      return response()->json(['success' => false, 'message' => 'Product Not Added In Your Cart Try Again']);
    //  }
 }

    // public function addcart(Request $request) {

    //     $validator=Validator::make($request->all(),[
    //         // 'user_id'=>'required',
    //         'product_id' => 'required',
    //         'qty'=>'required',
    //     ]);
    //     if($validator->fails()){
    //         return response()->json($validator->messages(),400);
    //     }else{
    //         $user = auth()->user();
    //         $data=$request->all();
    //         $data['user_id']=$user->id;
    //         DB::beginTransaction();
    //         try{

    //         $cart = Cart::whereUserId($user->id)->get();

    //         Cart::create($data);
    //          DB::commit();
    //         }catch(\Exception $e){
    //             DB::rollBack();
    //         }
    //     }
    //     return response()->json([
    //         'message'=>'Product Added in Cart Successfully',
    //         'status'=>1
    //     ],
    //     200
    // );


    // }

    public function updatecart(Request $request, string $id)
    {
        $user = auth()->user();
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
              $carts->user_id=$user->id;
              $carts->product_id=$request['product_id'];
              $carts->qty=$request['qty'];
              $carts->qty_type=$request['qty_type'];
              $carts->qty_weight=$request['qty_weight'];
              $carts->eggless=$request['eggless'];
              $carts->heart_shape=$request['heart_shape'];
              $carts->photo_cake=$request['photo_cake'];
              $carts->msg_cake=$request['msg_cake'];

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
            ],
            500
        );
           }else{
            return response()->json([
                'message'=>'Cart Updated Successfully',
                'status'=>1
            ],
            200
        );
           }

        }
    }

    public function destroycart(string $id)
    {
        //
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



    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(),[
            // 'business'=>'required',
            'new_password'=>'required',
            'confirm_password'=>'required|same:new_password'
           ]
        );
        if($validator->fails()){
            return response()->json($validator->messages(),200);
        }else{

        $user = Auth::user()->id;
        // dd($user);
        // $user_password = Auth::user()->password;
             User::where('id',$user)->update(['password'=>bcrypt($request->new_password)]);
        //     return redirect()->back()->with('success_message', 'password updated successfully');

        return response()->json(['success' => true, 'message' => 'password updated successfully']);
    }
}
}
