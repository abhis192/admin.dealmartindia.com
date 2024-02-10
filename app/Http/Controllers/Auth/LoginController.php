<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Http\Request;
use Session;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(Auth::check() && Auth::user()->role->id == 1 && Auth::user()->email_verified_at != null)
        {
            $this->redirectTo = route('admin.dashboard');
        } elseif(Auth::check() && Auth::user()->role->id == 2 && Auth::user()->email_verified_at != null) {
            $this->redirectTo = route('seller.dashboard');
        } elseif(Auth::check() && Auth::user()->role->id == 3 && Auth::user()->email_verified_at != null && Auth::user()->deleted_at == null) {
            $this->redirectTo = route('customer.dashboard');
        }
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $cartItems = Cart::whereUserId(session()->getId())->get();//$request->get('session_id)
        $credentials = $request->only('email','password');
        if (Auth::attempt($credentials)) {
            if(Auth::user()->email_verified_at != null && Auth::user()->deleted_at == null) {
                foreach ($cartItems as $key => $item) {
                    $data['user_id'] = Auth::user()->id;
                    Cart::whereId($item->id)->update($data);
                    // remove duplicate items
                    Cart::removeDuplicateItems(Auth::user()->id);
                }
                if (Auth::user()->role_id == '3' && $cartItems->count() > 0) {
                    return redirect('checkout')->with('success','Logged in successfully.');
                }
                return redirect('login')->with('success','Logged in successfully.');
            }
        }
        return redirect('login')->with('failure','Please check your credentials.');
    }
}
