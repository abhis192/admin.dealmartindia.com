<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAttribute;
use App\Models\OrderDelivery;
use App\Models\OrderStatus;
use App\Models\OrderAddress;
use App\Models\UserAddress;
use App\Models\Cart;
use App\Models\ConfigGeneral;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusEmail;
use App\Mail\OrderConfirmationEmail;

use Auth;
use Carbon\carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // show data of type table
    public function index() {
        $user = auth()->user();
        $orders = Order::whereUserId($user->id)->latest()->with('seller','user','OrderItems','orderAddress','delivery')
            ->paginate(10);

        return response()->json($orders);
    }

    public function placeOrder(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required|exists:users,id', // Make sure the user exists
            'order_items' => 'required|array|min:1',
            'order_items.*.product_id' => 'required|exists:products,id', // Make sure each product exists
            'order_items.*.qty' => 'required|numeric|min:1',
            // Add more validation rules as needed
            'order_deliveries' => 'required|array|min:1',
            'order_statuses' => 'required|array|min:1',
            // Add validation rules for deliveries and statuses
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }

        // Start a database transaction
        // DB::beginTransaction();

        try {
            // start [order_deliveries]
            $delivery = OrderDelivery::create([
                'delivery_date' => $request->get('order_deliveries')[0]['delivery_date'],
                'delivery_type' =>$request->get('order_deliveries')[0]['delivery_type'],
                'delivery_time' =>$request->get('order_deliveries')[0]['delivery_time'],
            ]);

            $user_address = UserAddress::findOrFail($request->get('order_address_id'));
            if($user_address) {
                $order_address = OrderAddress::create([
                    'name' => $user_address['name'],
                    'email' => $user_address['email'],
                    'mobile' =>$user_address['mobile'],
                    'address' =>$user_address['address'],
                    'pincode' =>$user_address['pincode'],
                    'area' =>$user_address['area']??null,
                    'landmark' =>$user_address['landmark'],
                    'country' =>$user_address['country'],
                    'state' =>$user_address['state'],
                    'city' =>$user_address['city'],
                ]);
            }
            // dd($order_address);
            // Create the main order
            $order = Order::create([
                // 'user_id' => $request->input('user_id'),
                'user_id' => auth()->user()->id,
                'source' => $request->input('source'),
                'order_no' => Carbon::now()->format('dmY').'-'.mt_rand(11111,99999),
                // 'date' => Carbon::now(),
                'delivery_id' =>$delivery->id,
                'order_address_id' =>$order_address->id,
                // 'order_address_id' =>$request->input('order_address_id'),
                'order_status' => 'Pending',
                'shipping_rate' =>$request->input('shipping_rate'),
                'order_mode' =>$request->input('order_mode'),
                'transaction_id' =>$request->input('transaction_id'),
                // Add other fields as needed
            ]);

            // Order Items
            foreach ($request->input('order_items') as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    // 'seller_id' => $item['seller_id'],
                    // 'seller_id' => $request->seller_id,
                    'price' => $item['price'],
                    'eggless'=>$item['eggless'],
                    'heart_shape'=>$item['heart_shape'],
                    'photo_cake'=>$item['photo_cake'],
                    'msg_cake'=>$item['msg_cake'],
                    'cake_flavour'=>$item['cake_flavour'],
                    'qty_weight'=>$item['qty_weight'],
                    'qty_type'=>$item['qty_type'],
                    'discount_type'=>$item['discount_type'],
                    'discount'=>$item['discount'],
                    'coupon_discount'=>$item['coupon_discount']
                    //Add other fields as needed
                    // 'delivery_id' => $order_deliveries->id
                ]);
