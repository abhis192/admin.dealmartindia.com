<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserBank;
use App\Models\UserUpi;
use App\Models\UserLegal;
use App\Models\Product;
use Carbon\carbon;
use Hash;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = User::whereRoleId(3)->get();
        $user = Auth::user();
        return view('seller.profile.index', compact('user'));
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
        $user = User::findOrFail($id);
        return view('seller.profile.edit', compact('user'));
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
        //
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

    public function allSellerUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email',
            'mobile' => 'required',
            'dob'=> 'nullable|date_format:Y-m-d|before:today',
            'gender'=> 'nullable|in:male,female',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password'=>'nullable|string|min:8|confirmed'
        ]);

        $user = User::findOrFail($id);
        $data = $request->all();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data['password'] = $user->password;
        }

        $user->update($data);
        return redirect(url()->previous())->with('success', 'Seller has been successfully updated.');
    }

    public function allSellerPassUpdate(Request $request, $id) {
        $request->validate([
            'password'=>'required|string|min:8|confirmed'
        ]);

        $user = User::findOrFail($id);
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        $user->update($data);
        return redirect(url()->previous())->with('success', 'Seller password has been successfully updated.');
    }

    public function bankUpdate(Request $request, $id)
    {
        $request->validate([
            'holders_name'=>'required|string',
            'account_no'=>'required|string',
            'bank_name'=>'required|string',
            'ifsc_code'=>'required|string',
            'branch_name'=>'required|string'
        ]);

        $userBank = UserBank::whereUserId($id)->first();
        $data = $request->all();
        $data['user_id'] = $id;

        if ($userBank) {
            $userBank->update($data);
        } else {
            UserBank::create($data);
        }
        return redirect(url()->previous())->with('success', 'Seller Bank details has been successfully updated.');
    }

    public function upiUpdate(Request $request, $id)
    {
        $request->validate([
            'upi_name'=>'required|string',
            'upi_id'=>'required|string'
        ]);

        $userUpi = UserUpi::whereUserId($id)->first();
        $data = $request->all();
        $data['user_id'] = $id;

        if ($userUpi) {
            $userUpi->update($data);
        } else {
            UserUpi::create($data);
        }
        return redirect(url()->previous())->with('success', 'Seller UPI details has been successfully updated.');
    }

    public function gstUpdate(Request $request, $id)
    {
        $request->validate([
            'gst_name'=>'nullable|string',
            'gst_no'=>'nullable|string'
        ]);

        $user = User::findOrFail($id);
        $data = $request->all();
        $user->update($data);
        return redirect(url()->previous())->with('success', 'Seller GST details has been successfully updated.');
    }

    public function legalDocuments(Request $request, $id)
    {
        if($request->hasfile('legals')) {
            foreach ($request->file('legals') as $key => $value) {
                $valueName = rand() . '.' . $value->getClientOriginalName();
                $value->storeAs('public/documents/',$valueName);

                $documentData['user_id'] = $id;
                $documentData['image'] = $valueName;
                UserLegal::create($documentData);
            }
        }
        return redirect(url()->previous())->with('success', 'Legal documents has been successfully uploaded.');
    }



    public function mappingUpdate(Request $request, $id)
    {
        $request->validate([
            'upi_name'=>'required|string',
            'upi_id'=>'required|string'
        ]);

        $userUpi = UserUpi::whereUserId($id)->first();
        $data = $request->all();
        $data['user_id'] = $id;

        if ($userUpi) {
            $userUpi->update($data);
        } else {
            UserUpi::create($data);
        }
        return redirect(url()->previous())->with('success', 'Seller UPI details has been successfully updated.');
    }

    public function kitchenPriceList()
    {
        $products=Product::all();
        return view('seller.price-list.index', compact('products'));
    }
}
