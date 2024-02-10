<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\Product;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::whereStatus(1)->whereNull('parent_category_id')->get(); 
        $products = Product::whereNull('deleted_at')->get();
        return view('admin.coupon.create', compact('categories','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:coupons',
            'use' => 'required|integer',
            'type' => 'required|string',
            'product_based' => 'nullable',
            'category_id' => 'nullable',
            'product_id' => 'nullable',
            'discount' => 'required|numeric|min:0',
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'nullable|numeric',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after:start_date',
            'status' => 'required|integer'
        ]);
        $data = $request->all();

        $data['product_based'] = 0;
        if (!empty($request->product_based)) {
            $data['product_based'] = 1;
        }

        if ($data['product_based'] == 1) {
            $request->validate([
                'category_id' => 'required',
                'product_id' => 'required',
                'max_price' => 'required|numeric',
            ]);
            $data['category_id'] = implode(',', $request->get('category_id'));
            $data['product_id'] = implode(',', $request->get('product_id'));
        } else {
            $data['category_id'] = null;
            $data['product_id'] = null;
            $data['max_price'] = null;
        }
        
        Coupon::create($data);
        return redirect('/admin/coupons')->with('success','Coupon created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $categories = Category::whereStatus(1)->whereNull('parent_category_id')->get(); 
        $products = Product::whereNull('deleted_at')->get();
        return view('admin.coupon.edit', compact('coupon','categories','products'));
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
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:coupons,code,'.$id,
            'use' => 'required|integer',
            'type' => 'required|string',
            'product_based' => 'nullable',
            'category_id' => 'nullable',
            'product_id' => 'nullable',
            'discount' => 'required|numeric|min:0',
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'nullable|numeric',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after:start_date',
            'status' => 'required|integer'
        ]);
        $coupon = Coupon::findOrFail($id);
        $data = $request->all();

        $data['product_based'] = 0;
        if (!empty($request->product_based)) {
            $data['product_based'] = 1;
        }

        if ($data['product_based'] == 1) {
            $request->validate([
                'category_id' => 'required',
                'product_id' => 'required',
                'max_price' => 'required|numeric',
            ]);
            $data['category_id'] = implode(',', $request->get('category_id'));
            $data['product_id'] = implode(',', $request->get('product_id'));
        } else {
            $data['category_id'] = null;
            $data['product_id'] = null;
            $data['max_price'] = null;
        }

        $coupon->update($data);
        return redirect('/admin/coupons')->with('success','Coupon updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return redirect('/admin/coupons')->with('success','Coupon deleted successfully.');
    }

    // Acttive
    public function toggle(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        if (!empty($request->status)) {
            $coupon->update(['status'=>1]);
        } else {
            $coupon->update(['status'=>0]);
        }
        return redirect('/admin/coupons')->with('success', 'Coupon has been upadted successfully.');
    }
}
