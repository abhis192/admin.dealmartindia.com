<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    public function sellerLogin() {
        if (auth()->check()) {
            return redirect('login');
        }
        return view('seller.auth.login');
    }

    public function sellerRegister() {
        return view('seller.auth.register');
    }

    // public function sellerCreate() {
    //     return view('admin.seller.create');
    // }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($request->get('_role') == 'seller') {
            if(auth()->attempt(['email' => $request->input('email'),  'password' => $request->input('password')])){
                if (Auth::user()->role->id == 2) {
                    return redirect()->route('seller.dashboard')->with('success','Logged in successfully.');
                }
            } else {
                return redirect('seller')->with('error','Pleasse check your credentials.');
            }
        }
        return redirect('seller')->with('error','Pleasse verify your account and check credentials.');
    }

    public function sellerRegisterUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $data = $request->all();
        $data['role_id'] = 2;
        $data['password'] = Hash::make($request->get('password'));

        User::create($data);
        // email send to seller for verification
        return redirect('seller')->with('success','An email sent to you. Please verify to login.');
    }
}
