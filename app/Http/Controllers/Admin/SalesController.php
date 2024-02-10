<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Commission;
use App\Models\ConfigCommission;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::whereStatus(1)->whereNull('parent_category_id')->get();
        $products = Product::whereNull('deleted_at')
                            ->WhereHas('user', function($q) {
                                $q->whereRoleId(1);
                            })->get();
        return view('admin.sale.inhouse',compact('products','categories'));
    }

    public function sellerIndex()
    {
        $categories = Category::whereStatus(1)->whereNull('parent_category_id')->get();
        $products = Product::whereNull('deleted_at')
                            ->WhereHas('user', function($q) {
                                $q->whereRoleId(2);
                            })->get();
        return view('admin.sale.seller',compact('products','categories'));
    }

    public function commissionHistory()
    {
        $commissions = Commission::whereDate('payment_at', '<=', now())->latest()->get();
        return view('admin.sale.commission', compact('commissions'));
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
}
