<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Pincode;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use DataTables;

class PinCodeController extends Controller
{
    public function getIndex(Request $request)
    {

        return view('admin.pincode.index');
    }

    public function getList(Request $request)
    {
        $list = \App\Models\Pincode::select('pincodes.*', 'cities.name AS city')
            ->leftJoin('cities', 'cities.id', '=', 'pincodes.city_id');

        return \DataTables::of($list)->make();
    }

    public function getLocationViaPinCode(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'pincode' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $dataObj = objFromPost(['pincode']);

        $output = ['city' => '', 'state' => '', 'country' => '', 'city_id' => '', 'state_id' => '', 'country_id' => ''];

        if ($result = \App\Models\PinCode::wherePinCode($dataObj->pincode)->whereStatus(1)->first()) {
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

        $cities = \App\Models\City::select('id', 'name')
            ->whereStatus(1)
            ->orderBy('name')
            ->get();

        // $states = \App\Models\State::select('id', 'name')
        // ->whereStatus(1)
        // ->orderBy('name')
        // ->get();

        // $countries = \App\Models\Country::select('id', 'name')
        // ->whereStatus(1)
        // ->orderBy('name')
        // ->get();
        // $cities = City::all();
        return view('admin.pincode.create', compact('cities'));
    }

    public function postCreate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'pincode' => "required",
            // 'country' => 'required',
            // 'state' => 'required',
            'city' => 'required',
            'status' => 'nullable|in:1,0',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $dataObj = objFromPost(['pincode','city','status']);

        try {
            $pincode = new \App\Models\PinCode();
            $pincode->pincode = $dataObj->pincode;
            // $pincode->country_id = $dataObj->country;
            // $pincode->state_id = $dataObj->state;
            $pincode->city_id = $dataObj->city;
            $pincode->status = (int)($dataObj->status == 1);
            $pincode->save();

            return response()->json(['message' => 'Your request processed successfully.']);
        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json(['message' => 'Failed to process your request. Please try again later.',$th], 422);
        }
    }

    public function getUpdate(Request $request)
    {
        // \Can::access('pin_codes', 'update');

        $pincode = \App\Models\PinCode::findOrFail($request->id);

        $cities = \App\Models\City::select('id', 'name')
            ->whereStatus(1)
            ->orderBy('name')
            ->get();

        return view('admin.pincode.update', compact('pincode', 'cities'));
    }

    public function postUpdate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'pincode' => "required",
            // 'country' => 'required',
            // 'state' => 'required',
            'city' => 'required',
            'status' => 'nullable|in:1,0',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $dataObj = objFromPost(['pincode','city', 'status']);

        try {
            $pincode = \App\Models\PinCode::find($request->id);
            if (!blank($pincode)) {
                $pincode->pincode = $dataObj->pincode;
                // $pin_code->country_id = $dataObj->country;
                // $pin_code->state_id = $dataObj->state;
                $pincode->city_id = $dataObj->city;
                $pincode->status = (int)($dataObj->status == 1);
                $pincode->save();
            }

            return response()->json(['message' => 'Your request processed successfully.']);
        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json(['message' => 'Failed to process your request. Please try again later.'], 422);
        }
    }

    public function getDelete(Request $request)
    {
        \App\Models\Pincode::whereId($request->id)->delete();
        return response()->json(['message' => 'Your request processed successfully.']);
    }

    public function getChangeStatus(Request $request)
    {
        $pincode = \App\Models\PinCode::findOrFail($request->id);
        if (!blank($pincode)) {
            $pincode->status = (int)!$pincode->status;
            $pincode->save();
        }

        return response()->json(['message' => 'Your request processed successfully.']);
    }

    // Import CSV
    public function getCsvImport(Request $request)
    {
        return view('admin.pincode.import-csv');
    }

    public function getCsvImportSampleDownload(Request $request)
    {
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=Pincode Sample File.csv",
            'Expires' => '0',
            'Pragma' => 'public',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Pincode', 'City','Description', 'Status']);
            fputcsv($file, ['110044', 'delhi','', '1']);
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
                            'pincode' => $row[0],
                            'city_id' => $row[1],
                            // 'state_id' => $row[2],
                            // 'country_id' => $row[3],
                            // 'description' => $row[2] ?? null,
                            // 'status' => $row[3],
                        ], [
                            'pincode' => 'required|string|unique:pincodes',
                            'city_id' => 'required|exists:cities,name',
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
                        $pincode = new Pincode();
                        $pincode->pincode = $row[0];
                        $pincode->city_id = City::where('name', $row[1])->first()->id ?? null;
                        // $pincode->state_id = State::where('name', $row[2])->first()->id ?? null;
                        // $pincode->country_id = Country::where('name', $row[3])->first()->id ?? null;
                        // $pincode->description = $row[2] ?? null;
                        // $pincode->status = $row[3];
                        $pincode->save();
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
