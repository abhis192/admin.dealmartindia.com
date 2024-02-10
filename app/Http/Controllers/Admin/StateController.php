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

    public function getIndex(Request $request)
    {
        // \Can::access('pin_codes');

        return view('admin.state.index');
    }

    public function getList(Request $request)
    {
        $list = \App\Models\State::select('states.*','countries.name AS country')
            ->leftJoin('countries', 'countries.id', '=', 'states.country_id');

        return \DataTables::of($list)->make();
    }

    public function getLocationViaPinCode(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'pin_code' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $dataObj = objFromPost(['pin_code']);

        $output = ['city' => '', 'state' => '', 'country' => '', 'city_id' => '', 'state_id' => '', 'country_id' => ''];

        if ($result = \App\Models\PinCode::wherePinCode($dataObj->pin_code)->whereStatus(1)->first()) {
            $output = [
                'city' =>  $result->city_id ? \App\Models\City::whereId($result->city_id)->value('name') : '',
                'state' =>  $result->state_id ? \App\Models\State::whereId($result->state_id)->value('name') : '',
                'country' =>  $result->country_id ? \App\Models\Country::whereId($result->country_id)->value('name') : '',
                'city_id' => $result->city_id,
                'state_id' => $result->state_id,
                'country_id' => $result->country_id,
            ];
        }

        return response()->json($output);
    }

    public function getCreate(Request $request)
    {
        // \Can::access('pin_codes', 'create');

        $countries = \App\Models\Country::select('id', 'name')
            ->whereStatus(1)
            ->orderBy('name')
            ->get();

        return view('admin.state.create', compact('countries'));
    }

    public function postCreate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name'=>"required",
            'country' => 'required',
            'status' => 'nullable|in:1,0',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $dataObj = objFromPost(['name', 'country','status']);

        try {
            $state = new \App\Models\State();
            $state->name = $dataObj->name;
            $state->country_id = $dataObj->country;
            $state->status = (int)($dataObj->status == 1);
            $state->save();

            return response()->json(['message' => 'Your request processed successfully.']);
        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json(['message' => 'Failed to process your request. Please try again later.'], 422);
        }
    }

    public function getUpdate(Request $request)
    {
        // \Can::access('pin_codes', 'update');

        $state = \App\Models\State::findOrFail($request->id);

        $countries = \App\Models\Country::select('id', 'name')
            ->whereStatus(1)
            ->orderBy('name')
            ->get();

        return view('admin.state.update', compact('state', 'countries'));
    }

    public function postUpdate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name'=>"required",
            'country' => 'required',
            'status' => 'nullable|in:1,0',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $dataObj = objFromPost(['name', 'country','status']);

        try {
            $state = \App\Models\State::find($request->id);
            if (!blank($state)) {
                $state->name = $dataObj->name;
                $state->country_id = $dataObj->country;
                $state->status = (int)($dataObj->status == 1);
                $state->save();
            }

            return response()->json(['message' => 'Your request processed successfully.']);
        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json(['message' => 'Failed to process your request. Please try again later.'], 422);
        }
    }

    public function getDelete(Request $request)
    {
        // \Can::access('pin_codes', 'delete');

        \App\Models\State::whereId($request->id)->delete();
        return response()->json(['message' => 'Your request processed successfully.']);
    }

    public function getChangeStatus(Request $request)
    {
        // \Can::access('pin_codes', 'update');

        $state = \App\Models\State::findOrFail($request->id);
        if (!blank($state)) {
            $state->status = (int)!$state->status;
            $state->save();
        }

        return response()->json(['message' => 'Your request processed successfully.']);
    }

    public function getCsvImportSampleDownload(Request $request)
    {
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename= State Sample File.csv",
            'Expires' => '0',
            'Pragma' => 'public',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Country', 'Status']);
            fputcsv($file, ['Delhi', 'India', '1']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
