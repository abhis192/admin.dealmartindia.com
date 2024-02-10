<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Type;
use Storage;
use File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::whereStatus(1)->whereNull('parent_category_id')->get();
        $types = Type::whereStatus(1)->get();
        return view('admin.category.create', compact('categories','types'));
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
            'slug' => 'required|string|min:2|max:255',
            'description' => 'nullable|string',
            'parent_category_id' => 'nullable|integer',
            'type_id' => 'nullable|integer',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'nullable'
        ]);
        $data = $request->all();

        if($request->hasFile('image')){
            $fileImage = $request->file('image');
            $fileImageName = rand() . '.' . $fileImage->getClientOriginalName();
            $fileImage->storeAs('public/category/',$fileImageName);
            $data['image'] = $fileImageName;
        }

        if($request->hasFile('icon')){
            $fileIcon = $request->file('icon');
            $fileIconName = rand() . '.' . $fileIcon->getClientOriginalName();
            $fileIcon->storeAs('public/category/',$fileIconName);
            $data['icon'] = $fileIconName;
        }

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        Category::create($data);
        return redirect('/admin/product/category')->with('success','Category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::whereStatus(1)->whereNull('parent_category_id')->get();
        $types = Type::whereStatus(1)->get();
        return view('admin.category.edit', compact('categories','types','category'));
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
            'slug' => 'required|string|min:2|max:255',
            'description' => 'nullable|string',
            'parent_category_id' => 'nullable|integer',
            'type_id' => 'nullable|integer',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'hidden_image' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg',
            'hidden_icon' => 'required|string',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'nullable'
        ]);
        $category = Category::findOrFail($id);
        $data = $request->all();

        $image_name = $request->hidden_image;
        $image = $request->file('image');
        if($image != '') {
            if ($category->image != 'default.jpg') {
                File::delete(public_path('storage/category/'). $category->image);
            }
            $image_name = rand() . '.' . $image->getClientOriginalName();
            $image->move(public_path('storage/category/'), $image_name);
            $image_name = $image_name;
        }

        $icon_name = $request->hidden_icon;
        $icon = $request->file('icon');
        if($icon != '') {
            if ($category->icon != 'default.png') {
                File::delete(public_path('storage/category/'). $category->icon);
            }
            $icon_name = rand() . '.' . $icon->getClientOriginalName();
            $icon->move(public_path('storage/category/'), $icon_name);
            $icon_name = $icon_name;
        }

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        $data['image'] = $image_name;
        $data['icon'] = $icon_name;
        $category->update($data);
        return redirect('admin/product/category')->with('success', 'Category has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category->image != 'default.jpg') {
            File::delete(public_path('storage/category/').$category->image);
        }
        if ($category->icon != 'default.png') {
            File::delete(public_path('storage/category/'). $category->icon);
        }
        $category->delete();
        return redirect('/admin/product/category')->with('success','category deleted successfully.');
    }

    // Acttive
    public function toggle(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        if (!empty($request->status)) {
            $category->update(['status'=>1]);
        } else {
            $category->update(['status'=>0]);
        }
        return redirect('/admin/product/category')->with('success', 'Category has been upadted successfully.');
    }
}
