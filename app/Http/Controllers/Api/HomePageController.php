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

        // $categories_section_2=Category::wheretypeId($homePage->section_2)->get();
        $type_section_2=Type::whereId($homePage->section_2)->with('Categories')->get();
        $type_section_3=Type::whereId($homePage->section_3)->with('Categories')->get();
        $type_section_6=Type::whereId($homePage->section_6)->with('Categories')->get();
        $type_section_7=Type::whereId($homePage->section_7)->with('Categories')->get();
        // $resp = HomePage::
        // with(['type' => function ($query) {
        //     $query->where('status', 1)
        //         ->with('Categories');
        // }])
        // ->get();
        // return response()->json($type_section_2,200);
        // dd($type_section_2['Categories']);
        // $type_section_2['image'] = '/storage/banner/' . $type_section_2['image'];

        if ($homePage) {
            // Modify the image paths for the home page
            $homePage->section_1 = '/storage/banner/' . $homePage->section_1;
            $homePage->section_4 = '/storage/banner/' . $homePage->section_4;
            $homePage->section_5 = '/storage/banner/' . $homePage->section_5;
            $homePage->section_8 = '/storage/banner/' . $homePage->section_8;
            $homePage->section_9 = '/storage/banner/' . $homePage->section_9;
            // $homePage->section_2['image'] = '/storage/banner/' . $homePage->section_2['image'];
            // dd($homePage->section_2);

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

            foreach ($type_section_6 as $key => $sections) {
                foreach ($sections->Categories as $index => $cat) {
                    $cat['image'] = '/storage/category/' . $cat->image;
                    $cat['icon'] = '/storage/category/' . $cat->icon;
                }
            }

            foreach ($type_section_7 as $key => $sections) {
                foreach ($sections->Categories as $index => $cat) {
                    $cat['image'] = '/storage/category/' . $cat->image;
                    $cat['icon'] = '/storage/category/' . $cat->icon;
                }
            }


        }
        $data['home_page'] = $homePage;
        $data['home_page']['section_2'] = $type_section_2;
        $data['home_page']['section_3'] = $type_section_3;
        $data['home_page']['section_6'] = $type_section_6;
        $data['home_page']['section_7'] = $type_section_7;
        // $data['section_3'] = $type_section_3;
        // $data['section_2']['categories_list'] = $categories_section_2;
        // $data['section_3'] = $categories_section_3;

        $response = [
            'success' => true,
            'data' => $data,
            'message' => ''
        ];

        return response()->json($response,200);

    }
}
