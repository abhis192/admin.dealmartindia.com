<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payout;
use App\Models\User;
use App\Models\ConfigCommission;
use Auth;

class PayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payouts = Payout::whereStatus('Successful')->whereUserId(Auth::user()->id)->latest()->get();
        return view('seller.payout.index', compact('payouts'));
    }

    public function payoutRequest()
    {
        $payouts = Payout::whereUserId(Auth::user()->id)->latest()->get();
        $payout_commission = ConfigCommission::first();
        return view('seller.payout.request', compact('payouts','payout_commission'));
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
        if (Auth::user()->wallet_balance > $request->get('amount')) {
            $data['user_id'] = Auth::user()->id;
            $data['requested_amt'] = $request->get('amount');
            $data['total_amt'] = $request->get('total_amt');
            $data['status'] = 'Pending';
            $payout = Payout::create($data);
        } else {
            return redirect('seller/payout-request')->with('failure','Unsufficient Wallet Balance');
        }        
        return redirect('seller/payout-request');
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
}
