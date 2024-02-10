<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageApiController extends Controller
{
   // show data of page table
   public function list($id=null){
    $pages = Page::whereStatus(1)->get();

    foreach ($pages as $key => $page) {
        $pages[$key]['image'] = '/storage/page/' . $page->image;
        // $pages[$key]['image'] = '/storage/page/' . $page->image;
    }

    $data['pages'] = $pages;

    $response = [
        'success' => true,
        'data' => $data,
        'message' => ''
    ];

    return response()->json($response,200);
    // return $pages;
   }

   public function pagesBySlug($slug)
   {
       $page = Page::whereStatus(1)->whereSlug($slug)->first(); // Use first() instead of get() to get a single model instance

       if ($page) {
            // Modify the image paths for the product
            $page->image = '/storage/page/' . $page->image;
        }
        else{

            $response = [
                'success' => false,
                'data' => '',
                'message' => 'Page does not exist'
            ];
            return response()->json($response,200);

        }

        $data['page'] = $page;

        $response = [
            'success' => true,
            'data' => $data,
            'message' => ''
        ];

        return response()->json($response,200);

    }
}
