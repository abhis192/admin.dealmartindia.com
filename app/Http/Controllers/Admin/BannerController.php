<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Storage;
use File;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.create');
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
            'name' => 'nullable|string|min:3|max:255',
            'url' => 'nullable|string|min:2|max:255',
            'description' => 'nullable|string',
            'desktop' => 'nullable|image|mimes:jpeg,png,jpg',
            'mobile' => 'nullable|image|mimes:jpeg,png,jpg',
            'status' => 'nullable'
        ]);

        $data = $request->all();

        if($request->hasFile('desktop')){
            $fileDesktop = $request->file('desktop');
            $fileDesktopName = rand() . '.' . $fileDesktop->getClientOriginalName();
            $fileDesktop->storeAs('public/banner/',$fileDesktopName);
            $data['desktop'] = $fileDesktopName;
        }

        if($request->hasFile('mobile')){
            $fileMobile = $request->file('mobile');
            $fileMobileName = rand() . '.' . $fileMobile->getClientOriginalName();
            $fileMobile->storeAs('public/banner/',$fileMobileName);
            $data['mobile'] = $fileMobileName;
        }

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        Banner::create($data);
        return redirect('/admin/banners')->with('success','Banner created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('banner'));
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
            'url' => 'nullable|string|min:2|max:255',
            'description' => 'nullable|string',
            'desktop' => 'nullable|image|mimes:jpeg,png,jpg',
            'hidden_desktop' => 'required|string',
            'mobile' => 'nullable|image|mimes:jpeg,png,jpg',
            'hidden_mobile' => 'required|string',
            'status' => 'nullable'
        ]);

        $banner = Banner::findOrFail($id);
        $data = $request->all();

        $desktop_name = $request->hidden_desktop;
        $desktop = $request->file('desktop');
        if($desktop != '') {
            if ($banner->desktop != 'default.jpg') {
                File::delete(public_path('storage/banner/'). $banner->desktop);
            }
            $desktop_name = rand() . '.' . $desktop->getClientOriginalName();
            $desktop->move(public_path('storage/banner/'), $desktop_name);
            $desktop_name = $desktop_name;
        }

        $mobile_name = $request->hidden_mobile;
        $mobile = $request->file('mobile');
        if($mobile != '') {
            if ($banner->mobile != 'default.jpg') {
                File::delete(public_path('storage/banner/'). $banner->mobile);
            }
            $mobile_name = rand() . '.' . $mobile->getClientOriginalName();
            $mobile->move(public_path('storage/banner/'), $mobile_name);
            $mobile_name = $mobile_name;
        }

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        $data['desktop'] = $desktop_name;
        $data['mobile'] = $mobile_name;
        $banner->update($data);
        return redirect('admin/banners')->with('success', 'Banner has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        if ($banner->desktop != 'default.jpg') {
            File::delete(public_path('storage/banner/').$banner->desktop);
        }
        if ($banner->mobile != 'default.jpg') {
            File::delete(public_path('storage/banner/').$banner->mobile);
        }
        $banner->delete();
        return redirect('/admin/banners')->with('success','Banner deleted successfully.');
    }

    // Acttive
    public function toggle(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        if (!empty($request->status)) {
            $banner->update(['status'=>1]);
        } else {
            $banner->update(['status'=>0]);
        }
        return redirect('/admin/banners')->with('success', 'Banner has been upadted successfully.');
    }
}
