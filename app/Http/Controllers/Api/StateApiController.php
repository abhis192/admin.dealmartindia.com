<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class StateApiController extends Controller
{
    // show data of state table
   public function list($id=null){
    return $id?State::find($id):State::whereStatus(1)->get();
 }
}
