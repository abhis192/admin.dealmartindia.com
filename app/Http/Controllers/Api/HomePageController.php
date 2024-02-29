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
}
