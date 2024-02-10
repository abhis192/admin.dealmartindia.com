<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use Hash;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Mail\OtpNotification;
use Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\Rule;
use App\Mail\NewRegistrationEmail;

class AuthController extends Controller
{
    public function index() {
        $user = auth()->user();
        $user = User::whereId($user->id)->with('addresses')->first();
        return response()->json($user);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'input' => 'required', // Assuming the number is a 10-digit phone number
            'otp' => 'required|digits:4', // Assuming the OTP is a 4-digit code
        ]);

        $user = User::where('mobile', $request->input)->orWhere('email',$request->input)->first();

        if ($user) {
            // Check if the provided OTP matches the stored OTP and it's not expired
            if ($user->otp === $request->otp && now()->lt($user->otp_expiry)) {
                // Clear the OTP fields as it's now verified
                $user->otp = null;
                $user->otp_expiry = null;
                $user->save();

                // Use the standard Laravel Passport login logic to generate a token
                $token = $user->createToken('MyApp')->plainTextToken;

                if ($request->has('session_id')) {
                    $this->updateCartUserId($user->id, $request->session_id);
                }
                Mail::to(configGeneral()->email)->send(new NewRegistrationEmail($user));
                return response()->json([
                    'success' => true,
                    'token' => $token,
                    'name' => $user->name,
                    'message' => 'User login successfully',
                ], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid OTP'], 200);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'User not found'], 200);
        }
    }

    public function generateOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|digits:10', // Assuming the number is a 10-digit phone number
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }

        $phoneNumber = $request->input('number');

        // Check if a user with the provided phone number exists
        $user = User::whereMobile($phoneNumber)->first();
        $otp = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

        if ($user) {
            // User exists, update the OTP and its expiry timestamp in the user's record
            // send email to user
            if (!empty($user->email)) {
                Mail::to($user->email)->send(new OtpNotification($otp));
            }
            $user->otp = $otp;
            $user->otp_expiry = now()->addMinutes(15); // OTP expires in 15 minutes
            $user->save();
        } else {
            // User does not exist, create a new user and generate OTP
            $user = new User();
            $user->name = 'user';
            $user->email = $phoneNumber;
            $user->mobile = $phoneNumber;
            $user->password = Hash::make('test1234');
            $user->otp = $otp;
            $user->otp_expiry = now()->addMinutes(15); // OTP expires in 15 minutes
            $user->save();
        }

        // You can send the OTP to the user through SMS, email, or any other method here

        return response()->json(['message' => 'OTP generated successfully','OTP' => $otp], 200);
    }

    //
    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|min:3|max:255',
    //         'mobile' => 'required|unique:users',
    //         'email' => 'required|unique:users',
    //         'password' => ['required', 'confirmed'],
    //         'password_confirmation' => ['required'],
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->messages(), 200);
    //     }

    //     $data = $request->all();
    //     $data['password'] = Hash::make($request->password);

    //     // Check if 'session_id' exists in the request
    //     if ($request->has('session_id')) {
    //         $user = $this->createWithCart($data, $request->get('session_id'));
    //     } else {
    //         $user = User::create($data);
    //     }

    //     $success['token'] = $user->createToken('MyApp')->plainTextToken;
    //     $success['name'] = $user->name;

    //     $response = [
    //         'success' => true,
    //         'data' => $success,
    //         'message' => 'User registered successfully'
    //     ];

    //     return response()->json($response, 200);
    // }

    protected function createWithCart(array $data, $sessionId)
    {
        $cartItems = Cart::whereUserId($sessionId)->get();
        $user = User::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            // 'password' => Hash::make($data['password']),
        ]);

        if ($user) {
            foreach ($cartItems as $key => $item) {
                $itemData['user_id'] = $user->id;
                Cart::whereId($item->id)->update($itemData);
                // remove duplicate items
                // Cart::removeDuplicateItems($user->id);
            }

            // Send email verification notification
            // $user->sendEmailVerificationNotification();

            session()->flash('success', 'User registered successfully.');
        }
        return $user;
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $user=Auth::user();

                if ($request->has('session_id')) {
                    $this->updateCartUserId($user->id, $request->session_id);
                }

                $success['token']=$user->createToken('MyApp')->plainTextToken;
                $success['name']=$user->name;

               $response=[
                'success'=>true,
                'data'=>$success,
                'message'=>'User login successfully'
               ];

               return response()->json($response,200);
        }else{
            $response=[
                'success'=>false,
                'message'=>'Your email or password is incorrect'
            ];
            return response()->json($response,200);
        }
    }

    public function loginWithOtp(Request $request) {
        $validator = Validator::make($request->all(), [
            'input' => 'required',
            'session_id' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $input = $request->input('input');
        $user = User::where('email', $input)->orWhere('mobile', $input)->first();

        // if ($request->has('session_id')) {
        //     $this->updateCartUserId($user->id, $request->session_id);
        // }

        if ($user) {
            // Never use this in otp generating, use this after otp verified successfully
            // if ($request->has('session_id')) {
            //     $this->updateCartUserId($user->id, $request->session_id);
            // }

            // User exists, send OTP through email or mobile based on the input
            $via = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
            $otp = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

            // Send OTP through email or mobile here (use $via to determine the method)
            if (!empty($user->email)) {
                Mail::to($user->email)->send(new OtpNotification($otp));
            }
            $user->otp = $otp;
            $user->otp_expiry = now()->addMinutes(15); // OTP expires in 15 minutes
            $user->save();


            $data['OTP'] = $otp;
            $data['input'] =$request->input('input');

            // User does not exist, redirect to the register page
            $isEmail = filter_var($input, FILTER_VALIDATE_EMAIL) ? true : false;

            $response = [
                'success' => true,
                'isRegister' => true,
                'isEmail'=>$isEmail,
                'data' => $data,
                'message' => 'OTP sent successfully'
            ];

            return response()->json($response,200);

             // User does not exist, redirect to the register page
            //  $isEmail = filter_var($input, FILTER_VALIDATE_EMAIL) ? true : false;
            // return response()->json(['success' => true, 'isRegister' => true, 'isEmail'=>$isEmail, 'input' => $request->input('input'), 'message'=>'OTP sent successfully'],200);


        } else {
            // User does not exist, redirect to the register page
            // $isEmail = filter_var($input, FILTER_VALIDATE_EMAIL) ? true : false;
            // return response()->json(['success' => false, 'isRegister' => false, 'input' => $request->input('input'), 'isEmail' => $isEmail], 200);


            $data['input'] =$request->input('input');

            // User does not exist, redirect to the register page
            $isEmail = filter_var($input, FILTER_VALIDATE_EMAIL) ? true : false;

            $response = [
                'success' => false,
                'isRegister' => false,
                'isEmail'=>$isEmail,
                'data' => $data,
                'message' => 'Need to registered first'
            ];

            return response()->json($response,200);
        }
    }



    public function registerWithOtp(Request $request) {
        $validator = Validator::make($request->all(), [
            // 'input' => 'required',
            // 'name' => 'required',
            'email' => 'required',
            'session_id' => 'nullable',

            'name' => 'required|string|min:3|max:255',
            'mobile' => 'required|unique:users',
            'email' => 'required|unique:users',
            // 'password' => ['required', 'confirmed'],
            // 'password_confirmation' => ['required'],
        ]);

        if ($validator->fails()) {
            // return response()->json($validator->messages(), 200);
            //  $msg=$validator->messages();
            $response = [
                'success' => false,
                // 'data' => '',
                'message' => 'Email or mobile already taken'
            ];
            return response()->json($response, 200);
        }

        // $user = new User();
        // $user->name = 'user';
        // // $user->email = 'vikas.abhisan@gmail.com';
        // $user->mobile = '8193054955';
        // // $user->otp_expiry = now()->addMinutes(15); // OTP expires in 15 minutes
        // $user->save();

        $data = $request->all();
        // Check if 'session_id' exists in the request

         // Check if 'session_id' exists in the request
         if ($request->has('session_id')) {
            $user = $this->createWithCart($data, $request->get('session_id'));
        } else {
            $user = User::create($data);
        }

        // $user = User::create($data);

        // $input = $request->input('input');
        // $name = $request->input('name');
        $user = User::where('email', $user->email)->orWhere('mobile', $user->mobile)->where('name',$user->name)->first();

        if ($user) {
            // User exists, send OTP through email or mobile based on the input
            // $via = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
            $otp = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

            // Send OTP through email or mobile here (use $via to determine the method)
            if (!empty($user->email)) {
                Mail::to($user->email)->send(new OtpNotification($otp));
            }
            $user->otp = $otp;
            $user->otp_expiry = now()->addMinutes(15); // OTP expires in 15 minutes
            $user->save();


            // $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['OTP'] = $otp;

            $response = [
                'success' => true,
                'data' => $success,
                // 'message' => 'User registered successfully'
                'message' => 'OTP sent successfully'
            ];

            return response()->json($response, 200);

            // return response()->json(['message' => 'OTP sent successfully', 'OTP' => $otp], 200);
        } else {
            // User does not exist, redirect to the register page
            return response()->json(['message' => 'Not Registered user first'], 200);
        }
    }




    // {
    //     $validator = Validator::make($request->all(), [
    //         'number' => 'required|digits:10', // Assuming the number is a 10-digit phone number
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->messages()], 400);
    //     }

    //     $phoneNumber = $request->input('number');

    //     // Check if a user with the provided phone number exists
    //     $user = User::whereMobile($phoneNumber)->first();
    //     $otp = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

    //     if ($user) {
    //         // User exists, update the OTP and its expiry timestamp in the user's record
    //         // send email to user
    //         if (!empty($user->email)) {
    //             Mail::to($user->email)->send(new OtpNotification($otp));
    //         }
    //         $user->otp = $otp;
    //         $user->otp_expiry = now()->addMinutes(15); // OTP expires in 15 minutes
    //         $user->save();
    //     } else {
    //         // User does not exist, create a new user and generate OTP
    //         $user = new User();
    //         $user->name = 'user';
    //         $user->email = $phoneNumber;
    //         $user->mobile = $phoneNumber;
    //         $user->password = Hash::make('test1234');
    //         $user->otp = $otp;
    //         $user->otp_expiry = now()->addMinutes(15); // OTP expires in 15 minutes
    //         $user->save();
    //     }

    //     // You can send the OTP to the user through SMS, email, or any other method here

    //     return response()->json(['message' => 'OTP generated successfully','OTP' => $otp], 200);
    // }



    protected function updateCartUserId($userId, $sessionId)
    {
        $cartItems = Cart::whereUserId($sessionId)->get();

        foreach ($cartItems as $key => $item) {
            $itemData['user_id'] = $userId;
            Cart::whereId($item->id)->update($itemData);
            // remove duplicate items
            // Cart::removeDuplicateItems($userId);
        }
    }

    public function update(Request $request, string $id)
    {
        $validator=Validator::make($request->all(),[
            // 'name' => 'required|string|min:3|max:255',
            // 'mobile'=>'required',
            // 'email'=> 'required|unique:users',
            // 'password' => ['required','confirmed'],
            // 'password_confirmation'=>['required'],
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }

        $user=User::find($id);
        if(is_null($user)){
            return response()->json([
                'message'=>'User does not exists',
                'status'=>0
            ],
            404
        );
        }else{
            DB::beginTransaction();
            try{
                // $useraddress=$request->all();
              $user->role_id=$request['role_id'];
              $user->name=$request['name'];
              $user->email=$request['email'];
              $user->mobile=$request['mobile'];
              $user->dob=$request['dob'];
              $user->gender=$request['gender'];
            //   $user->email_verified_at=$request['email_verified_at'];
            //   $user['password']=Hash::make($request->password);
            //   $user->password=$request['password'];
            //   $user->avatar=$request['avatar'];
            // if(empty($user->avatar=$request['avatar'])){
            //     $user->avatar='default.png';
            // }

            // if($image != '') {
            //     if ($user->image != 'default.png') {
            //         File::delete('storage/user/'. $user->image);
            //     }
            //     $image_name = rand() . '.' . $image->getClientOriginalName();
            //     $image->move(public_path('storage/user'), $image_name);
            //     $image_name = $image_name;
            // }

              if($user->avatar=$request->hasFile('avatar')){
                $fileImage = $user->avatar=$request->file('avatar');
                $fileImageName = rand() . '.' . $fileImage->getClientOriginalName();
                $fileImage->storeAs('public/user/',$fileImageName);
                $user->avatar=$request['avatar'] = $fileImageName;
              }
            // }

              $user->business=$request['business'];
              $user->address=$request['address'];
              $user->gst_no=$request['gst_no'];
              $user->gst_name=$request['gst_name'];
              $user->save();

                DB::commit();
            }catch(\Exception $err){
                DB::rollBack();
                $user=null;
            }
           if(is_null($user)){
            return response()->json([
                'message'=>'Internal Server Error',
                'status'=>0,
                'error_msg'=>$err->getMessage(),
            ],
            500
        );
           }else{
            return response()->json([
                'message'=>'User Updated Successfully',
                'status'=>1
            ],
            200
        );
           }

        }
    }




    public function updateProfile(Request $request, string $id)
    {
        $validator=Validator::make($request->all(),[
            // 'name' => 'required|string|min:3|max:255',
            // 'mobile'=>'required',
            // 'email'=> 'required|unique:users',
            // 'password' => ['required','confirmed'],
            // 'password_confirmation'=>['required'],
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }

        $user=User::find($id);
        if(is_null($user)){
            return response()->json([
                'message'=>'User does not exists',
                'status'=>0
            ],
            404
        );
        }else{
            DB::beginTransaction();
            try{
                // $useraddress=$request->all();
              $user->role_id=$request['role_id'];
              $user->name=$request['name'];
              $user->email=$request['email'];
              $user->mobile=$request['mobile'];
              $user->dob=$request['dob'];
              $user->gender=$request['gender'];

              if($user->avatar=$request->hasFile('avatar')){
                $fileImage = $user->avatar=$request->file('avatar');
                $fileImageName = rand() . '.' . $fileImage->getClientOriginalName();
                $fileImage->storeAs('public/user/',$fileImageName);
                $user->avatar=$request['avatar'] = $fileImageName;
              }
            // }

              $user->business=$request['business'];
              $user->address=$request['address'];
              $user->gst_no=$request['gst_no'];
              $user->gst_name=$request['gst_name'];
              $user->save();

                DB::commit();
            }catch(\Exception $err){
                DB::rollBack();
                $user=null;
            }
           if(is_null($user)){
            return response()->json([
                'message'=>'Internal Server Error',
                'status'=>0,
                'error_msg'=>$err->getMessage(),
            ],
            500
        );
           }else{
            return response()->json([
                'message'=>'User Updated Successfully',
                'status'=>1
            ],
            200
        );
           }

        }
    }

           public function logout(){
                 auth()->user()->tokens()->delete();
                 return response(['message'=>'user logout successfully']);
           }

        // {
        //     $user= User::where('email', $request->email)->first();
        //     // print_r($data);
        //         if (!$user || !Hash::check($request->password, $user->password)) {
        //             return response([
        //                 'message' => ['These credentials do not match our records.']
        //             ], 404);
        //         }

        //          $token = $user->createToken('my-app-token')->plainTextToken;

        //         $response = [
        //             'user' => $user,
        //             'token' => $token
        //         ];

        //          return response($response, 201);
        // }

        public function googleLogin(){
            return Socialite::driver('google')->redirect();
        }

        public function loginWithGoogle(Request $request) {
            // Google login using Socialite
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if user exists or create a new user
            $user = User::firstOrCreate(['email' => $googleUser->email], [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                // Add other user attributes as needed
            ]);

            $token = $user->createToken('google-login')->accessToken;

            return response()->json(['token' => $token]);
        }



        public function callbackFromGoogle(){
            try {
                $user= Socialite::driver('google')->user();
                $is_user= User::where('email',$user->getEmail())->first();
                if(!$is_user){
                    $saveUser= User::updateorCreate(
                        [
                           'google_id'=>$user->getId()
                        ],
                        [
                            'name'=>$user->getName(),
                            'email'=>$user->getEmail(),
                            'password'=>Hash::make($user->getName().'@'.$user->getId())
                        ]
                        );
                }
                else{
                    $saveUser= User::where('email',$user->getEmail())->update([
                    'google_id'=>$user->getId(),
                  ]);
                  $saveUser=User::where('email',$user->getEmail())->first();
                }
                Auth::loginUsingId($saveUser->id);
                return redirect()->route('home');
            } catch (\Throwable $th) {
                throw $th;
            }
        }
}
