<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use Razorpay\Api\Api;
use Session;
use Exception;
use Auth;
use Hash;
use DB;
use App\Models\User;
use App\Models\City;
use App\Models\Country;
use App\Models\Contact;
use App\Models\Category;
use App\Models\Newsletter;
use App\Models\Cart;
use App\Models\CartAttribute;
use App\Models\OrderAttribute;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Review;
use App\Models\UserAddress;
use App\Models\Amenity;
use App\Models\Activity;
use App\Models\OrderAddress;
use App\Models\ConfigCommission;
use App\Models\ConfigShipping;
use App\Models\Product;
use App\Models\Pincode;
use App\Models\ProductPincode;
use Carbon\carbon;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationEmail;


class RazorpayPaymentController extends Controller
{
    public function __construct()
    {
        $razorpay = PaymentGateway::whereName('razorpay')->first();
        $this->key = $razorpay['key'];
        $this->secret = $razorpay['secret'];
    }

    public function index()
    {        
        return view('razorpayView');
    }

    public function store(Request $request)
    {
        $input = $request->all();  
        $api = new Api($this->key, $this->secret);
  
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
  
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            // test
            $user_address_id = $request->get('user_address_id')??null;
        
            if (!$user_address_id) {
                return redirect()->back()->with('failure','Please add your address first.');
            }

            $userAddress = UserAddress::findOrFail($user_address_id);
            $pincode = Pincode::wherePincode($userAddress->pincode)->count();
            if ($pincode < 1) {
                if (!Auth::user()) {
                    $user_address->delete();
                }
                return redirect()->back()->with('failure','Unable to deliver to this address.');
            }

            $address = UserAddress::findOrFail($user_address_id);
            $addressData['label'] = $address->label;
            $addressData['default'] = $address->default;
            $addressData['name'] = $address->name;
            $addressData['email'] = $address->email;
            $addressData['mobile'] = $address->mobile;
            $addressData['country'] = $address->country;
            $addressData['state'] = $address->state;
            $addressData['city'] = $address->city;
            $addressData['pincode'] = $address->pincode;
            $addressData['address'] = $address->address;
            $addressData['landmark'] = $address->landmark;
            $orderAddress = OrderAddress::create($addressData);

            if (Auth::user()) {
                $cartItems = Cart::whereUserId(Auth::user()->id)->get();
            } else {
                $cartItems = Cart::whereUserId(session()->getId())->get();
            }

            // Binding similar users orders
            foreach ($cartItems as $key => $item) {
                $cartItemsBySellers[$item->product->user->id][] = $item;
            }

            $tax = 0;
            foreach ($cartItemsBySellers as $key => $items) {
                $order = new Order();
                $order->order_no = Carbon::now()->format('dmY').'-'.mt_rand(11111,99999).'-'.$item->product->id;
                $order->user_id = $item->user_id;
                $order->order_address_id = $orderAddress->id;
                $order->date = Carbon::now();
                $order->order_status = 'Pending';
                $order->order_mode = $request->get('payment');
                $order->shipping_rate = $request->get('shipping_rate')/count($cartItemsBySellers);
                $order->commission_rate = ConfigCommission::first()->seller_commission;
                $order->save();

                // create order item
                foreach ($items as $key => $item) {
                    $tax_rate = $item->product->category->type->tax??configGeneral()->tax;
                    $item_price = $item->product->sale_price??$item->product->regular_price;
                    
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->seller_id = $item->product->user_id;
                    $orderItem->product_id = $item->product_id;
                    $orderItem->qty = $item->qty;
                    $orderItem->price = $item_price - (($item_price) * $tax_rate/100);
                    $orderItem->tax = $item_price * ($tax_rate/100);
                    $orderItem->discount = 0.00;
                    if($item->product->sale_price) {
                        $orderItem->discount = $item->qty * ($item->product->regular_price - $item->product->sale_price);
                    }
                    $orderItem->coupon_discount = $request->get('coupon_discount')??0.0;
                    $orderItem->save();
                    $tax += $orderItem->qty * $orderItem->tax;

                    if ($item->cartAttributes) {
                        foreach ($item->cartAttributes as $key => $attribute) {
                            $cartAttrData['order_item_id'] = $orderItem->id;
                            $cartAttrData['name'] = $attribute->name;
                            $cartAttrData['value'] = $attribute->value;
                            $orderAttribute  = OrderAttribute::create($cartAttrData);
                        }
                        // remove cart attributes
                        $item->cartAttributes->each->delete();
                    }
                }

                // status pending
                $orderData['order_id'] = $order->id;
                $orderData['comment'] = null;
                $orderData['order_status'] = 'Pending';

                if($request->get('payment') == 'Online Pay'){ $paymentStatus = 'paid'; }
                $paymentStatus = $paymentStatus??'unpaid';

                $orderData['payment_status'] = $paymentStatus;
                OrderStatus::create($orderData);
            }

            // Order successfully created mail trigger point
            $data = [
                'cartItems' => $cartItems->toArray(),
                'sub_total' => $request->get('sub_total'),
                'discount' => $request->get('discount'),
                'shipping' => $request->get('shipping_rate'),
                'address' => $address,
                'order' => $order,
                'tax' => $tax
            ];
            Mail::to($address->email)->send(new OrderConfirmationEmail($data));
            
            // Cleaning process
            $cartItems->each->delete();
            if (!Auth::user()) {
                $address->delete();
            }

            $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
        }
        return redirect()->route('success');
    }



    // public function store(Request $request)
    // {
    //     $input = $request->all();
  
    //     $api = new Api($this->key, $this->secret_key);
  
    //     $payment = $api->payment->fetch($input['razorpay_payment_id']);
  
    //     if(count($input)  && !empty($input['razorpay_payment_id'])) {
    //         try {
    //             $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
    //             if (Auth::user()) {
    //                 $cartItems = Cart::whereUserId(Auth::user()->id)->get();
    //                 if ($request->radio_address) {
    //                     foreach ($cartItems as $key => $item) {
    //                         $orderData['order_no'] = 'ORD'.rand(1,100000);
    //                         $orderData['user_id'] = Auth::user()->id;
    //                         $orderData['package_id'] = $item->package_id;
    //                         $orderData['user_address_id'] = $request->radio_address;
    //                         $orderData['date'] = $item->date;
    //                         $orderData['adult_qty'] = $item->qty_adult;
    //                         $orderData['child_qty'] = $item->qty_child;
    //                         $orderData['infant_qty'] = $item->qty_infant;
    //                         $orderData['price'] = Cart::itemPrice($item);
    //                         $orderData['tax'] = $request->tax??0;
    //                         $orderData['order_status'] = 'In Progress';
    //                         $orderData['razorpay_payment_id'] = $response->id;
    //                         $order = Order::create($orderData);

    //                         $orderStatusData['order_id'] = $order->id;
    //                         $orderStatusData['comment'] = 'Order Placed';
    //                         $orderStatusData['order_status'] = 'In Progress';
    //                         $orderStatus = OrderStatus::create($orderStatusData);
    //                     }
    //                 } else {
    //                     $request->validate([
    //                         'name' => 'required|string|min:2|max:255',
    //                         'email' => 'required|email',
    //                         'mobile' => 'required|string',
    //                         'country' => 'required|string|min:3',
    //                         'city' => 'required|string|min:3',
    //                         'pincode' => 'required|string',
    //                         'address' => 'required|string|min:3'
    //                     ]);

    //                     $addressData['user_id'] = Auth::user()->id;
    //                     $addressData['default'] = 0;
    //                     $addressData['name'] = $request->name;
    //                     $addressData['email'] = $request->email;
    //                     $addressData['mobile'] = $request->mobile;
    //                     $addressData['country'] = $request->country;
    //                     $addressData['city'] = $request->city;
    //                     $addressData['pincode'] = $request->pincode;
    //                     $addressData['address'] = $request->address;
    //                     $userAddress = UserAddress::create($addressData);

    //                     foreach ($cartItems as $key => $item) {
    //                         $orderData['order_no'] = 'ORD'.rand(1,100000);
    //                         $orderData['user_id'] = Auth::user()->id;
    //                         $orderData['package_id'] = $item->package_id;
    //                         $orderData['user_address_id'] = $userAddress->id;
    //                         $orderData['date'] = $item->date;
    //                         $orderData['adult_qty'] = $item->qty_adult;
    //                         $orderData['child_qty'] = $item->qty_child;
    //                         $orderData['infant_qty'] = $item->qty_infant;
    //                         $orderData['price'] = Cart::itemPrice($item);
    //                         $orderData['tax'] = $request->tax??0;
    //                         $orderData['order_status'] = 'In Progress';
    //                         $orderData['razorpay_payment_id'] = $response->id;
    //                         $order = Order::create($orderData);

    //                         $orderStatusData['order_id'] = $order->id;
    //                         $orderStatusData['comment'] = 'Order Placed';
    //                         $orderStatusData['order_status'] = 'In Progress';
    //                         $orderStatus = OrderStatus::create($orderStatusData);
    //                     }
    //                 }
    //                 $email = Auth::user()->email;
    //             } else {
    //                 $request->validate([
    //                     'name' => 'required|string|min:2|max:255',
    //                     'email' => 'required|email',
    //                     'mobile' => 'required|string',
    //                     'name' => 'required|string|min:3',
    //                     'country' => 'required|string|min:3',
    //                     'city' => 'required|string|min:3',
    //                     'pincode' => 'required|string',
    //                     'address' => 'required|string|min:3'
    //                 ]);

    //                 // user existance check
    //                 $emailCheck = User::whereEmail($request->email)->count();
    //                 $mobileCheck = User::whereMobile($request->mobile)->count();
    //                 if($emailCheck != 0){
    //                     return redirect()->route('checkout')->with('failure','Email is already registered. Try login');
    //                 }elseif($mobileCheck != 0){
    //                     return redirect()->route('checkout')->with('failure','Mobile is already registered. Try login');
    //                 }else{
    //                     $userData['name'] = $request->name;
    //                     $userData['email'] = $request->email;
    //                     $userData['mobile'] = $request->mobile;
    //                     $userData['password'] = Hash::make('test1234');
    //                     $user = User::create($userData);

    //                     $addressData['user_id'] = $user->id;
    //                     $addressData['default'] = 0;
    //                     $addressData['name'] = $request->name;
    //                     $addressData['email'] = $request->email;
    //                     $addressData['mobile'] = $request->mobile;
    //                     $addressData['country'] = $request->country;
    //                     $addressData['city'] = $request->city;
    //                     $addressData['pincode'] = $request->pincode;
    //                     $addressData['address'] = $request->address;
    //                     $userAddress = UserAddress::create($addressData);
    //                 }

    //                 $cartItems = Cart::whereUserId(session()->getId())->get();
    //                 foreach ($cartItems as $key => $item) {
    //                     $orderData['order_no'] = 'ORD'.rand(1,100000);
    //                     $orderData['user_id'] = $user->id;
    //                     $orderData['package_id'] = $item->package_id;
    //                     $orderData['user_address_id'] = $userAddress->id;
    //                     $orderData['date'] = $item->date;
    //                     $orderData['adult_qty'] = $item->qty_adult;
    //                     $orderData['child_qty'] = $item->qty_child;
    //                     $orderData['infant_qty'] = $item->qty_infant;
    //                     $orderData['price'] = Cart::itemPrice($item);
    //                     $orderData['tax'] = $request->tax??0;
    //                     $orderData['order_status'] = 'In Progress';
    //                     $orderData['razorpay_payment_id'] = $response->id;
    //                     $order = Order::create($orderData);

    //                     $orderStatusData['order_id'] = $order->id;
    //                     $orderStatusData['comment'] = 'Order Placed';
    //                     $orderStatusData['order_status'] = 'In Progress';
    //                     $orderStatus = OrderStatus::create($orderStatusData);
    //                 }
    //                 $email = $request->email;
    //             }
    //             $cartItems->each->delete();
    //         } catch (Exception $e) {
    //             return redirect()->route('checkout')->with('failure',$e->getMessage());
    //         }
    //     }

    //     // email confirmation 
    //     // email template here
    //     return redirect()->route('success')->with('success','Order Successfull.');
    // }
}
