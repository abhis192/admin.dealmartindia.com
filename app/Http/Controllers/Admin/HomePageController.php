<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\HomePage;
use App\Models\Type;
use Auth;
use Session;
use File;

class HomePageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $homePage = HomePage::first();
        $types = Type::get();
        return view('admin.home-page', compact('homePage','types'));
    }
    public function homePageUpdate(Request $request, $id)
    {
        $request->validate([
            // 'site_name' => 'nullable|string',
            // 'site_email' => 'nullable|email',
            // 'email' => 'nullable|email',
            // 'mobile' => 'nullable|numeric|digits:10',
            // 'address' => 'nullable',
            // 'facebook' => 'nullable',
            // 'instagram' => 'nullable',
            // 'twitter' => 'nullable',
            // 'linkedin' => 'nullable',
            // 'youtube' => 'nullable',
            // 'logo' => 'nullable|image|mimes:jpeg,png,jpg',
            // 'hidden_logo' => 'required|string',
            // 'icon' => 'nullable|image|mimes:jpeg,png,jpg',
            // 'hidden_icon' => 'required|string',
            // 'meta_title' => 'nullable|string',
            // 'meta_keywords' => 'nullable|string',
            // 'meta_description' => 'nullable|string',
            // 'tax' => 'numeric|between:0,999999.9'
        ]);
        $homePage = HomePage::findOrFail($id);
        $data = $request->all();

        $section_1_name = $request->hidden_section_1;
        $section_1 = $request->file('section_1');
        if($section_1 != '') {
            if ($homePage->section_1 != 'default.jpg') {
                File::delete(public_path('storage/banner/'). $homePage->section_1);
            }
            $section_1_name = rand() . '.' . $section_1->getClientOriginalName();
            $section_1->move(public_path('storage/banner/'), $section_1_name);
            $section_1_name = $section_1_name;
        }

        $section_4_name = $request->hidden_section_4;
        $section_4 = $request->file('section_4');
        if($section_4 != '') {
            if ($homePage->section_4 != 'default.jpg') {
                File::delete(public_path('storage/banner/'). $homePage->section_4);
            }
            $section_4_name = rand() . '.' . $section_4->getClientOriginalName();
            $section_4->move(public_path('storage/banner/'), $section_4_name);
            $section_4_name = $section_4_name;
        }

        $section_5_name = $request->hidden_section_5;
        $section_5 = $request->file('section_5');
        if($section_5 != '') {
            if ($homePage->section_5 != 'default.jpg') {
                File::delete(public_path('storage/banner/'). $homePage->section_5);
            }
            $section_5_name = rand() . '.' . $section_5->getClientOriginalName();
            $section_5->move(public_path('storage/banner/'), $section_5_name);
            $section_5_name = $section_5_name;
        }

        $section_8_name = $request->hidden_section_8;
        $section_8 = $request->file('section_8');
        if($section_8 != '') {
            if ($homePage->section_8 != 'default.jpg') {
                File::delete(public_path('storage/banner/'). $homePage->section_8);
            }
            $section_8_name = rand() . '.' . $section_8->getClientOriginalName();
            $section_8->move(public_path('storage/banner/'), $section_8_name);
            $section_8_name = $section_8_name;
        }

        $section_9_name = $request->hidden_section_9;
        $section_9 = $request->file('section_9');
        if($section_9 != '') {
            if ($homePage->section_9 != 'default.jpg') {
                File::delete(public_path('storage/banner/'). $homePage->section_9);
            }
            $section_9_name = rand() . '.' . $section_9->getClientOriginalName();
            $section_9->move(public_path('storage/banner/'), $section_9_name);
            $section_9_name = $section_9_name;
        }


        $data['section_1'] = $section_1_name;
        $data['section_4'] = $section_4_name;
        $data['section_5'] = $section_5_name;
        $data['section_8'] = $section_8_name;
        $data['section_9'] = $section_9_name;
        $homePage->update($data);
        return redirect()->back()->with('success','Home page updated successfully.');
    }
}
