<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Cart;
use App\Models\ConfigShipping;
use App\Models\ConfigGeneral;
// use App\Models\ConfigCommission;
use App\Models\ConfigPayout;
use App\Models\ConfigRefund;
use Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function wishlist()
    {
        $userWishlistItems = Wishlist::whereUserId(Auth::user()->id)->get();
        return view('frontend.wishlist', compact('userWishlistItems'));
    }

    public function wishlistAdd($productId) {
        $wishlist = Wishlist::whereUserId(Auth::user()->id)->whereProductId($productId)->first();
        if (isset($wishlist)) {
            return redirect()->back()->with('failure','Product already in your wishlist.');
        }
        Wishlist::create(['user_id'=>Auth::user()->id, 'product_id'=>$productId]);
        return redirect()->back()->with('success','Product added to wishlist.');
    }

    public function wishlistRemove($id) {
        $wishlist = Wishlist::findOrFail($id)->delete();
        return redirect()->back()->with('success','Removed from wishlist.');
    }

    public function wishlistMoveToCart($id) {
        $wishlist = Wishlist::findOrFail($id);
        if ($wishlist) {
            $cartCount = Cart::whereUserId($wishlist->user_id)->whereProductId($wishlist->product_id)->count();
            if ($cartCount == 0) {
                $data['user_id'] = $wishlist->user_id;
                $data['product_id'] = $wishlist->product_id;
                $data['qty'] = 1;

                Cart::create($data);
                $wishlist->delete();
            } else {
                return redirect()->route('wishlist')->with('failure','Already added in the Cart.');
            }
        }
        return redirect()->route('wishlist')->with('success','Moved into Cart Successfully.');
    }

    public function shippingConfig()
    {
        $data = ConfigShipping::first();
        return view('admin.shipping-configuration', compact('data'));
    }

    public function shippingConfigUpdate(Request $request, $id)
    {
        $request->validate([
            'min_order_to_ship' => 'required|integer',
            'universal_ship_cost' => 'required|integer',
            'universal_shipping_days' => 'required|integer'
        ]);
        $config = ConfigShipping::findOrFail($id);
        $data = $request->all();

        $data['free_shipping_status'] = 0;
        if (!empty($request->free_shipping_status)) {
            $data['free_shipping_status'] = 1;
        }

        $data['universal_ship_status'] = 0;
        if (!empty($request->universal_ship_status)) {
            $data['universal_ship_status'] = 1;
        }

        $config->update($data);
        return redirect('/admin/shipping-configuration')->with('success','Shipping configuration updated successfully.');
    }

    public function generalConfig()
    {
        $data = ConfigGeneral::first();
        return view('admin.general-configuration', compact('data'));
    }

    public function tax()
    {
        $data = ConfigGeneral::first();
        return view('admin.tax', compact('data'));
    }

    public function generalConfigUpdate(Request $request, $id)
    {
        $request->validate([
            'site_name' => 'nullable|string',
            'site_email' => 'nullable|email',
            'email' => 'nullable|email',
            'mobile' => 'nullable|numeric|digits:10',
            'address' => 'nullable',
            'facebook' => 'nullable',
            'instagram' => 'nullable',
            'twitter' => 'nullable',
            'linkedin' => 'nullable',
            'youtube' => 'nullable',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg',
            'hidden_logo' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg',
            'hidden_icon' => 'required|string',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'tax' => 'numeric|between:0,999999.9'
        ]);
        $config = ConfigGeneral::findOrFail($id);
        $data = $request->all();

        $data['topbar_header'] = 0;
        if (!empty($request->topbar_header)) {
            $data['topbar_header'] = 1;
        }

        $logo_name = $request->hidden_logo;
        $logo = $request->file('logo');
        if($logo != '') {
            if ($config->logo != 'logo.png') {
                File::delete('storage/setting/'. $config->logo);
            }
            $logo_name = rand() . '.' . $logo->getClientOriginalName();
            $logo->move(public_path('storage/setting'), $logo_name);
            $logo_name = $logo_name;
        }

        $icon_name = $request->hidden_icon;
        $icon = $request->file('icon');
        if($icon != '') {
            if ($config->icon != 'icon.png') {
                File::delete('storage/setting/'. $config->icon);
            }
            $icon_name = rand() . '.' . $icon->getClientOriginalName();
            $icon->move(public_path('storage/setting'), $icon_name);
            $icon_name = $icon_name;
        }

        $data['logo'] = $logo_name;
        $data['icon'] = $icon_name;
        $config->update($data);
        return redirect()->back()->with('success','General configuration updated successfully.');
    }

    // public function commissionConfig()
    // {
    //     $data = ConfigCommission::first();
    //     return view('admin.commission-configuration', compact('data'));
    // }

    // public function commissionConfigUpdate(Request $request, $id)
    // {
    //     $request->validate([
    //         'seller_commission' => 'required|integer',
    //         'min_seller_withdraw' => 'required|integer',
    //         'seller_commission_day' => 'required|integer'
    //     ]);
    //     $config = ConfigCommission::findOrFail($id);
    //     $data = $request->all();

    //     $data['seller_commission_status'] = 0;
    //     if (!empty($request->seller_commission_status)) {
    //         $data['seller_commission_status'] = 1;
    //     }

    //     $config->update($data);
    //     return redirect('/admin/commission-configuration')->with('success','Commission configuration updated successfully.');
    // }

    public function refundConfig()
    {
        $data = ConfigRefund::first();
        return view('admin.refund.config', compact('data'));
    }

    public function refundConfigUpdate(Request $request, $id)
    {
        $request->validate([
            'refund_time' => 'required|integer'
        ]);
        $config = ConfigRefund::findOrFail($id);
        $data = $request->all();

        $config->update($data);
        return redirect('/admin/refund-configuration')->with('success','Refund configuration updated successfully.');
    }





















    public function cartMoveToWishlist($id){
        $cart = Cart::findOrFail($id);
        if ($cart){
            $wishlistCount = Wishlist::whereUserId($cart->user_id)->whereProductId($cart->product_id)->count();
            if($wishlistCount != 1){
                $data['user_id'] = $cart->user_id;
                $data['product_id'] = $cart->product_id;
                Wishlist::create($data);
            }
        }
        $cart->delete();
        return redirect()->route('cart')->with('success','Moved to Wishlist Successfully.');
    }



    public function payoutConfig()
    {
        $data = ConfigPayout::first();
        return view('admin.payout-configuration', compact('data'));
    }

    public function payoutConfigUpdate(Request $request, $id)
    {
        $request->validate([
            // 'seller_commission' => 'required|integer',
            // 'min_seller_withdraw' => 'required|integer',
            // 'seller_commission_day' => 'required|integer'
        ]);
        $config = ConfigPayout::findOrFail($id);
        $data = $request->all();

        $data['payout_status'] = 0;
        if (!empty($request->payout_status)) {
            $data['payout_status'] = 1;
        }

        $config->update($data);
        return redirect('/admin/payout-configuration')->with('success','Payout configuration updated successfully.');
    }
}
