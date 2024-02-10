<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use App\Models\ConfigCommission;
use App\Models\ConfigRefund;
use App\Models\Commission;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use App\Models\OrderDelivery;
use App\Models\DeliveryOption;
use App\Models\ConfigGeneral;
use App\Models\Slot;
use Carbon\carbon;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusEmail;
use App\Mail\OrderConfirmationEmail;
use App\Mail\NewOrderPlacedEmail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::latest()->get();
        $orderItems = OrderItem::latest()->get();
        $sellers = User::whereRoleId(2)->get();
        return view('admin.order.index', compact('orders','sellers','orderItems'));
    }

    public function inhouseIndex()
    {
        $orders = Order::WhereHas('orderItems', function($q) {
                            $q->whereHas('seller', function($r){
                                $r->whereRoleId(1);
                            });
                            })->latest()->get();
        $sellers = User::whereRoleId(2)->get();
        return view('admin.order.inhouse.index', compact('orders','sellers'));
    }

    public function sellerIndex()
    {
        $orders = Order::WhereHas('orderItems', function($q) {
                            $q->whereHas('seller', function($r){
                                $r->whereRoleId(2);
                            });
                            })->latest()->get();
        $sellers = User::whereRoleId(2)->get();
        return view('admin.order.seller.index', compact('orders','sellers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        {
            // $categories = Category::whereStatus(1)->whereNull('parent_category_id')->get();
            // // $brands = Brand::whereStatus(1)->get();
            // $attributes = Attribute::whereStatus(1)->get();
            // $types = Type::whereStatus(1)->get();
            // $tags = ProductTag::all();
            $slots = Slot::whereStatus(1)->get();
            $deliveryoptions = DeliveryOption::whereStatus(1)->get();
            $sellers = User::whereRoleId(2)->get();
            return view('admin.order.create',compact('sellers','deliveryoptions','slots'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $AddressData['name'] = $request->name;
        $AddressData['email'] = $request->email;
        $AddressData['mobile'] = $request->mobile;
        $AddressData['address'] = $request->address;
        $AddressData['pincode'] = $request->pincode;
        $AddressData['landmark'] = $request->landmark;
        $AddressData['country'] = $request->country;
        $AddressData['state'] = $request->state;
        $AddressData['city'] = $request->city;
        $AddressData['area'] = $request->area;

        $orderAddress = OrderAddress::create($AddressData);



        $deliveryData['delivery_date'] = $request->delivery_date;
        $deliveryData['delivery_type'] = $request->delivery_type;
        $deliveryData['delivery_time'] = $request->delivery_time;

        $delivery = OrderDelivery::create($deliveryData);


        $order = new Order();
        $order->order_no = Carbon::now()->format('dmY').'-'.mt_rand(11111,99999);
        $order->seller_id = $request->get('seller_id');
        $order->source = $request->get('source');
        $order->user_id =1;
        $order->order_address_id = $orderAddress->id;
        $order->delivery_id = $delivery->id;
        // $order->date = Carbon::now();
        $order->order_status = 'Pending';
        $order->order_mode = $request->get('payment');
        $order->shipping_rate = $request->get('shipping_rate');
        // /count($cartItemsBySellers);
        // $order->commission_rate = ConfigCommission::first()->seller_commission;
        $order->save();
        foreach ($request->qty_type as $key => $val) {

                    $priceData['order_id'] = $order->id;
                    // $priceData['seller_id'] = $request->seller_id;
                    $priceData['product_name'] = $request->product_name[$key];
                    $priceData['qty_type'] = $val;
                    $priceData['qty_weight'] = $request->qty_weight[$key];
                    $priceData['qty'] = $request->qty[$key];
                    $priceData['price'] = $request->price[$key];
                    // if($priceData['image']=$request->hasFile('image')){
                    //     $fileImage = $request->file('image');
                    //     $fileImageName = rand() . '.' . $fileImage->getClientOriginalName();
                    //     $fileImage->storeAs('public/order/',$fileImageName);
                    //     $priceData['image'] = $fileImageName;
                    // }
                    // $priceData['discount_type'] = $request->discount_type[$key];
                    // $priceData['discount_value'] = $request->discount_value[$key];
                    // $priceData['final_price'] = $final_price;
                    $productPrice = OrderItem::create($priceData);

                    // }
                    // status pending
                $orderData['order_id'] = $order->id;
                $orderData['comment'] = null;
                $orderData['order_status'] = 'Pending';

                if($request->get('payment') == 'Online'){ $paymentStatus = 'paid'; }
                $paymentStatus = $paymentStatus??'unpaid';

                $orderData['payment_status'] = $paymentStatus;
                OrderStatus::create($orderData);
        }
        Mail::to($order->address->email)->send(new OrderConfirmationEmail($order));
        Mail::to(configGeneral()->email)->send(new NewOrderPlacedEmail($order));

        return redirect('/admin/orders')->with('success','Order created successfully.');
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
        $orderItem = OrderItem::findOrFail($id);
        $sellers = User::whereRoleId(2)->get();
        $order = Order::findOrFail($id);
        return view('admin.order.detail',compact('order','sellers','orderItem'));
    }

    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.order.invoice', compact('order'));
    }

    public function orderFilter(Request $request)
    {
        if ($request->method() == "POST") {
            $orders = Order::whereSellerId($request->get('seller_id'))->whereBetween('date',[$request->get('start_date'), $request->get('end_date')])->get();

            $seller_id = $request->get('seller_id');
            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');
            $sellers = User::whereRoleId(2)->get();
            return view('admin.order.index', compact('orders','sellers','seller_id','start_date','end_date'));
        } else {
            return redirect('/admin/orders');
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

            // if ($orderStatus && $request->get('order_status') == 'Delivered') {
            //     foreach ($order->orderItems as $key => $item) {
            //         $dataCommission['order_item_id'] = $item->id;
            //         $dataCommission['seller_id'] = $item->seller_id;
            //         $dataCommission['order_total'] = $item->qty * ($item->price + $item->tax);
            //         $dataCommission['commission_rate'] = $order->commission_rate;
            //         // $dataCommission['admin_commission'] = ($order->commission_rate/100)*($item->qty * ($item->price + $item->tax));
            //         $dataCommission['admin_commission'] = ($order->commission_rate/100)* ($item->price + $item->tax);
            //         // $dataCommission['seller_earning'] = ($item->qty * ($item->price + $item->tax)-($order->commission_rate/100)*($item->qty * ($item->price+$item->tax)));
            //         // $dataCommission['payment_at'] = now()->addDays($item->product->refundable_day??ConfigRefund::first()->refund_time);
            //         // $dataCommission['seller_earning'] = (($item->price + $item->tax));
            //         $dataCommission['seller_earning'] = ($item->qty *($item->price + $item->tax));
            //         $dataCommission['payment_at'] = now();
            //         Commission::create($dataCommission);
            //     }
            // }
        }

        $order->update(['order_status'=>$request->get('order_status')]);
        return redirect()->back()->with('success','Order status changed successfully.');
    }

    public function productPrice(Request $request, $id)
    {
        $productPrice = OrderItem::findOrFail($id);
        $productPrice->update(['seller_id'=>$request->get('seller_id')]);
        return redirect()->back()->with('success','Kitchen changed successfully.');
    }

    public function duplicateStatusCheck($order)
    {
        foreach ($order->statuses as $key => $status) {
            dd($status);
        }
    }
}
