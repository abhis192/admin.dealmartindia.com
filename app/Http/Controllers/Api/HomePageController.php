<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomePage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Type;

class HomePageController extends Controller
{
    public function list(){
        $homePage = HomePage::first();
        $type_section_1=Type::whereId($homePage->section_1)->with('Categories')->get();
        $type_section_2=Type::whereId($homePage->section_1)->with('Categories')->get();
        $type_section_3=Type::whereId($homePage->section_1)->with('Categories')->get();

        if ($homePage) {
            // Modify the image paths for the home page
            $homePage->section_4 = '/storage/banner/' . $homePage->section_4;

            foreach ($type_section_1 as $key => $sections) {
                foreach ($sections->Categories as $index => $cat) {
                    $cat['image'] = '/storage/category/' . $cat->image;
                    $cat['icon'] = '/storage/category/' . $cat->icon;
                }
            }

            foreach ($type_section_2 as $key => $sections) {
                foreach ($sections->Categories as $index => $cat) {
                    $cat['image'] = '/storage/category/' . $cat->image;
                    $cat['icon'] = '/storage/category/' . $cat->icon;
                }
            }

            foreach ($type_section_3 as $key => $sections) {
                foreach ($sections->Categories as $index => $cat) {
                    $cat['image'] = '/storage/category/' . $cat->image;
                    $cat['icon'] = '/storage/category/' . $cat->icon;
                }
            }
        }
        $data['home_page'] = $homePage;
        $data['home_page']['section_1'] = $type_section_1;
        $data['home_page']['section_2'] = $type_section_2;
        $data['home_page']['section_3'] = $type_section_3;

        $response = [
            'success' => true,
            'message' => 'Home Page',
            'data' => $data,
        ];

        return response()->json($response,200);

    }


public function categoryByTypeList(){
    $result = [];

            $resp = Type::where('status', 1)->orderBy('order','asc')
            ->with(['categories' => function ($query) {
                $query->where('status', 1)
                    ->with('subCategories');
            }])
            ->get();

          foreach($resp as $resps){
            $typeData = [
                        'type_id' => $resps->id,
                        'type_name' => $resps->name,
                        'type_slug' => $resps->slug,
                        // 'categories' => [],
                    ];

            $categories = $resps->categories->toArray();
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

            $typeData['categories'] = array_merge($categories, $subCategories);
        // }
        // dd('done');
        $result[] = $typeData;
    }

    $response = [
        'success' => true,
        'message' => 'Category By Type list',
        'data' => $result,
    ];

    return response()->json($response, 200);
}


}
