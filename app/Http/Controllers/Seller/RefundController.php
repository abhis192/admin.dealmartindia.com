<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Refund;
use App\Models\Setting;
use Auth;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $refunds = Refund::where('seller_approval','!=',1)
                            ->WhereHas('orderItem', function($q) {
                                 $q->whereSellerId(Auth::user()->id);
                             })->latest()->get();
        return view('seller.refund.index', compact('refunds'));
    }

    public function accept($id)
    {
        $refund = Refund::findOrFail($id);
        $refund->update(['seller_approval'=>1]);

        Refund::checkRefundAcceptance($id);
    }

    public function reject($id)
    {
        $refund = Refund::findOrFail($id);
        $refund->update(['seller_approval'=>2]);
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

    public function approvedIndex()
    {
        $refunds = Refund::whereSellerApproval(1)->whereAdminApproval(1)
                            ->WhereHas('orderItem', function($q) {
                                 $q->whereSellerId(Auth::user()->id);
                             })->latest()->get();
        return view('seller.refund.approved.index', compact('refunds'));
    }

    public function rejectedIndex()
    {
        $refunds = Refund::whereSellerApproval(2)->orWhere('admin_approval',2)
                            ->WhereHas('orderItem', function($q) {
                                 $q->whereSellerId(Auth::user()->id);
                             })->latest()->get();
        return view('seller.refund.rejected.index', compact('refunds'));
    }

    public function refundsFilter(Request $request)
    {
        // if ($request->method() == "POST") {
        //     $orders = Order::whereSellerId($request->get('seller_id'))->whereBetween('date',[$request->get('start_date'), $request->get('end_date')])->get();

        //     $seller_id = $request->get('seller_id');
        //     $start_date = $request->get('start_date');
        //     $end_date = $request->get('end_date');
        //     $sellers = User::whereRoleId(2)->get();
        //     return view('admin.order.index', compact('orders','sellers','seller_id','start_date','end_date'));
        // } else {
        //     return redirect('/admin/orders');
        // }        
    }
}

