<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Type;

class CategoryController extends Controller
{
    public function productsByCategorySlug($slug)
    {
        $category = Category::whereStatus(1)->whereSlug($slug)->first();
        if ($category) {
            $productCategories = ProductCategory::whereCategoryId($category->id)
                                ->with('category','products','products.tags','products.prices','products.gallery')
                                ->get();

            foreach ($productCategories as $key => $productCategory) {
                $productCategories[$key]['products']['image'] = '/storage/product/' . $productCategory['products']['image'];

                foreach ($productCategory['products']['gallery'] as $galleryKey => $gallery) {
                    $productCategories[$key]['products']['gallery'][$galleryKey]['image'] = '/storage/product/' . $gallery['image'];
                }
            }
             foreach ($productCategory['products']['gallery'] as $galleryKey => $gallery) {
                    $productCategories[$key]['products']['gallery'][$galleryKey]['image'] = '/storage/product/' . $gallery['image'];
                }

            $productCategories[$key]['category']['image'] = '/storage/category/' . $productCategory['category']['image'];
            $productCategories[$key]['category']['icon'] = '/storage/category/' . $productCategory['category']['icon'];

            $data['product_list'] = $productCategories;

            $response = [
                'success' => true,
                'message' => 'Product list',
                'data' => $data,
            ];
            return response()->json($response,200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Category Not Found',
                'data' => '',
            ];
            return response()->json($response,200);
        }
    }

    //show data of category table
    public function list() {
        $categories = Category::whereStatus(1)->with('type')
            ->get();

        foreach ($categories as $key => $category) {
            $categories[$key]['image'] = '/storage/category/' . $category->image;
            $categories[$key]['icon'] = '/storage/category/' . $category->icon;


        }
        $categories[$key]['type']['image'] = '/storage/type/' . $category['type']['image'];
        $categories[$key]['type']['icon'] = '/storage/type/' . $category['type']['icon'];

        $data['categories'] = $categories;

        $response = [
            'success' => true,
            'message' => 'Category list',
            'data' => $data,
        ];

        return response()->json($response,200);
    }

    public function categoryById($id) {
        $productCategories = ProductCategory::whereCategoryId($id)
            ->with('category','products','products.tags','products.prices','products.gallery','products.user:id,name', 'products.type:id,name')
            ->get();
        if ($productCategories->count()>0) {
            foreach ($productCategories as $key => $productCategory) {
                $productCategories[$key]['products']['image'] = '/storage/product/' . $productCategory['products']['image'];

                foreach ($productCategory['products']['gallery'] as $galleryKey => $gallery) {
                    $productCategories[$key]['products']['gallery'][$galleryKey]['image'] = '/storage/product/' . $gallery['image'];
                }
            }

            // foreach ($productCategories as $key => $productCategory) {
            //     $productCategories[$key]['products']['image'] = '/storage/product/' . $productCategory['products']['image'];
            //     $productCategories[$key]['category']['image'] = '/storage/category/' . $productCategory['category']['image'];
            // }
            $productCategories[$key]['category']['image'] = '/storage/category/' . $productCategory['category']['image'];
            $productCategories[$key]['category']['icon'] = '/storage/category/' . $productCategory['category']['icon'];


            $data['product_list'] = $productCategories;

            $response = [
                'success' => true,
                'message' => 'Product list',
                'data' => $data,
            ];
            return response()->json($response,200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Category Not Found',
                'data' => '',
            ];
            return response()->json($response,200);
     }
    }
}
