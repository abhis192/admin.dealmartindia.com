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
use Carbon\carbon;
use App\Mail\NewRegistrationEmail;

class AuthController extends Controller
{
    public function index() {
        $user = auth()->user();
        $user = User::whereId($user->id)->with('addresses')->first();
        return response()->json($user);
    }

    //generate otp
    public function generateOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10', // Assuming the number is a 10-digit phone number
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }
        $phoneNumber = $request->input('mobile');
        // Check if a user with the provided phone number exists
        $user = User::whereMobile($phoneNumber)->first();
        $otp = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

        if ($user) {
            // User exists, update the OTP and its expiry timestamp in the user's record
            $user->otp = $otp;
            $user->otp_expiry = now()->addMinutes(15); // OTP expires in 15 minutes
            $user->save();

            $data['mobile']=$user->mobile;
            $data['otp']=$otp;
            $response = [
                'success' => true,
                'message' => 'OTP generated successfully',
                'data' => $data,
            ];

            return response()->json($response,200);

        } else {

            $validatedData = Validator::make($request->all(), [
                'mobile' => 'required|digits:10',
            ])->validate();

            // Check if a record with the given email and mobile exists
            $userVerify = DB::table('user_verifies')
                ->where('mobile', $validatedData['mobile'])
                ->first();

            // If a record exists, update the OTP and expiry time
            if ($userVerify) {
                $otp = sprintf('%04d', rand(0, 9999));
                DB::table('user_verifies')
                    // ->where('email', $validatedData['email'])
                    ->where('mobile', $validatedData['mobile'])
                    ->update([
                        'otp' => $otp,
                        'otp_expiry' => now()->addMinutes(20),
                    ]);

                // You can now send the updated OTP to the user through a preferred method (e.g., email, SMS)
                // return response()->json(['message' => 'OTP updated successfully', 'otp' => $otp], 200);
                $data['otp']=$otp;
                $response = [
                    'success' => true,
                    'data' => $data,
                    'message' => 'OTP sent successfully'
                ];

                return response()->json($response,200);
            }

            // If no record exists, create a new one
            $otp = sprintf('%04d', rand(0, 9999));
            DB::table('user_verifies')->insert([
                'mobile' => $validatedData['mobile'],
                'otp' => $otp,
                'otp_expiry' => now()->addMinutes(config('otp.expiry_minutes')),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // return response()->json(['message' => 'OTP generated successfully', 'otp' => $otp], 200);
            $data['mobile']=$validatedData['mobile'];
            $data['otp']=$otp;
            $response = [
                'success' => true,
                'message' => 'OTP generated successfully',
                'data' => $data,
            ];

            return response()->json($response,200);

            // You can send the OTP to the user through SMS, email, or any other method here

        }

    }

    //verify otp
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'input' => 'required',
            'otp' => 'required|digits:4',
        ]);

        // Check if the user exists in the users table
        $user = User::where('mobile', $request->input)->orWhere('email', $request->input)->first();

        if (!$user) {
            // Check if the user exists in the user_verifies table
            $userVerify = DB::table('user_verifies')
                ->where('mobile', $request->input)
                // ->orWhere('email', $request->input)
                ->first();

            if ($userVerify && $userVerify->otp === $request->otp) {
                // If OTP matches and not expired, create a new user and delete the entry
                $user = User::create([
                    'name' => 'user',
                    // 'email' => $userVerify->email,
                    'mobile' => $userVerify->mobile,
                    'email_verified_at' => Carbon::now(),
                    'otp' => $request->otp,
                    // 'password' => Hash::make('test1234'),
                    // Add any additional fields you want to copy from user_verifies to users
                ]);

                // Delete the entry from user_verifies
                DB::table('user_verifies')->where('id', $userVerify->id)->delete();
            } else {
                // return response()->json(['success' => false, 'message' => 'Invalid OTP or user not found'], 422);
                $response = [
                    'success' => false,
                    'message' => 'Invalid OTP or user not found',
                    'data' => '',
                ];
                return response()->json($response,200);
            }
        }

        // Check if the provided OTP matches the stored OTP and it's not expired
        if ($user->otp === $request->otp) {
            // Clear the OTP fields as it's now verified
            $user->otp = null;
            $user->otp_expiry = null;
            $user->save();

            // Use the standard Laravel Passport login logic to generate a token
            $token = $user->createToken('MyApp')->plainTextToken;

            // if ($request->has('session_id')) {
            //     $this->updateCartUserId($user->id, $request->session_id);
            // }
            Mail::to(configGeneral()->email)->send(new NewRegistrationEmail($user));

            $data['name'] = $user->name;
            $data['mobile'] = $user->mobile;
            $data['token'] = $token;

            $response = [
                'success' => true,
                'message' => 'User login successfully',
                'data' => $data,
            ];
            return response()->json($response,200);

        } else {
            // return response()->json(['success' => false, 'message' => 'Invalid OTP'], 422);
            $response = [
                'success' => false,
                'message' => 'Invalid OTP',
                'data' => '',
            ];
            return response()->json($response,200);
        }
    }

    //update profile
    public function updateProfile(Request $request)
    {
        $validator=Validator::make($request->all(),[
            $user=Auth()->user(),
            'name'=>'required',
            'mobile' => 'unique:users,mobile,' . $user->id,
            // 'email'=> 'unique:users',
            'email' => 'unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            $errorMessage = implode(' ', $validator->messages()->all());

            $response = [
                'success' => false,
                'message' => $errorMessage,
                'data' => '',
            ];

            return response()->json($response, 200);
        }
            // DB::beginTransaction();
            // try{
                // $useraddress=$request->all();
              $user->role_id=3;
              $user->name=$request['name'];
              $user->email=$request['email'];
              $user->mobile=$request['mobile'];
              $user->dob=$request['dob'];
              $user->gender=$request['gender'];
            //   dd($user)
              $user->save();

            //     DB::commit();
            // }catch(\Exception $err){
            //     DB::rollBack();
            //     // $user=null;
            // }
        //    if(is_null($user)){
        //     $response = [
        //         'success' => false,
        //         'message' => 'Internal Server Error',
        //         'error_msg'=>$err->getMessage(),
        //         'data' => '',
        //     ];
        //     return response()->json($response,200);
        //    }else{
        $response = [
            'success' => true,
            'message' => 'User Updated Successfully',
            'data' => '',
        ];
        return response()->json($response,200);
           }
        // }
    // }

    //logout user
    public function logout(){
            auth()->user()->tokens()->delete();
            return response(['message'=>'user logout successfully']);
    }
}
