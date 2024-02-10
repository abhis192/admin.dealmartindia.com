<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Storage;
use File;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::all();
        return view('admin.testimonial.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'country' => 'nullable|string|min:2|max:255',
            'description' => 'required|string'
        ]);
        $data = $request->all();

        if($request->hasFile('image')){
            $fileImage = $request->file('image');
            $fileImageName = rand() . '.' . $fileImage->getClientOriginalName();
            $fileImage->storeAs('public/testimonial/',$fileImageName);
            $data['image'] = $fileImageName;
        }

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        Testimonial::create($data);
        return redirect('/admin/testimonial')->with('success','Testimonial created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonial.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'hidden_image' => 'required|string',
            'country' => 'nullable|string|min:2|max:255',
            'description' => 'required|string'
        ]);
        $testimonial = Testimonial::findOrFail($id);
        $data = $request->all();

        $image_name = $request->hidden_image;
        $image = $request->file('image');
        if($image != '') {
            if ($testimonial->image != 'default.jpg') {
                File::delete(public_path('storage/testimonial/'). $testimonial->image);
            }
            $image_name = rand() . '.' . $image->getClientOriginalName();
            $image->move(public_path('storage/testimonial/'), $image_name);
            $image_name = $image_name;
        }

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        $data['image'] = $image_name;
        $testimonial->update($data);
        return redirect('admin/testimonial')->with('success', 'Testimonial has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        if ($testimonial->image != 'default.jpg') {
            File::delete(public_path('storage/testimonial/').$testimonial->image);
        }
        $testimonial->delete();
        return redirect('/admin/testimonial')->with('success','Testimonial deleted successfully.');
    }

    // Acttive
    public function toggle(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        if (!empty($request->status)) {
            $testimonial->update(['status'=>1]);
        } else {
            $testimonial->update(['status'=>0]);
        }
        return redirect('/admin/testimonial')->with('success', 'Testimonial has been upadted successfully.');
    }
}
