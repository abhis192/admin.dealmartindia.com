<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pincode;
use App\Models\Area;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use DB;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    public function getIndex(Request $request)
    {
        // \Can::access('pin_codes');

        return view('admin.area.index');
    }

    public function getList(Request $request)
    {
        $list = \App\Models\Area::select('areas.*', 'pincodes.pincode AS pincode', 'cities.name AS city', 'states.name AS state', 'countries.name AS country')
            ->leftJoin('pincodes', 'pincodes.id', '=', 'areas.pincode_id')
            ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
            ->leftJoin('states', 'states.id', '=', 'areas.state_id')
            ->leftJoin('countries', 'countries.id', '=', 'areas.country_id');

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

        return view('admin.area.create', compact('countries'));
    }

    public function postCreate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name'=>"required",
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => "required",
            'status' => 'nullable|in:1,0',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $dataObj = objFromPost(['name', 'country', 'state', 'city','pincode', 'status']);

        try {
            $area = new \App\Models\Area();
            $area->name = $dataObj->name;
            $area->country_id = $dataObj->country;
            $area->state_id = $dataObj->state;
            $area->city_id = $dataObj->city;
            $area->pincode_id = $dataObj->pincode;
            $area->status = (int)($dataObj->status == 1);
            $area->save();

            return response()->json(['message' => 'Your request processed successfully.']);
        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json(['message' => 'Failed to process your request. Please try again later.'], 422);
        }
    }

    public function getUpdate(Request $request)
    {
        // \Can::access('pin_codes', 'update');

        $area = \App\Models\Area::findOrFail($request->id);
        // $pin_code = \App\Models\PinCode::findOrFail($request->id);

        $countries = \App\Models\Country::select('id', 'name')
            ->whereStatus(1)
            ->orderBy('name')
            ->get();

        return view('admin.area.update', compact('area', 'countries'));
    }

    public function postUpdate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name'=>"required",
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => "required",
            'status' => 'nullable|in:1,0',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $dataObj = objFromPost(['name', 'country', 'state', 'city','pincode', 'status']);

        try {
            $area = \App\Models\Area::find($request->id);
            if (!blank($area)) {
                $area->name = $dataObj->name;
                $area->country_id = $dataObj->country;
                $area->state_id = $dataObj->state;
                $area->city_id = $dataObj->city;
                $area->pincode_id = $dataObj->pincode;
                $area->status = (int)($dataObj->status == 1);
                $area->save();
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

        \App\Models\Area::whereId($request->id)->delete();
        return response()->json(['message' => 'Your request processed successfully.']);
    }

    public function getChangeStatus(Request $request)
    {
        // \Can::access('pin_codes', 'update');

        $area = \App\Models\Area::findOrFail($request->id);
        if (!blank($area)) {
            $area->status = (int)!$area->status;
            $area->save();
        }

        return response()->json(['message' => 'Your request processed successfully.']);
    }

    // Import CSV
    public function getCsvImport(Request $request)
    {
        return view('admin.area.import-csv');
    }

    public function getCsvImportSampleDownload(Request $request)
    {
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=Area Sample File.csv",
            'Expires' => '0',
            'Pragma' => 'public',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Pincode', 'City', 'State', 'Country', 'Status']);
            fputcsv($file, ['Jaitpur', '110044', 'Badarpur', 'Delhi', 'India', '1']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // public function postCsvImport(Request $request)
    // {
    //     $validator = \Validator::make($request->all(), [
    //         'csv_file' => 'required|mimes:csv,txt',
    //     ])->stopOnFirstFailure(true);
    //     if ($validator->fails()) {
    //         return response()->json(['message' => $validator->errors()->first()], 422);
    //     }

    //     try {
    //         \Excel::import(new \App\Imports\AreaImport, $request->csv_file);
    //         return response()->json(['message' => 'Your request processed successfully.']);
    //     } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
    //         foreach ($e->failures() as $failure) {
    //             return response()->json(['message' => "{$failure->errors()[0]} for row no. {$failure->row()}"], 422);
    //         }
    //     } catch (\Throwable $th) {
    //         \Log::error($th);
    //         return response()->json(['message' => 'Failed to process your request. Please try again later.'], 422);
    //     }
    // }

    public function postCsvImport(Request $request)
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
                            'name'=>$row[0],
                            'pincode_id' => $row[1],
                            'city_id' => $row[2],
                            'state_id' => $row[3],
                            'country_id' => $row[4],
                            // // 'description' => $row[2] ?? null,
                            'status' => $row[5],
                        ], [
                            // 'pincode' => 'required|string|unique:pincodes',
                            // 'city_id' => 'required|exists:cities,name',
                            // 'description' => 'nullable|string',
                            // 'status' => 'nullable'
                        ]);

                        // Check if validation fails for this row
                        if ($validation->fails()) {
                            DB::rollBack(); // Roll back the transaction.
                            $errors = $validation->errors();
                            return redirect()->back()->with('failure', 'Validation failed for CSV row ' . ($key + 1) . ': ' . $errors->first());
                        }

                        // If validation passes, create and save a new Pincode
                        $area = new Area();
                        $area->name = $row[0];
                        $area->pincode_id = Pincode::where('pincode', $row[1])->first()->id ?? null;
                        $area->city_id = City::where('name', $row[2])->first()->id ?? null;
                        $area->state_id = State::where('name', $row[3])->first()->id ?? null;
                        $area->country_id = Country::where('name', $row[4])->first()->id ?? null;
                        // // $area->description = $row[2] ?? null;
                        $area->status = $row[5];
                        $area->save();
                    }
                }
            }

            DB::commit(); // Commit the transaction if everything is successful.
            return redirect()->back()->with('success', 'CSV imported successfully.');
        } catch (\Exception $e) {
            DB::rollBack(); // Roll back the transaction on any other exception.
            return redirect()->back()->with('failure', 'An error occurred. Please check all the fields.',$e);
        }
    }



    public function getCountryWiseList(Request $request)
    {
        $list = \App\Models\State::select('id', 'name')->whereCountryId($request->country_id)->get();
        return response()->json($list);
    }

    public function getStateWiseList(Request $request)
    {
        $list = \App\Models\City::select('id', 'name')->whereStateId($request->state_id)->get();
        return response()->json($list);
    }

    public function getCityWiseList(Request $request)
    {
        $list = \App\Models\Pincode::select('id', 'pincode')->whereCityId($request->city_id)->get();
        return response()->json($list);
    }
}
