<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Category;

class TypeController extends Controller
{
    public function categoryByTypeSlug($slug) {
        $type = Type::whereStatus(1)-> whereSlug($slug)->first();

        if($type) {
            $categories = Category::whereTypeId($type->id)->get();
            foreach ($categories as $key => $category) {
                $categories[$key]['image'] = '/storage/category/' . $category->image;
                $categories[$key]['icon'] = '/storage/category/' . $category->icon;
            }
            $data['category_list'] = $categories;

            $response = [
                'success' => true,
                'message' => 'Category list',
                'data' => $data,
            ];
            return response()->json($response,200);
        } else {
            $response = [
                'success' => true,
                'message' => 'Type Not Found',
                'data' => '',
            ];
            return response()->json($response,200);
        }
    }

    public function list() {
        $types = Type::whereStatus(1)-> get();

        foreach ($types as $key => $type) {
            $types[$key]['image'] = '/storage/type/' . $type->image;
            $types[$key]['icon'] = '/storage/type/' . $type->icon;
        }
        $data['types'] = $types;

        $response = [
            'success' => true,
            'message' => 'Type list',
            'data' => $data,
        ];
        return response()->json($response,200);
    }

    public function typeById($id) {

        $categories = Category::whereStatus(1)->whereTypeId($id)->get();

        foreach ($categories as $key => $category) {
            $categories[$key]['image'] = '/storage/category/' . $category->image;
            $categories[$key]['icon'] = '/storage/category/' . $category->icon;
        }
        $data['category_list'] = $categories;

        $response = [
            'success' => true,
            'message' => 'Category list',
            'data' => $data,
        ];
        return response()->json($response,200);
    }
}
