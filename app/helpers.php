<?php

use Illuminate\Http\Request;
use AmrShawky\LaravelCurrency\Facade\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Models\Role;
use App\Models\ProductPrice;



if(!function_exists('p')){
    function p($data)
    {
        echo "<pre>";
        print_r($data);
        echo "<pre>";

    }
}


if (!function_exists('objFromPost')) {
    function objFromPost($fieldArr = [])
    {
        $request = request();
        $output = new \stdClass;
        if (count($fieldArr)) {
            foreach ($fieldArr as $value) {
                $val = $request->input($value);
                $output->$value = in_array(gettype($val), ['integer', 'double', 'string']) ? trim($val) : $val;
            }
        }
        return $output;
    }
}

function totalCustomers() {
	return App\Models\User::whereroleId(3)->whereNotNull('email_verified_at')->whereNull('deleted_at')->count();
}

function price($id) {

    $getPrice=ProductPrice::where("product_id",$id)->OrderBy('id','ASC')->first();
    if(@$getPrice->discount_value){
        $get_price=(100-round($getPrice->final_price*100/$getPrice->product_price,2));
        $price="<span><span class='product-discountedPrice'>₹".round($getPrice->final_price)."</span><span class='product-strike'>₹".$getPrice->product_price."</span></span><span class='product-discountPercentage'>(".$get_price."% OFF)</span>";
    }else{
        $price="<span><span class='product-discountedPrice'>₹".round(@$getPrice->final_price)."</span></span>";
    }
    return  $price;


}


function switchCurrency($amt) {
	$changeCurr = Session::get('currency')??'INR';
	$currencyObj = Currency::convert()->from('INR')->to($changeCurr)->amount($amt)->round(2)->get();
	return $currencyObj;
}

function dynamicLang($word){
	$selectedLang = App::getLocale()??'en';
	return GoogleTranslate::trans($word, $selectedLang , 'en');
}

function currencies() {
	$currencies = DB::table('currencies')->whereStatus(1)->get();
	return $currencies;
}

function languages() {
	$languages = DB::table('languages')->whereStatus(1)->get();
	return $languages;
}

function configGeneral() {
	return App\Models\ConfigGeneral::first();
}

function configShippingRate() {
	$res = 0;
	$shipping = App\Models\ConfigShipping::first();
	if ($shipping->free_shipping_status == 1) {
		$res = $shipping->min_order_to_ship;
	}
	return $res;
}

function configShippingDays()
{
	$res = 0;
	$shipping = App\Models\ConfigShipping::first();
	if ($shipping) {
		$res = $shipping->universal_shipping_days;
	}
	return $res;
}

function dashboardReviewCount() {
	return App\Models\Review::whereStatus(0)->count();
}

function adminAddress() {
	$add =  App\Models\ConfigGeneral::first();
	return $add->address;
}

function addresses()
{
	return App\Models\UserAddress::all();
}

function states()
{
	return App\Models\State::all();
}

function colors() {
	$color = [];
	$attribute = App\Models\Attribute::whereType('color')->first();
	if (!empty($attribute)) {
		$color = $attribute->attributeValues;
	}
	return $color;
}

function sizes() {
	$size = [];
	$attribute = App\Models\Attribute::whereName('Size')->first();
	if (!empty($attribute)) {
		$size = $attribute->attributeValues;
	}
	return $size;
}

function minSliderAmt()
{
	$res = 10;
	$amt = App\Models\Product::orderBy('sale_price', 'asc')->orderBy('regular_price', 'asc')->first();
	if (($amt->sale_price ?? $amt->regular_price) > $res) {
		$res = $amt->sale_price ?? $amt->regular_price;
	}
	return $res;
}

function maxSliderAmt()
{
	$res = 10000;
	$amt = App\Models\Product::orderBy('regular_price', 'desc')->orderBy('sale_price', 'desc')->first();
	if (($amt->sale_price ?? $amt->regular_price) < $res) {
		$res = $amt->sale_price ?? $amt->regular_price;
	}
	// dd($res);
	return $res;
}

function allTestimonials()
{
	$testimonials = App\Models\Testimonial::whereStatus(1)->get();
	return $testimonials;
}

function allCategories()
{
	$allCategories = App\Models\Category::whereStatus(1)->whereNull('parent_category_id')->orderby('order','ASC')->get();
	return $allCategories;
}

function allBrands()
{
	$allBrands = App\Models\Brand::whereStatus(1)->orderby('order','ASC')->get();
	return $allBrands;
}

function allTypes()
{
	$allTypes = App\Models\Type::whereStatus(1)->orderby('order','ASC')->get();
	return $allTypes;
}

function allBanners()
{
	$allBanners = App\Models\Banner::whereStatus(1)->orderby('created_at','ASC')->get();
	return $allBanners;
}

function allProducts()
{
	return App\Models\Product::wherePublished(1)->orderby('created_at','ASC')->get();
}

