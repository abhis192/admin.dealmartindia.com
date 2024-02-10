<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Refund;
use App\Models\OrderStatus;
use App\Models\Commission;
use App\Models\Review;
use App\Models\ConfigRefund;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::whereUserId(Auth::user()->id)->paginate(6);
        return view('customer.dashboard', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('customer.order.show', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['order_status'=>'Cancelled']);

        $data['order_id'] = $order->id;
        $data['comment'] = 'Cancelled';
        $data['order_status'] = 'Cancelled';
        $data['updated_by'] = Auth::user()->id;

        if($order->order_mode == 'Online Pay'){ $paymentStatus = 'paid'; }
        $paymentStatus = $paymentStatus??'unpaid';
        $data['payment_status'] = $paymentStatus;
        OrderStatus::create($data);
        return redirect()->route('customer.dashboard')->with('success','Order status updated successfully.');
    }

    public function cancelRefund($id)
    {
        $refund = Refund::findOrfail($id);
        if($refund->whereAdminApproval(0)->count() ) {
            $orderStatus = OrderStatus::whereOrderId($refund->orderItem->order->id)->whereOrderStatus('Refund Initiated')->delete();
            $refund->orderItem->update(['refund_status'=> 0]);
            $refund->orderItem->order->update(['order_status'=>'Delivered']);

            $dataCommission['order_item_id'] = $refund->orderItem->id;
            $dataCommission['seller_id'] = $refund->orderItem->seller_id;
            $dataCommission['order_total'] = $refund->orderItem->qty * $refund->orderItem->price;
            $dataCommission['commission_rate'] = $refund->orderItem->order->commission_rate;
            $dataCommission['admin_commission'] = ($refund->orderItem->order->commission_rate/100)*($refund->orderItem->qty * $refund->orderItem->price);
            $dataCommission['seller_earning'] = ($refund->orderItem->qty * $refund->orderItem->price-($refund->orderItem->order->commission_rate/100)*($refund->orderItem->qty * $refund->orderItem->price));
            $dataCommission['payment_at'] = now()->addDays($refund->orderItem->product->refundable_day??ConfigRefund::first()->refund_time);
            Commission::create($dataCommission);

            // change order item refund status
            $refund->orderItem->update(['refund_status'=>0]);
            
            return redirect()->route('customer.dashboard')->with('success','Order status updated successfully.');
        }
        return redirect()->route('customer.dashboard')->with('success','It"s already approved your refund request.');
    }

    public function review(Request $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $data = $request->all();
        $data['user_id'] = $orderItem->order->user_id;
        $data['order_item_id'] = $id;
        $data['product_id'] = $orderItem->product_id;
        $data['stars'] = $request->get('stars')??1;

        Review::create($data);
        return redirect()->back()->with('success','Review added successfully.');
    }

    public function refund(Request $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->update(['refund_status'=>1]);

        $data = $request->all();
        $data['order_item_id'] = $id;
        $data['product_id'] = $orderItem->product_id;
        $data['seller_approval'] = $orderItem->seller->role_id == 1 ? 1 : 0;
        $data['admin_approval'] = 0;
        $data['status'] = 'unpaid';
        $refund = Refund::create($data);

        $orderItem->order->update(['order_status'=>'Refund Initiated']);
        Commission::whereOrderItemId($id)->delete();

        $dataStatus['order_id'] = $orderItem->order->id;
        $dataStatus['comment'] = 'Refund Initiated';
        $dataStatus['order_status'] = 'Refund Initiated';
        $dataStatus['payment_status'] = $order->status->payment_status??'unpaid';
        $dataStatus['updated_by'] = Auth::user()->id;
        OrderStatus::create($dataStatus);
        return redirect()->back()->with('success','Refund request raised successfully.');
    }
}