// dd('order_items');
                // You can also handle order attributes associated with each item here
                if (isset($item['attributes'])) {
                    foreach ($item['attributes'] as $attribute) {
                        OrderAttribute::create([
                            'order_item_id' => $orderItem->id,
                            'name' => $attribute['name'],
                            'value' => $attribute['value'],
                        ]);
                    }
                }
            }

            // Loop through order statuses and create records
            foreach ($request->input('order_statuses') as $status) {
                OrderStatus::create([
                    'order_id' => $order->id,
                    'comment' => $status['comment'],
                    'order_status' => $status['order_status'],
                    'payment_status' => $status['payment_status'],
                    'updated_by' => $status['updated_by'],
                    // Add other fields as needed
                ]);
            }


            // Commit the transaction
            // DB::commit();

             // cleaning process
             Cart::whereUserId(auth()->user()->id)->get()->each->delete();

             Mail::to($order->address->email)->send(new OrderConfirmationEmail($order));
             Mail::to(configGeneral()->email)->send(new OrderConfirmationEmail($order));

            return response()->json(['message' => 'Order placed successfully', 'order_id' => $order->id], 201);
        } catch (\Exception $e) {
            // DB::rollback();
            return response()->json(['error' => 'Order placement failed',$e], 500);
        }
    }

    public function cancelOrder($orderId)
    {
        // Retrieve the order
        $order = Order::findOrFail($orderId);

        if (auth()->user()->id != $order->user_id) {
            return response()->json(['error' => 'Unauthorized'], 200);
        }

        // Check if the order exists
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 200);
        }
        // Main order cancel
        $order->update(['order_status' => 'Cancelled']);
        // Order status updated as cancelled
        // pending code //

        $data['order_id'] = $order->id;
        $data['comment'] = 'Cancelled';
        $data['order_status'] = 'Cancelled';
        $data['updated_by'] = Auth::user()->id;

        if($order->order_mode == 'ONLINE'){ $paymentStatus = 'paid'; }
        $paymentStatus = $paymentStatus??'unpaid';
        $data['payment_status'] = $paymentStatus;
        OrderStatus::create($data);

        // Respond with a success message
        return response()->json(['message' => 'Order cancelled successfully'], 200);
    }


    // show data of type table
    public function showOrder($orderId)
    {
        $order = Order::with(['orderAddress', 'orderDeliveryOption', 'statuses', 'OrderItems.review', 'OrderItems.Product'])->findOrFail($orderId);

        $subtotal = 0;
        $totalbag = 0;
        $offer_discount = 0;
        $coupon_discount = 0;
        $heart_shape = 0;
        $eggless = 0;
        $grand_total = 0;
        foreach ($order->OrderItems as $item) {

            if($item->discount_type=='Percentage'){
                $cal_discount_value=((($item->discount)/100)*($item->price));
            }else{
                $cal_discount_value= $item->discount;
            }

            $subtotal = $subtotal + ($item->price)*($item->qty);
            $totalbag = $totalbag + ($item->price)*($item->qty) + ($cal_discount_value)*($item->qty);
            $offer_discount = $offer_discount + ($cal_discount_value)*($item->qty);
            $coupon_discount = $coupon_discount + ($item->coupon_discount)*($item->qty);
            $heart_shape = $heart_shape + ($item->heart_shape)*($item->qty);
            $eggless = $eggless + ($item->eggless)*($item->qty);

            // round off according requirement
            // $overallRating = $item->review->avg('stars') ?? null;
            // $item->rating = round($overallRating, 2);
            if(!empty($item['product_id'])){
            $item['product_name']=$item['product']['name'];
            // $item['image']=$item['product']['image'];
            }
        }

        $order['total_bag'] = $totalbag;
        $order['subtotal'] = $subtotal;
        $order['offer_discount'] = $offer_discount;
        $order['coupon_discount'] = $coupon_discount;
        $order['heart_shape'] = $heart_shape;
        $order['eggless'] = $eggless;
        $order['grand_total'] = round($totalbag - $offer_discount - $coupon_discount + $heart_shape + $eggless + $order['shipping_rate'], 0);

        return response()->json($order);
    }



    // public function cancel($id)
    // {
    //     $order = Order::findOrFail($id);
    //     $order->update(['order_status'=>'Cancelled']);

    //     $data['order_id'] = $order->id;
    //     $data['comment'] = 'Cancelled';
    //     $data['order_status'] = 'Cancelled';
    //     $data['updated_by'] = Auth::user()->id;

    //     if($order->order_mode == 'ONLINE'){ $paymentStatus = 'paid'; }
    //     $paymentStatus = $paymentStatus??'unpaid';
    //     $data['payment_status'] = $paymentStatus;
    //     OrderStatus::create($data);
    //     return redirect()->route('customer.dashboard')->with('success','Order status updated successfully.');
    // }
}
