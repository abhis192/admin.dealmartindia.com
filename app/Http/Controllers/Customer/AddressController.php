<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = UserAddress::whereUserId(Auth::user()->id)->get();
        return view('customer.address.index', compact('addresses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $address = UserAddress::findOrFail($id);
        return view('customer.address.edit', compact('address'));
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
            'label' => 'required',
            'name' => 'required|string|min:3',
            'mobile' => 'required',
            'email' => 'required|email',
            'pincode' => 'required|string',
            'address' => 'required|string',
            'city' => 'required',
            'country' => 'required',
            'state' => 'required',
            'landmark' => 'nullable',
            'default' => 'nullable'
        ]);
        $address = UserAddress::findOrFail($id);
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $data['default'] = 0;
        if (!empty($request->default)) {
            $data['default'] = 1;
            $otherAddresses = UserAddress::whereUserId($data['user_id'])->get();
            $otherAddresses->each->update(['default'=>0]);
        }

        $address->update($data);
        return redirect('/customer/address')->with('success','Address updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserAddress::findOrFail($id)->delete();
        return redirect()->back()->with('success','Address removed successfully.');
    }
}
