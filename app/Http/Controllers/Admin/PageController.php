<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::all();
        return view('admin.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.page.create');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'nullable'
        ]);
        $data = $request->all();

        if($request->hasFile('image')){
            $fileImage = $request->file('image');
            $fileImageName = rand() . '.' . $fileImage->getClientOriginalName();
            $fileImage->storeAs('public/page/',$fileImageName);
            $data['image'] = $fileImageName;
        }

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        Page::create($data);
        return redirect('/admin/pages')->with('success','Page created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.page.edit', compact('page'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'hidden_image' => 'required|string',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'nullable'
        ]);
        $page = Page::findOrFail($id);
        $data = $request->all();

        $image_name = $request->hidden_image;
        $image = $request->file('image');
        if($image != '') {
            if ($page->image != 'default.jpg') {
                File::delete(public_path('storage/page/'). $page->image);
            }
            $image_name = rand() . '.' . $image->getClientOriginalName();
            $image->move(public_path('storage/page/'), $image_name);
            $image_name = $image_name;
        }

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        $data['image'] = $image_name;
        $page->update($data);
        return redirect('admin/pages')->with('success', 'Page has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        if ($page->image != 'default.jpg') {
            File::delete(public_path('storage/page/').$page->image);
        }
        $page->delete();
        return redirect('/admin/pages')->with('success','Page deleted successfully.');
    }

    public function toggle(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        if (!empty($request->status)) {
            $page->update(['status'=>1]);
        } else {
            $page->update(['status'=>0]);
        }
        return redirect('/admin/pages')->with('success', 'Page has been upadted successfully.');
    }
}
