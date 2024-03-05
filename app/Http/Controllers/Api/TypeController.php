<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Category;

class TypeController extends Controller
{
    public function categoryByTypeSlug($slug) {
        $resp = Type::where('status', 1)->whereSlug($slug)->orderBy('order','asc')
        ->with(['categories' => function ($query) {
            $query->where('status', 1)->orderBy('order','asc')
                ->with('subCategories');
        }])
        ->first();

        // $data = $resp;
        // $data = $resp->categories;
        $categories = $resp->categories->toArray();
        $subCategories = [];

foreach ($categories as &$category) {
    $subCategories = array_merge($subCategories, $category['sub_categories']);
    unset($category['sub_categories']); // Remove subcategories from the category

    $category['image'] = '/storage/category/' . $category['image'];
    $category['icon'] = '/storage/category/' . $category['icon'];
}

foreach ($subCategories as &$subCategory) {
    $subCategory['image'] = '/storage/category/' . $subCategory['image'];
    $subCategory['icon'] = '/storage/category/' . $subCategory['icon'];
}

$data['category_list'] = array_merge($categories, $subCategories);
        $response = [
            'success' => true,
            'message' => 'category list',
            'data' => $data,
        ];

        return response()->json($response,200);

    }


    public function list() {
        $types = Type::whereStatus(1)->orderBy('order','asc')-> get();

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

        $resp = Type::where('status', 1)->whereId($id)->orderBy('order','asc')
        ->with(['categories' => function ($query) {
            $query->where('status', 1)
                ->with('subCategories');
        }])
        ->first();

        // $data = $resp;
        // $data = $resp->categories;
        $categories = $resp->categories->toArray();
$subCategories = [];

foreach ($categories as &$category) {
    $subCategories = array_merge($subCategories, $category['sub_categories']);
    unset($category['sub_categories']); // Remove subcategories from the category

    $category['image'] = '/storage/category/' . $category['image'];
    $category['icon'] = '/storage/category/' . $category['icon'];
}

foreach ($subCategories as &$subCategory) {
    $subCategory['image'] = '/storage/category/' . $subCategory['image'];
    $subCategory['icon'] = '/storage/category/' . $subCategory['icon'];
}


$data['category_list'] = array_merge($categories, $subCategories);
        $response = [
            'success' => true,
            'message' => 'category list',
            'data' => $data,
        ];

        return response()->json($response,200);

    }
}
