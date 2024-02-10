<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialApiController extends Controller
{
     // show data of testimonial table
   public function list($id=null){
    $testimonials = Testimonial::whereStatus(1)->get();
    if($testimonials->count()>0){
    foreach ($testimonials as $key => $testimonial) {
        $testimonials[$key]['image'] = '/storage/testimonial/' . $testimonial->image;

    }

    $data['testimonial_list']= $testimonials;
    $response = [
        'success' => true,
        'message' => 'Testimonials',
        'data' => $data,
    ];

    return response()->json($response,200);
    }else{
        $response = [
            'success' => true,
            'message' => 'No Testimonials Available',
            'data' => '',
        ];

        return response()->json($response,200);
    }
   }
}
