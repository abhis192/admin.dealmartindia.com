<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CakeFlavour;
use Storage;
use File;

class CakeFlavourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flavours = CakeFlavour::all();
        return view('admin.cake-flavour.index', compact('flavours'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cake-flavour.create');
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
            'slug' => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'image'=> 'nullable|image|mimes:jpeg,png,jpg',
            'icon'=> 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tax' => 'nullable|numeric|between:0,999999.9'
        ]);

        $data = $request->all();

        if($request->hasFile('image')){
            $fileImage = $request->file('image');
            $fileImageName = rand() . '.' . $fileImage->getClientOriginalName();
            $fileImage->storeAs('public/flavour/',$fileImageName);
            $data['image'] = $fileImageName;
        }

        if($request->hasFile('icon')){
            $fileIcon = $request->file('icon');
            $fileIconName = rand() . '.' . $fileIcon->getClientOriginalName();
            $fileIcon->storeAs('public/flavour/',$fileIconName);
            $data['icon'] = $fileIconName;
        }

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        CakeFlavour::create($data);
        return redirect('/admin/product/cake-flavour')->with('success','Cake Flavour created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $flavour = CakeFlavour::findOrFail($id);
        return view('admin.cake-flavour.edit', compact('flavour'));
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
            'slug' => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'image'=> 'nullable|image|mimes:jpeg,png,jpg',
            'hidden_image' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg',
            'hidden_icon' => 'required|string',
            'tax' => 'nullable|numeric|between:0,999999.9'
        ]);

        $flavour = CakeFlavour::findOrFail($id);
        $data = $request->all();

        $image_name = $request->hidden_image;
        $image = $request->file('image');
        if($image != '') {
            if ($flavour->image != 'default.jpg') {
                File::delete(public_path('storage/flavour/'). $flavour->image);
            }
            $image_name = rand() . '.' . $image->getClientOriginalName();
            $image->move(public_path('storage/flavour/'), $image_name);
            $image_name = $image_name;
        }

        $icon_name = $request->hidden_icon;
        $icon = $request->file('icon');
        if($icon != '') {
            if ($flavour->icon != 'default.png') {
                File::delete(public_path('storage/flavour/'). $flavour->icon);
            }
            $icon_name = rand() . '.' . $icon->getClientOriginalName();
            $icon->move(public_path('storage/flavour/'), $icon_name);
            $icon_name = $icon_name;
        }

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        $data['image'] = $image_name;
        $data['icon'] = $icon_name;
        $flavour->update($data);
        return redirect('admin/product/cake-flavour')->with('success', 'Cake Flavour has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flavour = CakeFlavour::findOrFail($id);
        if ($flavour->image != 'default.jpg') {
            File::delete(public_path('storage/flavour/').$flavour->image);
        }
        if ($flavour->icon != 'default.png') {
            File::delete(public_path('storage/flavour/').$flavour->icon);
        }
        $flavour->delete();
        return redirect('/admin/product/cake-flavour')->with('success','Cake Flavour deleted successfully.');
    }

    // Toggle
    public function toggle(Request $request, $id)
    {
        $flavour = CakeFlavour::findOrFail($id);
        if (!empty($request->status)) {
            $flavour->update(['status'=>1]);
        } else {
            $flavour->update(['status'=>0]);
        }
        return redirect('/admin/product/cake-flavour')->with('success', 'Cake Flavour has been upadted successfully.');
    }
}
