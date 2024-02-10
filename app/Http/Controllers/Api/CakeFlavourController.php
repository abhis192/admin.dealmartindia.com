<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CakeFlavour;

class CakeFlavourController extends Controller
{

    public function list() {
        $flavours = CakeFlavour::whereStatus(1)-> get();

        foreach ($flavours as $key => $flavour) {
            $flavours[$key]['image'] = '/storage/flavour/' . $flavour->image;
            $flavours[$key]['icon'] = '/storage/flavour/' . $flavour->icon;
        }
        $data['cake_flavours'] = $flavours;

        $response = [
            'success' => true,
            'data' => $data,
            'message' => ''
        ];

        return response()->json($response,200);
       }
    }
