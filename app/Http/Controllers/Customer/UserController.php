<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function account()
     {
         $user = Auth::user();
         return view('customer.account', compact('user'));
     }

    public function index()
    {
        $user = Auth::user();
        return view('customer.profile.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|min:3|max:255',
            'mobile' => 'required|numeric|digits:10',
            'dob'=> 'required|date_format:Y-m-d|before:today',
            'gender'=> 'required|in:male,female',
            'image'=> 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'hidden_image'=> 'nullable|string',
        ]);
        $data = $request->all();
        $user = User::findOrFail($id);

        $image_name = $request->hidden_image;
        $image = $request->file('image');
        if($image != '') {
            if ($user->image != 'default.png') {
                File::delete('storage/user/'. $user->image);
            }
            $image_name = rand() . '.' . $image->getClientOriginalName();
            $image->move(public_path('storage/user'), $image_name);
            $image_name = $image_name;
        }

        $data['avatar'] = $image_name;
        $user->update($data);
        return redirect('/customer/profile')->with('success', 'Your profile has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
