<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Brand;
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
use App\Models\Coupon;
use App\Models\ConfigShipping;
use Auth;
use Hash;
use Session;
use App\Models\Product;
use App\Models\Pincode;
use App\Models\ProductPincode;
use Carbon\carbon;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationEmail;

class FrontendController extends Controller
{
    public function index() {
        $filteredProducts = Product::wherePublished(1)->paginate(9);
        return view('frontend.products', compact('filteredProducts'));
    }

    public function productDetail($slug) {
        $product = Product::whereSlug($slug)->first();
        if ($product) {
            return view('frontend.product-details', compact('product'));
        }
        return view('errors.404');
    }

    public function shopCategory($slug) {
        $category = Category::whereSlug($slug)->first();
        if ($category) {
            $filteredProducts = Product::whereCategoryId($category->id)->wherePublished(1)->paginate(9);
            $categoryId = $category->id;
            return view('frontend.products', compact('filteredProducts','slug','categoryId'));
        }
        return back();
    }

    public function categoryDetail($slug)
    {
        $category = Category::whereSlug($slug)->first();
        if ($category->subCategories->count() > 0) {
            $categories = $category->subCategories;
            return view('frontend.category', compact('categories'));
        }
        return redirect()->route('shopCategory', $slug)->with( ['categories' => $category] );
    }

    public function shopBrand($brandId)
    {
        $brand = Brand::findOrFail($brandId);
        if ($brand) {
            $filteredProducts = Product::wherePublished(1)->whereBrandId($brandId)->paginate(9);
            return view('frontend.products', compact('filteredProducts','brandId'));
        }
        return back();
    }

    public function category()
    {
        $categories = Category::whereStatus(1)->get();
        return view('frontend.category', compact('categories'));
    }

