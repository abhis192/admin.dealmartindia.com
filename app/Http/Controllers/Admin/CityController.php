<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\CityMapping;
// use App\Models\DeliveryOption;
use DB;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        $states = State::all();
        // $delivery_options = DeliveryOption::all();
        return view('admin.city.index', compact('cities','states'));
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
            'name' => 'required|string|unique:cities',
            'description' => 'nullable|string',
            'state_id' => 'required|integer',
            'shipping_cost' => 'nullable',
            'status' => 'nullable'
        ]);
        $data = $request->all();

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        $city= City::create($data);

        return redirect('/admin/city')->with('success','City created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::findOrFail($id);
        // $city_map = CityMapping::findOrFail($id);
        $cities = City::all();
        $states = State::whereStatus(1)->get();
        return view('admin.city.edit', compact('city','states','cities'));
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
            'state_id' => 'required|integer',
            'shipping_cost' => 'nullable',
            'status' => 'nullable'
        ]);
        $city = City::findOrFail($id);
        $data = $request->all();

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        $city->update($data);
        return redirect('/admin/city')->with('success','City updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        // $productTag = CityMapping::findOrFail($id);
        $city->pincodes->each->delete();
        $city->mappings->each->delete();
        $city->delete();

        $productTag->delete();
        $city->tags->each->delete();
        return redirect('/admin/city')->with('success', 'City has been deleted successfully.');
    }

    // Toggle
    public function toggle(Request $request, $id)
    {
        $city = City::findOrFail($id);
        if (!empty($request->status)) {
            $city->update(['status'=>1]);
        } else {
            $city->update(['status'=>0]);
        }
        return redirect('/admin/city')->with('success', 'City has been upadted successfully.');
    }

    public function upload()
    {
        return view('admin.city.upload');
    }

    public function import(Request $request)
    {
        ini_set('max_execution_time', 300);
        DB::beginTransaction(); // Start a database transaction.

        try {
            $request->validate([
                'csv_file' => 'required|file|mimes:csv,txt',
            ]);

            if ($request->hasFile('csv_file')) {
                $path = $request->file('csv_file')->getRealPath();
                $data = array_map('str_getcsv', file($path));

                foreach ($data as $key => $row) {
                    if ($key != 0) {
                        $validation = Validator::make([
                            'name' => $row[0],
                            'description' => $row[1] ?? null,
                            'state_id' => $row[2],
                            'shipping_cost' => $row[3] ?? null,
                            'status' => $row[4],
                        ], [
                            'name' => 'required|string|unique:cities',
                            'description' => 'nullable',
                            'state_id' => 'required|string',
                            'shipping_cost' => 'nullable',
                            'status' => 'nullable'
                        ]);

                        if ($validation->fails()) {
                            DB::rollBack(); // Roll back the transaction.
                            $errors = $validation->errors();
                            return redirect()->back()->with('failure', 'Validation failed for CSV row ' . ($key + 1) . ': ' . $errors->first());
                        }

                        $city = new City();
                        $city->name = $row[0];
                        $city->description = $row[1] ?? null;
                        $city->state_id = State::whereName($row[2])->first()->id ?? null;
                        $city->shipping_cost = empty($row[3]) ? null : $row[3];
                        $city->status = $row[4];
                        $city->save();
                    }
                }
            }

            DB::commit(); // Commit the transaction if everything is successful.
            return redirect()->back()->with('success', 'CSV imported successfully.');
        } catch (\Exception $e) {
            DB::rollBack(); // Roll back the transaction on any other exception.
            return redirect()->back()->with('failure', 'An error occurred. Please check all the fields.');
        }
    }
}
