<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use DB;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::all();
        $countries = Country::all();
        return view('admin.state.index', compact('states','countries'));
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
            'country_id' => 'required|integer',
            'status' => 'nullable'
        ]);
        $data = $request->all();

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        State::create($data);
        return redirect('/admin/state')->with('success','State created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $state = State::findOrFail($id);
        $states = State::all();
        $countries = Country::whereStatus(1)->get();
        return view('admin.state.edit', compact('state','countries','states'));
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
            'country_id' => 'required|integer',
            'status' => 'nullable'
        ]);
        $state = State::findOrFail($id);
        $data = $request->all();

        $data['status'] = 0;
        if (!empty($request->status)) {
            $data['status'] = 1;
        }

        $state->update($data);
        return redirect('/admin/state')->with('success','State updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $state = State::findOrFail($id);
        $state->delete();
        return redirect('/admin/state')->with('success', 'State has been deleted successfully.');
    }

    // Toggle
    public function toggle(Request $request, $id)
    {
        $state = State::findOrFail($id);
        if (!empty($request->status)) {
            $state->update(['status'=>1]);
        } else {
            $state->update(['status'=>0]);
        }
        return redirect('/admin/state')->with('success', 'State has been upadted successfully.');
    }


    public function upload()
    {
        return view('admin.state.upload');
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
                        // Perform validation for each row
                        $validation = Validator::make([
                            'name' => $row[0],
                            'description' => $row[1] ?? null,
                            'country_id' => $row[2],
                            'status' => $row[3],
                        ], [
                            'name' => 'required|string|unique:states',
                            'description' => 'nullable',
                            'country_id' => 'required|exists:countries,name',
                            'status' => 'nullable'
                        ]);

                        // Check if validation fails for this row
                        if ($validation->fails()) {
                            DB::rollBack(); // Roll back the transaction.
                            $errors = $validation->errors();
                            return redirect()->back()->with('failure', 'Validation failed for CSV row ' . ($key + 1) . ': ' . $errors->first());
                        }

                        // If validation passes, create and save a new State
                        $state = new State();
                        $state->name = $row[0];
                        $state->description = $row[1] ?? null;
                        $state->country_id = Country::where('name', $row[2])->first()->id ?? null;
                        $state->status = $row[3];
                        $state->save();
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
