<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Cart;

class CouponController extends Controller
{
   // show data of coupon table
   public function list(){
      $coupons= Coupon::whereStatus(1)
      ->where('use', '>', 0)
      ->where('start_date', '<=', now())
      ->where('end_date', '>=', now())
      ->paginate(10);

       return response()->json($coupons);
   }

   public function applyCoupon(Request $request) {
        $userId = auth()->user()->id;
        $couponCode = $request->get('coupon');
        $cartAmount = Cart::cartAmount($userId);
        $cartItems = Cart::cartItems($userId);
        $cartCount = Cart::cartItems($userId)->count();

        $coupon = Coupon::where('code', $couponCode)
                    ->where('status', 1) // Filter by status == 1
                    ->where('use', '>', 0) // Filter by use > 0
                    ->where('start_date', '<=', now()) // Filter by use > 0
                    ->where('end_date', '>=', now()) // Filter by use > 0
                    ->where('min_price', '<=', $cartAmount??0)// Filter by use > 0
                    ->first();

        if($coupon){
            // product based coupon check
            if($coupon->product_based == 0){
                if ($coupon->type == "fixed") {
                    if ($coupon->discount < $cartAmount) {
                        $discountAmount = $coupon->discount; // Fixed
                    }
                } else {
                    $discountAmount = $cartAmount * ($coupon->discount/100); // Percentage
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
                            if ($coupon->min_price <= $item->product->final_price && $coupon->max_price >= $item->product->final_price) {
                                if ($coupon->type == "fixed") {
                                    if ($coupon->discount < $cartAmount) {
                                        $discountAmount[$key] = $coupon->discount; // Fixed
                                    }
                                } else {
                                    $discountAmount[$key] = ($item->product->final_price) * ($coupon->discount/100); // Percentage
                                }
                            } else {
                                $discountAmount[$key] = 0;
                            }
                        } else { //selected products
                            if (in_array($item->product_id, $couponProducts)) {
                                if ($coupon->min_price <= $item->product->sale_price??$item->product->regular_price && $coupon->max_price >= $item->product->sale_price??$item->product->regular_price) {
                                    if ($coupon->type == "fixed") {
                                        if ($coupon->discount < $cartAmount) {
                                            $discountAmount[$key] = $coupon->discount; // Fixed
                                        }
                                    } else {
                                        $discountAmount[$key] = ($item->product->sale_price??$item->product->regular_price) * ($coupon->discount/100); // Percentage
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
                                        if ($coupon->discount < $cartAmount) {
                                            $discountAmount[$key] = $coupon->discount; // Fixed
                                        }
                                    } else {
                                        $discountAmount[$key] = ($item->product->sale_price??$item->product->regular_price) * ($coupon->discount/100); // Percentage
                                    }
                                } else {
                                    $discountAmount[$key] = 0;
                                }
                            } else { //selected products
                                if (in_array($item->product_id, $couponProducts)) {
                                    if ($coupon->min_price <= $item->product->sale_price??$item->product->regular_price && $coupon->max_price >= $item->product->sale_price??$item->product->regular_price) {
                                        if ($coupon->type == "fixed") {
                                            if ($coupon->discount < $cartAmount) {
                                                $discountAmount[$key] = $coupon->discount; // Fixed
                                            }
                                        } else {
                                            $discountAmount[$key] = ($item->product->sale_price??$item->product->regular_price) * ($coupon->discount/100); // Percentage
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
}
