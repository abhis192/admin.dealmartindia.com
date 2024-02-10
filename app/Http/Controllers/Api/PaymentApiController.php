<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentApiController extends Controller
{
     // show data of PaymentGateway table
   public function list($id=null){
    return $id?PaymentGateway::find($id):PaymentGateway::whereStatus(1)->get();
   }
}
