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
            $categories = Category::whereTypeId($type->id)->paginate(10);
            foreach ($categories as $key => $category) {
                $categories[$key]['image'] = '/storage/category/' . $category->image;
                $categories[$key]['icon'] = '/storage/category/' . $category->icon;
            }
            return response()->json($categories);
        } else {
            return response()->json(['error' => 'Type not found'], 404);
        }
    }

    public function list() {
        $types = Type::whereStatus(1)-> paginate(10);

        foreach ($types as $key => $type) {
            $types[$key]['image'] = '/storage/type/' . $type->image;
            $types[$key]['icon'] = '/storage/type/' . $type->icon;
        }
        return response()->json($types);
    }

    public function typeById($id) {

        $categories = Category::whereStatus(1)->whereTypeId($id)->paginate(10);

        foreach ($categories as $key => $category) {
            $categories[$key]['image'] = '/storage/category/' . $category->image;
            $categories[$key]['icon'] = '/storage/category/' . $category->icon;
        }

        return response()->json($categories);
    }
}
