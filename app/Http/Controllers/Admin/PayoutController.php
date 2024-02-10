<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payout;

class PayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payouts = Payout::latest()->get();
        return view('admin.payout.index', compact('payouts'));
    }

    public function payoutRequest()
    {
        $payouts = Payout::where('status','!=','Successful')->latest()->get();
        return view('admin.payout.request', compact('payouts'));
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
        $payout = Payout::findOrFail($id);
        $data = $request->all();
        $data['status'] = 'Successful';
        $payout->update($data);
        return redirect('/admin/payout-request')->with('success','Payment successfully.');
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



    public function payment(Request $request, $id){
        $payout = Payout::findOrFail($id);
        $payout->update(['status'=>'success','payment_mode'=>$request->get('payment_mode'),'description'=>$request->get('description')]);
        return redirect('/admin/payouts')->with('success','payment done successfully.');
    }

    public function invoice($id)
    {
        $payout = Payout::findOrFail($id);
        return view('admin.payout.invoice', compact('payout'));
    }
}