function latestProducts()
{
	return App\Models\Product::wherePublished(1)->take(8)->orderby('created_at','DESC')->get();
}

function popularProducts()
{
	return App\Models\Product::wherePublished(1)
								->withCount('orderItems')
								->orderByDesc('order_items_count')
								->take(8)->orderby('created_at','DESC')->get();
}

function allAttributes()
{
	return App\Models\Attribute::whereStatus(1)->orderby('created_at','ASC')->get();
}

function checkProductAttribute($productId, $attributeId)
{
	$attributeCount = App\Models\ProductAttribute::whereProductId($productId)->whereAttributeId($attributeId)->count();
	if ($attributeCount > 0) {
		return true;
	}
	return false;
}

function checkProductValueAttribute($productId, $attributeValueId)
{
	$attributeValueCount = App\Models\ProductAttribute::whereProductId($productId)->whereAttributeValuesId($attributeValueId)->count();
	if ($attributeValueCount > 0) {
		return true;
	}
	return false;
}

function checkEditAttributeValues($attribute, $product)
{
	$style = "style=display:none;";
	$prodAttributeCheck = App\Models\ProductAttribute::whereProductId($product->id)->whereAttributeId($attribute->id)->count();
	if ($prodAttributeCheck > 0) {
		$style = "style=display:block;";
		return $style;
	}
	return $style;
}

function wishlist()
{
	$data = 0;
    if (Auth::user()) {
        $data = DB::table('wishlists')->whereUserId(Auth::user()->id)->count();
    }
    return $data;
}

function cart()
{
	$data = 0;
    if (Auth::user()) {
        $data = DB::table('carts')->whereUserId(Auth::user()->id)->count();
    } else {
        $data = DB::table('carts')->whereUserId(session()->getId())->count();
    }
    return $data;
}

function relatedProducts($productId) {
	$product = App\Models\Product::findOrFail($productId);
	$products = App\Models\Product::whereCategoryId($product->category_id)->orWhere('brand_id', $product->brand_id)->inRandomOrder()->take(5)->get();
	return $products;
}

function checkStatusProgress($order, $name)
{
	$statusResult = "in-process";
	foreach ($order->statuses as $key => $status) {
		if ($status->order_status == $name) {
			$statusResult = "";
		}
	}
	return $statusResult;
}

function checkStatusProgressActive($order, $name)
{
	$statusResult = "";
	foreach ($order->statuses as $key => $status) {
		if ($status->order_status == $name) {
			$statusResult = "active";
		}
	}
	return $statusResult;
}

function checkStatusProgressFade($order, $name)
{
	$statusResult = "";
	foreach ($order->statuses as $key => $status) {
		if ($status->order_status == $name) {
			$statusResult = "bx-fade-right";
		}
	}
	return $statusResult;
}

function checkStatusProgressDate($order, $name){
	$date = '';
	$status = App\Models\OrderStatus::whereOrderId($order->id)->whereOrderStatus($name)->first();
	if ($status) {
		$date = $status->updated_at;
        $formattedDate = \Carbon\Carbon::parse($date)->format('d M Y');
		$formattedTime = \Carbon\Carbon::parse($date)->format('h:i A');


		$date = $formattedDate . ' | ' . $formattedTime;
	}
	return $date;
}


function checkStatusProgressComment($order, $name){
	$comment = '';
	$status = App\Models\OrderStatus::whereOrderId($order->id)->whereOrderStatus($name)->first();
	if ($status) {
		$comment = $status->comment;
        // $formattedDate = \Carbon\Carbon::parse($date)->format('d M Y');
		// $formattedTime = \Carbon\Carbon::parse($date)->format('h:i A');


		// $date = $formattedDate . ' | ' . $formattedTime;
	}
	return $comment;
}

function refundDays() {
	$day = 0;
	$refundDays = App\Models\configRefund::first();
	if ($refundDays) {
		$day = $refundDays->refund_time;
	}
	return $day;
}

function defaultShippingCharges($cartItems, $cartAmount)
{
	$shipping = App\Models\ConfigShipping::first();
	$amt = 0;
	if ($shipping->universal_ship_status == 1) {
		$amt = $shipping->universal_ship_cost;

		foreach ($cartItems as $item) {
            $cartItemsBySellers[$item->product->user->id][] = $item;
        }
        $cartSellerCount = count($cartItemsBySellers);
        $amt = $amt * $cartSellerCount;
	}
	if ($shipping->free_shipping_status == 1 && $cartAmount >= $shipping->min_order_to_ship) {
		$amt = 0;
	}
	return $amt;
}

function reviewable($productId, $userId)
{
	$res = false;
	$order = App\Models\Order::whereOrderStatus('Delivered')
                                ->whereUserId($userId)
                                ->WhereHas('orderItems', function($q) use($productId) {
                                    $q->whereProductId($productId);
                                })
                                ->count();
	if ($order){
		$res = true;

		$review = App\Models\Review::whereProductId($productId)->whereUserId($userId)->count();
		if ($review) {
			$res = false;
		}
	}
	return $res;
}

