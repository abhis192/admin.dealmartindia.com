<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerApiController extends Controller
{
    // show data of banner table
   public function list($id=null){
    $banners = Banner::whereStatus(1)->get();

    foreach ($banners as $key => $banner) {
        $banners[$key]['desktop'] = '/storage/banner/' . $banner->desktop;
        $banners[$key]['mobile'] = '/storage/banner/' . $banner->mobile;
    }

    return $banners;
   }
}
