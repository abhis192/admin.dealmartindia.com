<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use Auth;

class AffiliateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer.affiliate.index');
    }

    public function paymentHistory()
    {
        return view('customer.affiliate.payment');
    }

    public function withdrawRequest()
    {
        return view('customer.affiliate.request');
    }
}
