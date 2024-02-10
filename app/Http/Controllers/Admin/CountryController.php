<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::all();
        return view('admin.country.index', compact('countries'));
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
            'name' => 'required|string|unique:countries',
            'description' => 'nullable|string',
            'status' => 'nullable'
        ]);
        $data = $request->all();

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        Country::create($data);
        return redirect('/admin/country')->with('success','Country created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::findOrFail($id);
        $countries = Country::all();
        return view('admin.country.edit', compact('country','countries'));
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
            'name' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'nullable'
        ]);
        $country = Country::findOrFail($id);
        $data = $request->all();

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        $country->update($data);
        return redirect('/admin/country')->with('success','Country updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        $country->cities->each->delete();
        $country->delete();
        return redirect('/admin/country')->with('success', 'Country has been deleted successfully.');
    }

    // Toggle
    public function toggle(Request $request, $id)
    {
        $country = Country::findOrFail($id);
        if (!empty($request->status)) {
            $country->update(['status'=>1]);
        } else {
            $country->update(['status'=>0]);
        }
        return redirect('/admin/country')->with('success', 'Country has been upadted successfully.');
    }
}