function orderItemCouponDiscount($orderItems)
{
	$res = 0.00;
	foreach ($orderItems as $key => $item) {
		$res = $res + $item->coupon_discount;
	}
	return asFloat($res);
}

function orderItemDiscount($orderItems)
{
	$res = 0.00;
	foreach ($orderItems as $key => $item) {
		$res = $res + $item->discount;
	}
	return asFloat($res);
}

function orderItemsTax($orderItems)
{
	$res = 0.00;
	foreach ($orderItems as $key => $item) {
		$res = $res + ($item->tax * $item->qty);
	}
	return asFloat($res);
}

function asFloat($amount){
	return number_format(floatval($amount), 2, '.', '');
}

function customerOrderItemTotal($orderItems) {
	$res = 0.0;
	foreach ($orderItems as $key => $item) {
		$res = $res + ($item->qty * ($item->price + $item->tax));
	}
	return asFloat($res + orderItemDiscount($orderItems));
}


function orderSubTotal($orderItems)
{
	$res = 0.00;
	foreach ($orderItems as $key => $item) {
		$res = $res + ($item->qty * $item->price);
	}
	return asFloat($res + orderItemDiscount($orderItems));
}

// function orderSubTotal($orderItems)
// {
// 	$res = 0.00;
// 	foreach ($orderItems as $key => $item) {
// 		$res = $res + ($item->price);
// 	}
// 	return asFloat($res + orderItemDiscount($orderItems));
// }

function orderCouponCodeTotal($orderItems)
{
	$res = 0.00;
	foreach ($orderItems as $key => $item) {
		$res = $res + ($item->coupon_discount);
	}
	return asFloat($res);
}

function orderItemGrandTotal($order)
{
	$res = orderSubTotal($order->orderItems) - orderItemDiscount($order->orderItems) - orderItemCouponDiscount($order->orderItems) + $order->shipping_rate + orderItemsTax($order->orderItems);
	return asFloat($res);
}

function checkCodIsAvailable($cartItems) {
	$res = array();
	foreach ($cartItems as $key => $item) {
		if ($item->product->cash_on_delivery == 1) {
			$res[] = true;
		} else {
			$res[] = false;
		}
	}

	$allTrue = array_reduce($res, function($carry, $item) {
	    return $carry && $item;
	}, true);

	if ($allTrue) {
	    return true;
	} else {
	    return false;
	}
}

function hasPermissionTo($slug, Role $role)
{
    foreach ($role->permissions as $permission) {
        if ($permission->slug == $slug) {
            return true;
        }
    }
    return false;
}

function cartPrice($cartItem)
{
	if ($cartItem->product->pricingRules) {
		$res = $cartItem->product->sale_price??$cartItem->product->regular_price;
		if ($cartItem->product->pricingRules->status === 1) {
			$pricingRules = json_decode($cartItem->product->pricingRules->pricing_rules, true);

			foreach ($pricingRules as $rule) {
	            $minQuantity = intval($rule['min_quantity']);

	            if ($minQuantity <= $cartItem->qty) {
	                $res = $rule['price'];
	            }
	        }
		}
	} else {
		$res = $cartItem->product->sale_price??$cartItem->product->regular_price;
	}
	return asFloat($res);
}

function cartTotalPrice($cartItem) {
	if ($cartItem->product->pricingRules) {
		$res = ($cartItem->product->sale_price??$cartItem->product->regular_price) * ($cartItem->qty);
		if ($cartItem->product->pricingRules->status === 1) {
			$pricingRules = json_decode($cartItem->product->pricingRules->pricing_rules, true);

			foreach ($pricingRules as $rule) {
	            $minQuantity = intval($rule['min_quantity']);

	            if ($minQuantity <= $cartItem->qty) {
	                $res = $rule['price'] * $cartItem->qty;
	            }
	        }
		}
	} else {
		$res = ($cartItem->product->sale_price??$cartItem->product->regular_price) * ($cartItem->qty);
	}
	return asFloat($res);
}

function productConfigKitchenPrice($productId, $index) {
    $kitchenPrice = App\Models\ConfigKitchenPrice::whereProductId($productId)->get();

    if ($kitchenPrice->isNotEmpty() && $index < $kitchenPrice->count()) {
        return $kitchenPrice[$index]->price;
    }

    return null;
}

function productIdDelayCount($productsId) {
	$productIds = json_decode($productsId, true);

    // Fetch products based on the provided IDs
    $products = App\Models\Product::whereIn('id', $productIds)->get();

    $categoryDelays = [];
    
    foreach ($products as $product) {
        // Get the product's categories and their delays
        $categories = $product->categories;

        // Iterate through each category
        foreach ($categories as $category) {
            // Store the delay value for each category
            $categoryDelays[] = $category->category->delay;
        }
    }

    // Find the highest delay value
    $highestDelay = max($categoryDelays);

    return $highestDelay ?? 0;
}

?>
