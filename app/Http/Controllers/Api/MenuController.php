<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Type;

class MenuController extends Controller
{
    // This is the perfect menu
    public function navMenu() {
        $resp = Type::where('status', 1)
        ->with(['categories' => function ($query) {
            $query->where('status', 1)
                ->with('subCategories');
        }])
        ->get();

        $data['nav_menu'] = $resp;

        $response = [
            'success' => true,
            'data' => $data,
            'message' => ''
        ];

        return response()->json($response,200);

    }
}
