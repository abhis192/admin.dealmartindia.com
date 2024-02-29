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
            // 'logo' => 'nullable|image|mimes:jpeg,png,jpg',
            // 'hidden_logo' => 'required|string',
            // 'icon' => 'nullable|image|mimes:jpeg,png,jpg',
            // 'hidden_icon' => 'required|string',
        ]);
        $homePage = HomePage::findOrFail($id);
        $data = $request->all();

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
        $homePage->update($data);
        return redirect()->back()->with('success','Home page updated successfully.');
    }
}
