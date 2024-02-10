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

    foreach ($testimonials as $key => $testimonial) {
        $testimonials[$key]['image'] = '/storage/testimonial/' . $testimonial->image;

    }

    return $testimonials;
   }
}
