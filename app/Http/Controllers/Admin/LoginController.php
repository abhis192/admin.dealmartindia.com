<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    public function adminLogin() {
        if (auth()->check()) {
            return redirect('login');
        }
        return view('admin.auth.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($request->get('_role') == 'admin') {
            if(auth()->attempt(['email' => $request->input('email'),  'password' => $request->input('password')])){
                if (Auth::user()->role->id == 1) {
                    return redirect()->route('admin.dashboard')->with('success','Logged in successfully.');
                }
            }
        }
        return redirect('admin')->with('error','Admin credentials incorrect');
    }
}
