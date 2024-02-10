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
                                ->paginate(10);

            foreach ($productCategories as $key => $productCategory) {
                $productCategories[$key]['products']['image'] = '/storage/product/' . $productCategory['products']['image'];

                foreach ($productCategory['products']['gallery'] as $galleryKey => $gallery) {
                    $productCategories[$key]['products']['gallery'][$galleryKey]['image'] = '/storage/product/' . $gallery['image'];
                }
            }

            //  foreach ($productCategories->products as $gallery) {
            //     // Modify the image and icon paths for the nested category relationship
            //     // $gallery->gallery->image = '/storage/product/' . $gallery->gallery->image;
            //     $productCategories[$key]['gallery']['image'] = '/storage/gallery/' . $productCategory['gallery']['image'];
            // //     $category->category->icon = '/storage/category/' . $category->category->icon;

            // //     // Modify the image and icon paths for the nested type relationship
            // //     $category->category->type->image = '/storage/type/' . $category->category->type->image;
            // //     $category->category->type->icon = '/storage/type/' . $category->category->type->icon;
            // }
             foreach ($productCategory['products']['gallery'] as $galleryKey => $gallery) {
                    $productCategories[$key]['products']['gallery'][$galleryKey]['image'] = '/storage/product/' . $gallery['image'];
                }

            $productCategories[$key]['category']['image'] = '/storage/category/' . $productCategory['category']['image'];
            $productCategories[$key]['category']['icon'] = '/storage/category/' . $productCategory['category']['icon'];



            return response()->json($productCategories);
        } else {
            return response()->json(['error' => 'Category not found'], 404);
        }
    }

    //show data of category table
    public function list() {
        $categories = Category::whereStatus(1)->with('type')
            ->paginate(10);

        foreach ($categories as $key => $category) {
            $categories[$key]['image'] = '/storage/category/' . $category->image;
            $categories[$key]['icon'] = '/storage/category/' . $category->icon;


        }
        $categories[$key]['type']['image'] = '/storage/type/' . $category['type']['image'];
        $categories[$key]['type']['icon'] = '/storage/type/' . $category['type']['icon'];

        return response()->json($categories);
    }

    public function categoryById($id) {
        $productCategories = ProductCategory::whereCategoryId($id)
            ->with('category','products','products.tags','products.prices','products.gallery','products.user:id,name', 'products.type:id,name')
            ->paginate(10);

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


        return response()->json($productCategories);
    }

    // public function typelist($type_id){
    //     return $type_id?Category::find($type_id):Category::all();
    //    }
    public function typelist($type_id){
    $categories = Category::whereTypeId($type_id)->get();
    // if ($type) {
    //     $filteredProducts = Category::whereCategoryId($category->id)->wherePublished(1)->paginate(9);
    //     $categoryId = $category->id;
    //     return view('frontend.products', compact('filteredProducts','slug','categoryId'));
    // }
    return $categories;

}
}