    public function checkPincode(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $pincode = Pincode::wherePincode($data['pincode'])->first();
            if ($pincode) {
                // $pincodeCheck = ProductPincode::whereProductId($data['productId'])->wherePincodeId($pincode->id)->count();
                return response()->json([
                    'success'=>'success'
                ], 200);
            }
            return response()->json([
                'error'=>'not found'
            ], 401);
        }
    }

    public function checkAddress(Request $request)
    {
        if ($request->isMethod('post')) {
            $address = UserAddress::findOrFail($request->get('addressId'));

            $pincode = Pincode::wherePincode($address->pincode)->first();
            if ($pincode) {
                if (Auth::user()) {
                    $cartItems = Cart::whereUserId(Auth::user()->id)->get();
                } else {
                    $cartItems = Cart::whereUserId(session()->getId())->get();
                }
                foreach ($cartItems as $item) {
                    $cartItemsBySellers[$item->product->user->id][] = $item;
                }

                $shipping = ConfigShipping::first();
                $cartSellerCount = count($cartItemsBySellers);

                if ($shipping->free_shipping_status == 1 && $request->get('finalAmt') >= $shipping->min_order_to_ship) {
                    $amt = 0;
                }else{
                    $amt = $cartSellerCount * ($pincode->city->shipping_cost??$shipping->universal_ship_cost);
                }

                return response()->json([
                    'success'=>$amt
                ], 200);
            }
            return response()->json([
                'error'=>'This pincode is not available'
            ], 401);
        }
    }

    public function guestPincode($reqPincode, $reqFinalAmt)
    {
        $pincode = Pincode::wherePincode($reqPincode)->first();

        if ($pincode) {
            if (Auth::user()) {
                $cartItems = Cart::whereUserId(Auth::user()->id)->get();
            } else {
                $cartItems = Cart::whereUserId(session()->getId())->get();
            }
            foreach ($cartItems as $item) {
                $cartItemsBySellers[$item->product->user->id][] = $item;
            }
            $cartSellerCount = count($cartItemsBySellers);
            $shipping = ConfigShipping::first();

            if ($shipping->free_shipping_status == 1 && $reqFinalAmt >= $shipping->min_order_to_ship) {
                $amt = 0;
            }else{
                $amt = $cartSellerCount * ($pincode->city->shipping_cost??$shipping->universal_ship_cost);
            }

            return response()->json([
                'success'=>$amt
            ], 200);
        }
        return response()->json([
            'error'=>'This pincode is not available'
        ], 401);
    }

    public function contactUs(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        $data = $request->all();
        // Contact::create($data);

        // send respond to admin
        Mail::to(configGeneral()->email)->send(new ContactFormMail($data));

        return redirect()->back()->with('success','Thank You ! Your query has been received.');
    }

    public function postReview(Request $request, $productId)
    {
        $request->validate([
            'stars' => 'required',
            'content' => 'required|string',
        ]);

        $data = $request->all();
        $order = Order::whereUserId($data['user_id'])
                        ->whereOrderStatus('Delivered')
                        ->whereHas('orderItems', function ($query) use ($productId) {
                            $query->where('product_id', $productId);
                        })->first();
        if ($order) {
            $data['order_item_id'] = $order->OrderItems[0]->id;
            $data['product_id'] = $productId;
            $data['status'] = 0;

            $review = Review::create($data);
            return redirect()->back()->with('success','Your review added successfully.');
        }
        return redirect()->back()->with('failure','Review only added when your order successfully.');
    }

    public function filter(Request $request)
    {
        if ($request->category === null && count($request->all()) == 2) {
            $filteredProducts = Product::wherePublished(1)->paginate(9);
            if ($request->ajax()) {
                return view('frontend.product_grid', compact('filteredProducts'))->render();
            }
        } else {
            $category = $request->input('category');
            $brands = $request->input('brands', []);
            $colors = $request->input('colors', []);
            $sizes = $request->input('sizes', []);
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');
            $hidden_search = $request->input('hidden_search');
            $sortBy = $request->input('SortBy');

            // Start with the base query
            $query = Product::wherePublished(1);

            // Apply category filter if provided
            if ($category) {
                $query->where('category_id', $category);
            }

            // Apply brand filter if provided
            if (!empty($brands)) {
                $query->whereIn('brand_id', $brands);
            }

            // Apply attribute filters for colors and sizes
            if (!empty($colors)) {
                $this->applyAttributeFilter($query, 2, $colors);
            }

            if (!empty($sizes)) {
                $this->applyAttributeFilter($query, 1, $sizes);
            }

            if (!empty($hidden_search)) {
                $query->where('name', 'like', "%{$hidden_search}%")
                      ->orWhere('sku', 'like', "%{$hidden_search}%")
                      ->orWhere('slug', 'like', "%{$hidden_search}%");
            }

            if ($minPrice !== null) {
                $query->where(function ($q) use ($minPrice) {
                    $q->where('sale_price', '>=', $minPrice)
                      ->orWhere('regular_price', '>=', $minPrice);
                });
            }

            if ($maxPrice !== null) {
                $query->where(function ($q) use ($maxPrice) {
                    $q->where('sale_price', '<=', $maxPrice)
                      ->orWhere('regular_price', '<=', $maxPrice);
                });
            }

            // Apply sorting if provided
            if ($sortBy === 'price-ascending') {
                $query->orderBy('sale_price', 'asc')
                      ->orderBy('regular_price', 'asc');
            } elseif ($sortBy === 'price-descending') {
                $query->orderBy('sale_price', 'desc')
                      ->orderBy('regular_price', 'desc');
            } elseif ($sortBy === 'best-selling') {
                $query->orderBy('featured', 'asc');
            } elseif ($sortBy === 'featured') {
                $query->orderBy('featured', 'asc');
            }

            $filteredProducts = $query->paginate(9);
            if ($request->ajax()) {
                return view('frontend.product_grid', compact('filteredProducts'))->render();
            }
        }
        return view('frontend.products', compact('filteredProducts'));
    }

    private function applyAttributeFilter($query, $attributeId, $values)
    {
        $query->whereHas('attributes', function ($q) use ($attributeId, $values) {
            $q->where('attribute_id', $attributeId)->whereIn('attribute_values_id', $values);
        });
    }

    public function searchHeader(Request $request)
    {
        $searchTerm = $request->input('search');
        $filteredProducts = Product::where('name', 'like', "%{$searchTerm}%")
            ->orWhere('sku', 'like', "%{$searchTerm}%")
            ->orWhere('slug', 'like', "%{$searchTerm}%")
            ->paginate(9);

        return view('frontend.products', compact('filteredProducts', 'searchTerm'));
    }

    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon');
        $cartAmount = Cart::cartAmount();
        $cartItems = Cart::cartItems();
        $cartCount = Cart::cartItems()->count();

        $coupon = Coupon::where('code', $couponCode)
                    ->where('status', 1) // Filter by status == 1
                    ->where('use', '>', 0) // Filter by use > 0
                    ->where('start_date', '<=', now()) // Filter by use > 0
                    ->where('end_date', '>=', now()) // Filter by use > 0
                    ->where('min_price', '<=', $cartAmount['amount'])// Filter by use > 0
                    ->first();

        if($coupon){
            // product based coupon check
            if($coupon->product_based == 0){
                if ($coupon->type == "fixed") {
                    if ($coupon->discount < $cartAmount['amount']) {
                        $discountAmount = $coupon->discount; // Fixed
                    }
                } else {
                    $discountAmount = $cartAmount['amount'] * ($coupon->discount/100); // Percentage
                }

                $partAmount = $discountAmount / $cartCount;
                $discountAmount = [];
                for ($i = 1; $i <= $cartCount; $i++) {
                    $discountAmount[] = $partAmount;
                }
            } else {
                foreach ($cartItems as $key => $item) {
                    $couponCategories = explode(',', $coupon->category_id);
                    $couponProducts = explode(',', $coupon->product_id);

                    // allow all categories
                    if (in_array('all', $couponCategories)) {
                        if (in_array('all', $couponProducts)) { // all products
                            if ($coupon->min_price <= $item->product->sale_price??$item->product->regular_price && $coupon->max_price >= $item->product->sale_price??$item->product->regular_price) {
                                if ($coupon->type == "fixed") {
                                    if ($coupon->discount < $cartAmount['amount']) {
                                        $discountAmount[$key] = $coupon->discount; // Fixed
                                    }
                                } else {
                                    $discountAmount[$key] = $item->product->sale_price??$item->product->regular_price * ($coupon->discount/100); // Percentage
                                }
                            } else {
                                $discountAmount[$key] = 0;
                            }
                        } else { //selected products
                            if (in_array($item->product_id, $couponProducts)) {
                                if ($coupon->min_price <= $item->product->sale_price??$item->product->regular_price && $coupon->max_price >= $item->product->sale_price??$item->product->regular_price) {
                                    if ($coupon->type == "fixed") {
                                        if ($coupon->discount < $cartAmount['amount']) {
                                            $discountAmount[$key] = $coupon->discount; // Fixed
                                        }
                                    } else {
                                        $discountAmount[$key] = $item->product->sale_price??$item->product->regular_price * ($coupon->discount/100); // Percentage
                                    }
                                } else {
                                    $discountAmount[$key] = 0;
                                }
                            } else {
                                $discountAmount[$key] = 0;
                            }
                        }
                    } else { // selected categories
                        if (in_array($item->product->category_id, $couponCategories)) {
                            if (in_array('all', $couponProducts)) { // all products
                                if ($coupon->min_price <= $item->product->sale_price??$item->product->regular_price && $coupon->max_price >= $item->product->sale_price??$item->product->regular_price) {
                                    if ($coupon->type == "fixed") {
                                        if ($coupon->discount < $cartAmount['amount']) {
                                            $discountAmount[$key] = $coupon->discount; // Fixed
                                        }
                                    } else {
                                        $discountAmount[$key] = $item->product->sale_price??$item->product->regular_price * ($coupon->discount/100); // Percentage
                                    }
                                } else {
                                    $discountAmount[$key] = 0;
                                }
                            } else { //selected products
                                if (in_array($item->product_id, $couponProducts)) {
                                    if ($coupon->min_price <= $item->product->sale_price??$item->product->regular_price && $coupon->max_price >= $item->product->sale_price??$item->product->regular_price) {
                                        if ($coupon->type == "fixed") {
                                            if ($coupon->discount < $cartAmount['amount']) {
                                                $discountAmount[$key] = $coupon->discount; // Fixed
                                            }
                                        } else {
                                            $discountAmount[$key] = $item->product->sale_price??$item->product->regular_price * ($coupon->discount/100); // Percentage
                                        }
                                    } else {
                                        $discountAmount[$key] = 0;
                                    }
                                } else {
                                    $discountAmount[$key] = 0;
                                }
                            }
                        } else {
                            $discountAmount[$key] = 0;
                        }
                    }
                }
            }

            $filteredArray = array_filter($discountAmount, function($value) {
                return $value !== 0;
            });
            if (count($filteredArray) === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Coupon not available for this product.',
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Coupon applied successfully!',
                    'discount' => $discountAmount,
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid coupon code.',
        ]);
    }

































    public function newsletter(Request $req) {
        if (Newsletter::whereEmail($req->get('email'))->count() < 1) {
            Newsletter::create($req->all());
            return redirect(url()->previous().'#newsletter')->with('success','Newsletter subscribed successfully.');
        }
        return redirect(url()->previous().'#newsletter')->with('failure','Newsletter already subscribed.');
    }

    public function cartAdd($id) {
        if (Auth::user()) {
            $cartCount = Cart::whereUserId(Auth::user()->id)->whereProductId($id)->count();
            if ($cartCount == 0) {
                $data['user_id'] = Auth::user()->id;
                $data['product_id'] = $id;
                $data['qty'] = 1;

                Cart::create($data);
                return redirect()->back()->with('success','Product added to your Cart.');
            } else {
                return redirect()->back()->with('error','Product already added to your Cart.');
            }
        } else {
            $cartCount = Cart::whereUserId(session()->getId())->whereProductId($id)->count();
            if ($cartCount == 0) {
                $data['user_id'] = session()->getId();
                $data['product_id'] = $id;
                $data['qty'] = 1;

                Cart::create($data);
                return redirect()->back()->with('success','Product added to your Cart.');
            } else {
                return redirect()->back()->with('error','Product already added to your Cart.');
            }
        }
    }

    public function addToCart(Request $request)
    {
        if ($request->isMethod('post')) {
            $reqData = $request->all();

            if (Auth::user()) {
                $cartProduct = Cart::whereUserId(Auth::user()->id)->whereProductId($reqData['id'])->get();
                $data['user_id'] = Auth::user()->id;
            } else {
                $cartProduct = Cart::whereUserId(session()->getId())->whereProductId($reqData['id'])->get();
                $data['user_id'] = session()->getId();
            }

            if ($cartProduct->count() == 0) {
                $data['product_id'] = $reqData['id'];
                $data['qty'] = $reqData['qty'];
                $cart = Cart::create($data);

                if (isset($reqData['attribute'])) {
                    foreach ($reqData['attribute'] as $key => $attribute) {
                        $cartData['cart_id'] = $cart->id;
                        $cartData['name'] = $attribute['key'];
                        $cartData['value'] = $attribute['value'];
                        CartAttribute::create($cartData);
                    }
                }
                return response()->json([
                    'success'=>'Product added to your Cart'
                ], 200);
            } else {
                return response()->json([
                    'error'=>'Product already added to your Cart'
                ], 401);
            }
        }
    }

    public function cartBuy(Request $request, $id) {
        if (Auth::user()) {
            $cartProduct = Cart::whereUserId(Auth::user()->id)->whereProductId($id)->get();
            $data['user_id'] = Auth::user()->id;
        } else {
            $cartProduct = Cart::whereUserId(session()->getId())->whereProductId($id)->get();
            $data['user_id'] = session()->getId();
        }

        if ($cartProduct->count() == 0) {
            $data['product_id'] = $id;
            $data['qty'] = $request->get('quantity');
            $cart = Cart::create($data);

            if ($request->get('attribute')) {
                foreach ($request->get('attribute') as $key => $attribute) {
                    $cartData['cart_id'] = $cart->id;
                    $cartData['name'] = $key;
                    $cartData['value'] = $attribute;
                    CartAttribute::create($cartData);
                }
            }
        } else {
            $cartProduct->first()->update(['qty'=>$request->get('quantity')]);
        }
        return redirect()->route('cart')->with('success','Product added to your Cart.');
    }

    public function cart() {
        if (Auth::user()) {
            Cart::removeDuplicateItems(Auth::user()->id);
            $cartItems = Cart::whereUserId(Auth::user()->id)->get();
        } else {
            Cart::removeDuplicateItems(session()->getId());
            $cartItems = Cart::whereUserId(session()->getId())->get();
        }
        $cartAmount = Cart::cartAmount();
        return view('frontend.cart', compact('cartAmount','cartItems'));
    }

    public function checkout() {
        $cartAmount = Cart::cartAmount();
        if ($cartAmount == 0) {
            return redirect()->route('cart')->with('failure','Add any Product to cart first.');
        }
        if (Auth::user()) {
            $cartItems = Cart::whereUserId(Auth::user()->id)->get();
            $address = UserAddress::whereUserId(Auth::user()->id)->get();
        } else {
            $cartItems = Cart::whereUserId(session()->getId())->get();
            $address = UserAddress::whereUserId(session()->getId())->get();
        }
        return view('frontend.checkout', compact('cartAmount','cartItems','address'));
    }

    public function payment(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $cartAmount = Cart::cartAmount();
            if ($cartAmount == 0) {
                return redirect()->route('cart')->with('failure','Add any Product to cart first.');
            }
            if (Auth::user()) {
                $cartItems = Cart::whereUserId(Auth::user()->id)->get();
            } else {
                $cartItems = Cart::whereUserId(session()->getId())->get();
                $userAddressData = $data;
                $userAddressData['user_id'] = session()->getId();
                $user_address = UserAddress::create($userAddressData);
                $user_address_id = $user_address->id;
                $data['user_address_id'] = $user_address->id;
            }
            return view('frontend.payment', compact('cartAmount','cartItems','data'));
        } else {
            return redirect('/checkout');
        }
    }

    public function cartRemove($id) {
        Cart::findOrFail($id)->delete();
        return redirect()->route('cart')->with('success','Removed from cart successfully.');
    }

    public function cartItemUpdate(Request $request) {
        if ($request->isMethod('post')) {
            $data['qty'] = $request->get('qty');

            $cart = Cart::findOrFail($request->get('cartId'));
            if ($cart) {
                $cart->update($data);
                $cartAmount = Cart::cartAmount();
                return response()->json([
                    'success'=>'success',
                    'cartAmount'=>$cartAmount
                ], 200);
            }
            return response()->json([
                'error'=>'not found'
            ], 401);
        }
    }

    public function cartProdItem(Request $request)
    {
        if ($request->isMethod('post')) {
            $cartItem = Cart::findOrFail($request->get('cartId'));
            if ($cartItem) {
                $pricing = cartPrice($cartItem);
                return response()->json([
                    'success'=>'success',
                    'pricing'=>$pricing
                ], 200);
            }
            return response()->json([
                'error'=>'not found'
            ], 401);
        }
    }

    public function addressStore(Request $request) {
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
        $data = $request->all();

        $data['default'] = 0;
        if (!empty($request->default)) {
            $data['default'] = 1;
        }

        if (Auth::user()) {
            $data['user_id'] = Auth::user()->id;
        } else {
            $data['user_id'] = session()->getId();
        }

        // Setting default
        if ($data['default'] == 1) {
            $otherAddresses = UserAddress::whereUserId($data['user_id'])->get();
            $otherAddresses->each->update(['default'=>0]);
        }

        UserAddress::create($data);
        return redirect()->back()->with('success','Address added successfully.');
    }

    public function addressUpdate(Request $request, $id)
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
            $otherAddresses = UserAddress::whereUserId($data['user_id'])->get();
            $otherAddresses->each->update(['default'=>0]);
            $data['default'] = 1;
        }

        $address->update($data);
        return redirect()->back()->with('success','Address updated successfully.');
    }

    public function placeOrder(Request $request)
    {
        if ($request->get('payment') == "COD") {
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
            $coupon_discount = explode(',',$request->get('coupon_discount'));
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
                    $orderItem->coupon_discount = $coupon_discount[$key]??0.0;
                    $orderItem->save();
                    $tax = $tax + $orderItem->qty * $orderItem->tax;

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

            // start email trigger
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

            // cleaning process
            $cartItems->each->delete();
            if (!Auth::user()) {
                $address->delete();
            }

            return response()->json([
                'success'=>'Order placed successfully'
            ], 200);
        } else {
            return response()->json([
                'error'=>'COD not available.'
            ], 400);
        }
    }

















































    public function searchAmenityFilter($id, $search)
    {
        try {
            $ifCity = City::whereName($search)->pluck('country_id')->first();
            $requests['city'] = [$ifCity];
            if (empty($ifCity)) {
                $ifCity = Country::whereName($search)->pluck('id')->first();
            }
            $cities = City::whereCountryId($ifCity)->get();
            $activities = Activity::whereStatus(1)->get();
            $amenities = Amenity::whereStatus(1)->get();
            $categories = Category::whereStatus(1)->get();
            $requests['amenity'] = [$id];

            $packages = [];
            if ($search) {
                $cityArray = $amenityArray = [];
                // CITY
                $cityId = City::whereName($search)->pluck('id')->first();
                $cityTemp = Package::whereStatus(1)->whereCityId($cityId)->pluck('id')->toArray();
                if(!empty($cityTemp)) {
                    foreach ($cityTemp as $index => $value) {
                        $cityArray[] = $value;
                    }
                }
                $tours[] = $cityArray;

                // AMENITY
                $amenityTemp = PackageAmenity::whereAmenityId($id)->pluck('package_id')->toArray();
                if(!empty($amenityTemp)) {
                    foreach ($amenityTemp as $index => $value) {
                        $amenityArray[] = $value;
                    }
                }
                $tours[]=$amenityArray;

                $toursArray = array_chunk($tours,1,1);
                $toursCount = count($toursArray);

                if($toursCount == 1){
                    $result = array_intersect($tours[0]);
                }elseif($toursCount == 2){
                    $result = array_intersect($tours[0],$tours[1]);
                }elseif($toursCount == 3){
                    $result = array_intersect($tours[0],$tours[1],$tours[2]);
                }elseif($toursCount == 4){
                    $result = array_intersect($tours[0],$tours[1],$tours[2],$tours[3]);
                }elseif($toursCount == 5){
                    $result = array_intersect($tours[0],$tours[1],$tours[2],$tours[3],$tours[4]);
                }elseif($toursCount == 6){
                    $result = array_intersect($tours[0],$tours[1],$tours[2],$tours[3],$tours[4],$tours[5]);
                }

                if (!empty($result)) {
                    $packages = Package::findOrFail($result);
                } else {
                    $packages = Package::whereStatus(2)->get();
                }
            }
            return view('frontend.tour-search', compact('packages','requests','search','cities','activities','amenities','categories'));
        } catch(\Exception $e){
            // dd($e->getMessage());
            $packages = Package::whereStatus(2)->get();
            return view('frontend.tour', compact('packages','requests','search','cities','activities','amenities','categories'));
        }
    }

    public function searchFilter(Request $request){
        try {
            $requests = $request->all();
            $search = '';
            // Filter start

            $countryArray = $categoryArray = $activityArray = $amenityArray = [];
            if ($request->country) {
                foreach ($request->country as $key => $countryId) {
                    $countryTemp = Package::whereStatus(1)
                            ->WhereHas('city.country', function($q) use($countryId) {
                                $q->whereId($countryId);
                            })->pluck('id')->toArray();
                    if(!empty($countryTemp)) {
                        foreach ($countryTemp as $index => $value) {
                            $countryArray[] = $value;
                        }
                    }
                }
                $tours[] = $countryArray;
            }

            if ($request->range) {
                $range = explode(';',$request->range);
                $rangeArray = Package::whereStatus(1)->whereBetween('adult_price',[$range[0],$range[1]])->pluck('id')->toArray();
                $tours[]=$rangeArray;
            }

            if ($request->category) {
                foreach ($request->category as $key => $categoryId) {
                    $categoryTemp = Package::whereStatus(1)->whereCategoryId($categoryId)->pluck('id')->toArray();
                    if(!empty($categoryTemp)) {
                        foreach ($categoryTemp as $index => $value) {
                            $categoryArray[] = $value;
                        }
                    }
                }
                $tours[]=$categoryArray;
            }

            if ($request->activity) {
                foreach ($request->activity as $key => $activityId) {
                    $activityTemp = Package::whereStatus(1)->whereActivityId($activityId)->pluck('id')->toArray();
                    if(!empty($activityTemp)) {
                        foreach ($activityTemp as $index => $value) {
                            $activityArray[] = $value;
                        }
                    }
                }
                $tours[]=$activityArray;
            }

            if ($request->amenity) {
                foreach ($request->amenity as $key => $amenityId) {
                    $amenityTemp = PackageAmenity::whereAmenityId($amenityId)->pluck('package_id')->toArray();
                    if(!empty($amenityTemp)) {
                        foreach ($amenityTemp as $index => $value) {
                            $amenityArray[] = $value;
                        }
                    }
                }
                $tours[]=$amenityArray;
            }

            $toursArray = array_chunk($tours,1,1);
            $toursCount = count($toursArray);

            if($toursCount == 1){
                $result = array_intersect($tours[0]);
            }elseif($toursCount == 2){
                $result = array_intersect($tours[0],$tours[1]);
            }elseif($toursCount == 3){
                $result = array_intersect($tours[0],$tours[1],$tours[2]);
            }elseif($toursCount == 4){
                $result = array_intersect($tours[0],$tours[1],$tours[2],$tours[3]);
            }elseif($toursCount == 5){
                $result = array_intersect($tours[0],$tours[1],$tours[2],$tours[3],$tours[4]);
            }elseif($toursCount == 6){
                $result = array_intersect($tours[0],$tours[1],$tours[2],$tours[3],$tours[4],$tours[5]);
            }

            if (!empty($result)) {
                $packages = Package::findOrFail($result);
            } else {
                $packages = Package::whereStatus(2)->get();
            }
            // Filter ends

            $countryList = Country::whereStatus(1)->get();
            $activities = Activity::whereStatus(1)->get();
            $amenities = Amenity::whereStatus(1)->get();
            $categories = Category::whereStatus(1)->get();
            return view('frontend.tour', compact('packages','requests','search','countryList','activities','amenities','categories'));
        } catch(\Exception $e){
            // dd($e->getMessage());
            $packages = Package::whereStatus(2)->get();
            return view('frontend.tour', compact('packages','requests','search','countryList','activities','amenities','categories'));
        }
    }

    // city popup filter
    public function searchCityLocationFilter($id, Request $request){
        try {
            $requests = $request->all();
            // Filter start

            $cityArray = $categoryArray = $activityArray = $amenityArray = [];
            if ($id) {
                $cityTemp = Package::whereStatus(1)->whereCityId($id)->pluck('id')->toArray();
                if(!empty($cityTemp)) {
                    foreach ($cityTemp as $index => $value) {
                        $cityArray[] = $value;
                    }
                }
                $tours[] = $cityArray;
            }

            if ($request->range) {
                $range = explode(';',$request->range);
                $rangeArray = Package::whereStatus(1)->whereBetween('adult_price',[$range[0],$range[1]])->pluck('id')->toArray();
                $tours[]=$rangeArray;
            }

            if ($request->category) {
                $reqCategory = explode(',',$request->category);
                foreach ($reqCategory as $key => $categoryId) {
                    $categoryTemp = Package::whereStatus(1)->whereCategoryId($categoryId)->pluck('id')->toArray();
                    if(!empty($categoryTemp)) {
                        foreach ($categoryTemp as $index => $value) {
                            $categoryArray[] = $value;
                        }
                    }
                }
                $tours[]=$categoryArray;
            }

            if ($request->activity) {
                $reqActivity = explode(',',$request->activity);
                foreach ($reqActivity as $key => $activityId) {
                    $activityTemp = Package::whereStatus(1)->whereActivityId($activityId)->pluck('id')->toArray();
                    if(!empty($activityTemp)) {
                        foreach ($activityTemp as $index => $value) {
                            $activityArray[] = $value;
                        }
                    }
                }
                $tours[]=$activityArray;
            }

            if ($request->amenity) {
                $reqAmenity = explode(',',$request->amenity);
                foreach ($reqAmenity as $key => $amenityId) {
                    $amenityTemp = PackageAmenity::whereAmenityId($amenityId)->pluck('package_id')->toArray();
                    if(!empty($amenityTemp)) {
                        foreach ($amenityTemp as $index => $value) {
                            $amenityArray[] = $value;
                        }
                    }
                }
                $tours[]=$amenityArray;
            }

            $toursArray = array_chunk($tours,1,1);
            $toursCount = count($toursArray);

            if($toursCount == 1){
                $result = array_intersect($tours[0]);
            }elseif($toursCount == 2){
                $result = array_intersect($tours[0],$tours[1]);
            }elseif($toursCount == 3){
                $result = array_intersect($tours[0],$tours[1],$tours[2]);
            }elseif($toursCount == 4){
                $result = array_intersect($tours[0],$tours[1],$tours[2],$tours[3]);
            }elseif($toursCount == 5){
                $result = array_intersect($tours[0],$tours[1],$tours[2],$tours[3],$tours[4]);
            }elseif($toursCount == 6){
                $result = array_intersect($tours[0],$tours[1],$tours[2],$tours[3],$tours[4],$tours[5]);
            }

            if (!empty($result)) {
                $packages = Package::findOrFail($result);
            } else {
                $packages = Package::whereStatus(2)->get();
            }
            // Filter ends

            foreach ($packages as $key => $package) {
                $packages[$key]['name'] = dynamicLang(\Illuminate\Support\Str::limit($package->name ?? '',25,' ...'));
                $packages[$key]['rating'] = $package->rating;
                $packages[$key]['currency_symbol'] = Session::get('currency_symbol')??'₹';
                $packages[$key]['adult_price'] = switchCurrency($package->adult_price);
                $packages[$key]['new_price'] = switchCurrency($package->adult_price-($package->adult_price*$package->discount)/100);
                $packages[$key]['category'] = $package->category;
                $packages[$key]['reviews_count'] = $package->reviews;

                if(Auth::user()){
                    if(Auth::user()->wishlist->count() > 0){
                        foreach (Auth::user()->wishlist as $key => $wishlist) {
                            if ($wishlist->package_id == $package->id) {
                                $packages[$key]['wishlist'] = 'added';
                            }else{
                                $packages[$key]['wishlist'] = 'not_added';
                            }
                        }
                    }else{
                        $packages[$key]['wishlist'] = 'not_added';
                    }
                }else{
                    $packages[$key]['wishlist'] = 'not_added';
                }
            }
            return response()->json([
                'status'=>'ok',
                'message'=>'success',
                'packages'=> $packages
            ]);
        } catch(\Exception $e){
            dd($e->getMessage());
        }
    }

    // done
    public function searchCountryLocationFilter($id, Request $request){
        try {
            $requests = $request->all();
            // Filter start

            $countryArray = $categoryArray = $activityArray = $amenityArray = [];
            if ($id) {
                $countryTemp = Package::whereStatus(1)
                            ->WhereHas('city.country', function($q) use($id) {
                                $q->whereId($id);
                            })->pluck('id')->toArray();
                if(!empty($countryTemp)) {
                    foreach ($countryTemp as $index => $value) {
                        $countryArray[] = $value;
                    }
                }
                $tours[] = $countryArray;
            }

            if ($request->range) {
                $range = explode(';',$request->range);
                $rangeArray = Package::whereStatus(1)->whereBetween('adult_price',[$range[0],$range[1]])->pluck('id')->toArray();
                $tours[]=$rangeArray;
            }

            if ($request->category) {
                $reqCategory = explode(',',$request->category);
                foreach ($reqCategory as $key => $categoryId) {
                    $categoryTemp = Package::whereStatus(1)->whereCategoryId($categoryId)->pluck('id')->toArray();
                    if(!empty($categoryTemp)) {
                        foreach ($categoryTemp as $index => $value) {
                            $categoryArray[] = $value;
                        }
                    }
                }
                $tours[]=$categoryArray;
            }

            if ($request->activity) {
                $reqActivity = explode(',',$request->activity);
                foreach ($reqActivity as $key => $activityId) {
                    $activityTemp = Package::whereStatus(1)->whereActivityId($activityId)->pluck('id')->toArray();
                    if(!empty($activityTemp)) {
                        foreach ($activityTemp as $index => $value) {
                            $activityArray[] = $value;
                        }
                    }
                }
                $tours[]=$activityArray;
            }

            if ($request->amenity) {
                $reqAmenity = explode(',',$request->amenity);
                foreach ($reqAmenity as $key => $amenityId) {
                    $amenityTemp = PackageAmenity::whereAmenityId($amenityId)->pluck('package_id')->toArray();
                    if(!empty($amenityTemp)) {
                        foreach ($amenityTemp as $index => $value) {
                            $amenityArray[] = $value;
                        }
                    }
                }
                $tours[]=$amenityArray;
            }

            $toursArray = array_chunk($tours,1,1);
            $toursCount = count($toursArray);

            if($toursCount == 1){
                $result = array_intersect($tours[0]);
            }elseif($toursCount == 2){
                $result = array_intersect($tours[0],$tours[1]);
            }elseif($toursCount == 3){
                $result = array_intersect($tours[0],$tours[1],$tours[2]);
            }elseif($toursCount == 4){
                $result = array_intersect($tours[0],$tours[1],$tours[2],$tours[3]);
            }elseif($toursCount == 5){
                $result = array_intersect($tours[0],$tours[1],$tours[2],$tours[3],$tours[4]);
            }elseif($toursCount == 6){
                $result = array_intersect($tours[0],$tours[1],$tours[2],$tours[3],$tours[4],$tours[5]);
            }

            if (!empty($result)) {
                $packages = Package::findOrFail($result);
            } else {
                $packages = Package::whereStatus(2)->get();
            }
            // Filter ends

            foreach ($packages as $key => $package) {
                $packages[$key]['name'] = dynamicLang(\Illuminate\Support\Str::limit($package->name ?? '',25,' ...'));
                $packages[$key]['rating'] = $package->rating;
                $packages[$key]['currency_symbol'] = Session::get('currency_symbol')??'₹';
                $packages[$key]['adult_price'] = switchCurrency($package->adult_price);
                $packages[$key]['new_price'] = switchCurrency($package->adult_price-($package->adult_price*$package->discount)/100);
                $packages[$key]['category'] = $package->category;
                $packages[$key]['reviews_count'] = $package->reviews;

                if(Auth::user()){
                    if(Auth::user()->wishlist->count() > 0){
                        foreach (Auth::user()->wishlist as $key => $wishlist) {
                            if ($wishlist->package_id == $package->id) {
                                $packages[$key]['wishlist'] = 'added';
                            }else{
                                $packages[$key]['wishlist'] = 'not_added';
                            }
                        }
                    }else{
                        $packages[$key]['wishlist'] = 'not_added';
                    }
                }else{
                    $packages[$key]['wishlist'] = 'not_added';
                }
            }
            return response()->json([
                'status'=>'ok',
                'message'=>'success',
                'packages'=> $packages
            ]);
        } catch(\Exception $e){
            dd($e->getMessage());
        }
    }

    public function search(Request $request) {
        try {
            if ($request->method() == 'POST') {
                $search = $request->search;
                $packages = [];
                if ($search) {
                    $exactCityId = City::whereName($search)->pluck('id')->first();
                    if ($exactCityId) {
                        return redirect()->route('search.city',['id' => $exactCityId]);
                    }

                    $exactCountryId = Country::whereName($search)->pluck('id')->first();
                    if ($exactCountryId) {
                        return redirect()->route('search.country',['id' => $exactCountryId]);
                    }

                    return redirect()->route('search.term',['search' => $search]);
                }
            }
            return redirect('/tours');
        } catch(\Exception $e){
            dd($e->getMessage());
            return redirect('/tours');
        }
    }

    public function searchCity($id) {
        $city = City::findOrFail($id);
        $search = $city->name;
        $searchType = 'city';
        $packages = Package::whereStatus(1)->whereCityId($id)->get();
        return view('frontend.tour-location', compact('packages','search','searchType','id'));
    }

    public function searchCityAmenity($id, $aminityIds)
    {
        try{
            $amenityId = explode(',',$aminityIds);
            $packages = Package::whereStatus(1)
                                ->whereCityId($id)
                                ->WhereHas('amenities', function($q) use($amenityId) {
                                    $q->whereIn('amenity_id', $amenityId);
                                })
                                ->with('category')
                                ->withCount('reviews')
                                ->get();

            foreach ($packages as $key => $package) {
                $packages[$key]['name'] = dynamicLang(\Illuminate\Support\Str::limit($package->name ?? '',25,' ...'));
                $packages[$key]['rating'] = $package->rating;
                $packages[$key]['currency_symbol'] = Session::get('currency_symbol')??'₹';
                $packages[$key]['adult_price'] = switchCurrency($package->adult_price);
                $packages[$key]['new_price'] = switchCurrency($package->adult_price-($package->adult_price*$package->discount)/100);

                if(Auth::user()){
                    if(Auth::user()->wishlist->count() > 0){
                        foreach (Auth::user()->wishlist as $key => $wishlist) {
                            if ($wishlist->package_id == $package->id) {
                                $packages[$key]['wishlist'] = 'added';
                            }else{
                                $packages[$key]['wishlist'] = 'not_added';
                            }
                        }
                    }else{
                        $packages[$key]['wishlist'] = 'not_added';
                    }
                }else{
                    $packages[$key]['wishlist'] = 'not_added';
                }
            }

            return response()->json([
                'status'=>'ok',
                'message'=>'success',
                'packages'=> $packages,
                'amenityId'=>$amenityId
            ]);
        } catch(\Exception $e){
            dd($e->getMessage());
        }
    }

    public function searchCountryAmenity($id, $aminityIds)
    {
        try{
            $amenityId = explode(',',$aminityIds);
            $packages = Package::whereStatus(1)
                                ->WhereHas('city.country', function($q) use($id) {
                                    $q->whereId($id);
                                })
                                ->WhereHas('amenities', function($q) use($amenityId) {
                                    $q->whereIn('amenity_id', $amenityId);
                                })
                                ->with('category')
                                ->withCount('reviews')
                                ->get();

            foreach ($packages as $key => $package) {
                $packages[$key]['name'] = dynamicLang(\Illuminate\Support\Str::limit($package->name ?? '',25,' ...'));
                $packages[$key]['rating'] = $package->rating;
                $packages[$key]['currency_symbol'] = Session::get('currency_symbol')??'₹';
                $packages[$key]['adult_price'] = switchCurrency($package->adult_price);
                $packages[$key]['new_price'] = switchCurrency($package->adult_price-($package->adult_price*$package->discount)/100);

                if(Auth::user()){
                    if(Auth::user()->wishlist->count() > 0){
                        foreach (Auth::user()->wishlist as $key => $wishlist) {
                            if ($wishlist->package_id == $package->id) {
                                $packages[$key]['wishlist'] = 'added';
                            }else{
                                $packages[$key]['wishlist'] = 'not_added';
                            }
                        }
                    }else{
                        $packages[$key]['wishlist'] = 'not_added';
                    }
                }else{
                    $packages[$key]['wishlist'] = 'not_added';
                }
            }

            return response()->json([
                'status'=>'ok',
                'message'=>'success',
                'packages'=> $packages,
                'amenityId'=>$amenityId
            ]);
        } catch(\Exception $e){
            dd($e->getMessage());
        }
    }

    public function searchCountry($id) {
        $country = Country::findOrFail($id);
        $search = $country->name;
        $searchType = 'country';
        $packages = Package::whereStatus(1)
                            ->WhereHas('city.country', function($q) use($country) {
                                $q->whereId($country->id);
                            })->get();
        return view('frontend.tour-location', compact('packages','search','searchType','id'));
    }

    public function searchTerm($search) {
        $packages = Package::whereStatus(1)
                            ->where('name', 'like', '%' . request('search') . '%')
                            ->orWhereHas('city', function($q) {
                                $q->where('name', 'like', '%' . request('search') . '%')
                                    ->orWhereHas('country', function($q1) {
                                    $q1->where('name', 'like', '%' . request('search') . '%')
                                       ->whereStatus(1);
                                });
                            })->get();

        $countryList = Country::whereStatus(1)->get();
        $activities = Activity::whereStatus(1)->get();
        $amenities = Amenity::whereStatus(1)->get();
        $categories = Category::whereStatus(1)->get();
        return view('frontend.tour-search', compact('packages','search','countryList','activities','amenities','categories'));
    }

    public function searchCategory($id){
        $category = Category::findOrFail($id);
        $requests['category'] = [$category->id];
        $search = $category->name??'';
        $packages = [];

        if ($search) {
            $packages = Package::whereStatus(1)
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })->get();
        }
        $cities = City::all();
        $activities = Activity::whereStatus(1)->get();
        $amenities = Amenity::whereStatus(1)->get();
        $categories = Category::whereStatus(1)->get();
        return view('frontend.tour-search', compact('packages','search','requests','cities','activities','amenities','categories'));
    }

    public function searchActivity($id){
        $activity = Activity::findOrFail($id);
        $requests['activity'] = [$activity->id];
        $search = $activity->name??'';
        $packages = [];

        if ($search) {
            $packages = Package::whereStatus(1)
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('activity', function($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })->get();
        }
        $cities = City::all();
        $activities = Activity::whereStatus(1)->get();
        $amenities = Amenity::whereStatus(1)->get();
        $categories = Category::whereStatus(1)->get();
        return view('frontend.tour-search', compact('packages','search','requests','cities','activities','amenities','categories'));
    }

    public function searchAmenity($id)
    {
        $amenity = Amenity::findOrFail($id);
        $requests['amenity'] = [$amenity->id];
        $search = $amenity->name??'';

        if ($search) {
            $packages = Package::whereStatus(1)
                    ->where('name', 'like', '%' . $id . '%')
                    ->orWhereHas('amenities', function($q) use ($id) {
                        $q->where('amenity_id', '=' ,$id);
                    })->get();
        }
        $cities = City::all();
        $activities = Activity::whereStatus(1)->get();
        $amenities = Amenity::whereStatus(1)->get();
        $categories = Category::whereStatus(1)->get();
        return view('frontend.tour-search', compact('packages','search','requests','cities','activities','amenities','categories'));
    }

    public function cartEdit($id){
        $cart = Cart::findOrFail($id);
        $tour = Package::findOrFail($cart->package_id);
        return view('frontend.cart-edit', compact('cart','tour'));
    }

    public function cartUpdate(Request $request, $id){
        $request->validate([
            'date' => 'required|date|after:today'
        ]);

        $date = $request['date'];
        $request['date'] = date("Y-m-d", strtotime($date));

        if (array_sum($request->qtyInput) > 0){
            $data['date'] = $request->date;
            $data['qty_adult'] = $request->qtyInput[0];
            $data['qty_child'] = $request->qtyInput[1];
            $data['qty_infant'] = $request->qtyInput[2];

            Cart::whereId($id)->update($data);
            return redirect()->route('cart')->with('success','Cart item updated successfully.');
        } else {
            return redirect()->back()->with('error','Please select atleast one seat.');
        }
    }

    // public function payment(Request $request) {
    //     $data = $request->all();
    //     return view('razorpayView',compact('data'));
    // }

    public function success()
    {
        return view('frontend.success');
    }

    public function reviewSubmit(Request $request)
    {
        $order = Order::whereUserId(Auth::user()->id)->wherePackageId($request->package_id)->whereOrderStatus('Completed')->latest()->first();
        if ($order) {
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;
            $data['order_id'] = $order->id;
            $data['status'] = 0;
            Review::create($data);

            return redirect()->back()->with('success','Review successfully submitted.');
        }
        return redirect()->back();
    }
}
