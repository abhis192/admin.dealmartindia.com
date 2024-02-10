<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentApiController extends Controller
{
     // show data of PaymentGateway table
   public function list($id=null){
    $paymentgateway=PaymentGateway::whereStatus(1)->get();
    if($paymentgateway){
        $data['payment_gateway']= $paymentgateway;
        $response = [
            'success' => true,
            'message' => 'Payment Gateway',
            'data' => $data,
        ];
        return response()->json($response,200);
   }else{
    $response = [
        'success' => true,
        'message' => 'No Payment Gateway available',
        'data' => '',
    ];

    return response()->json($response,200);
   }

   }
}
