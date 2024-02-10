<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\ConfigRefund;
use App\Models\User;
use App\Models\Commission;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusEmail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::WhereHas('orderItems', function($q) {
                                $q->whereSellerId(Auth::user()->id);
                            })->latest()->get();
        $sellers = User::whereRoleId(2)->get();
        return view('seller.order.index', compact('orders','sellers'));
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

    public function detail($id)
    {
        $order = Order::findOrFail($id);
        return view('seller.order.detail',compact('order'));
    }

    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        return view('seller.order.invoice', compact('order'));
    }

    public function orderFilter(Request $request)
    {
        if ($request->method() == "POST") {
            $orders = Order::whereSellerId($request->get('seller_id'))->whereBetween('date',[$request->get('start_date'), $request->get('end_date')])->get();

            $seller_id = $request->get('seller_id');
            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');
            $sellers = User::whereRoleId(2)->get();
            return view('seller.order.index', compact('orders','sellers','seller_id','start_date','end_date'));
        } else {
            return redirect('/seller/orders');
        }
    }

    public function orderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $orderStatus = OrderStatus::whereOrderId($id)->whereOrderStatus($request->get('order_status'))->first();
        if ($orderStatus) {
            $data = $request->all();
            $orderStatus->update(['updated_by'=>Auth::user()->id, 'comment'=>$request->get('comment'), 'payment_status'=>$request->get('payment_status')]);
            Mail::to($order->address->email)->send(new OrderStatusEmail($order, $data));
        } else {
            $data = $request->all();
            $data['order_id'] = $id;
            $data['updated_by'] = Auth::user()->id;
            $orderStatus = OrderStatus::create($data);

            Mail::to($order->address->email)->send(new OrderStatusEmail($order, $data));

            if ($orderStatus && $request->get('order_status') == 'Delivered') {
                foreach ($order->orderItems as $key => $item) {
                    $dataCommission['order_item_id'] = $item->id;
                    $dataCommission['seller_id'] = $item->seller_id;
                    $dataCommission['order_total'] = $item->qty * ($item->price + $item->tax);
                    $dataCommission['commission_rate'] = $order->commission_rate;
                    $dataCommission['admin_commission'] = ($order->commission_rate/100)*($item->qty * ($item->price + $item->tax));
                    // $dataCommission['seller_earning'] = ($item->qty * ($item->price + $item->tax)-($order->commission_rate/100)*($item->qty * ($item->price+$item->tax)));
                    $dataCommission['seller_earning'] = (($item->price + $item->tax));
                    // $dataCommission['payment_at'] = now()->addDays($item->product->refundable_day??ConfigRefund::first()->refund_time);
                    $dataCommission['payment_at'] = now();

                    Commission::create($dataCommission);
                }
            }
        }

        $order->update(['order_status'=>$request->get('order_status')]);
        return redirect()->back()->with('success','Order status changed successfully.');
    }
}
