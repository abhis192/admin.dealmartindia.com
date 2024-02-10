<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use Storage;
use File;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::all();
        return view('admin.type.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.type.create');
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
            'order' => 'nullable|integer|min:0',
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
            $fileImage->storeAs('public/type/',$fileImageName);
            $data['image'] = $fileImageName;
        }

        if($request->hasFile('icon')){
            $fileIcon = $request->file('icon');
            $fileIconName = rand() . '.' . $fileIcon->getClientOriginalName();
            $fileIcon->storeAs('public/type/',$fileIconName);
            $data['icon'] = $fileIconName;
        }

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        Type::create($data);
        return redirect('/admin/product/type')->with('success','Product-type created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = Type::findOrFail($id);
        return view('admin.type.edit', compact('type'));
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
            // 'order' => 'required|integer|min:0',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'image'=> 'nullable|image|mimes:jpeg,png,jpg',
            'hidden_image' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg',
            'hidden_icon' => 'required|string',
            'tax' => 'nullable|numeric|between:0,999999.9'
        ]);

        $type = Type::findOrFail($id);
        $data = $request->all();

        $image_name = $request->hidden_image;
        $image = $request->file('image');
        if($image != '') {
            if ($type->image != 'default.jpg') {
                File::delete(public_path('storage/type/'). $type->image);
            }
            $image_name = rand() . '.' . $image->getClientOriginalName();
            $image->move(public_path('storage/type/'), $image_name);
            $image_name = $image_name;
        }

        $icon_name = $request->hidden_icon;
        $icon = $request->file('icon');
        if($icon != '') {
            if ($type->icon != 'default.png') {
                File::delete(public_path('storage/type/'). $type->icon);
            }
            $icon_name = rand() . '.' . $icon->getClientOriginalName();
            $icon->move(public_path('storage/type/'), $icon_name);
            $icon_name = $icon_name;
        }

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        $data['image'] = $image_name;
        $data['icon'] = $icon_name;
        $type->update($data);
        return redirect('admin/product/type')->with('success', 'Product-type has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        if ($type->image != 'default.jpg') {
            File::delete(public_path('storage/type/').$type->image);
        }
        if ($type->icon != 'default.png') {
            File::delete(public_path('storage/type/').$type->icon);
        }
        $type->delete();
        return redirect('/admin/product/type')->with('success','Product-type deleted successfully.');
    }

    // Toggle
    public function toggle(Request $request, $id)
    {
        $type = Type::findOrFail($id);
        if (!empty($request->status)) {
            $type->update(['status'=>1]);
        } else {
            $type->update(['status'=>0]);
        }
        return redirect('/admin/product/type')->with('success', 'Product-type has been upadted successfully.');
    }
}
