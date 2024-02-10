<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AreaImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            $country = \App\Models\Country::whereName($row['country'])->value('id');
            $state = \App\Models\State::whereName($row['state'])->whereCountryId($country)->value('id');
            $city = \App\Models\City::whereName($row['city'])->whereStateId($state)->whereCountryId($country)->value('id');
            $pincode = \App\Models\Pincode::wherePincode($row['pincode'])->whereCityId($city)->whereStateId($state)->whereCountryId($country)->value('id');


            if ($pincode && $city && $state && $country) {
                $area = new \App\Models\Area();
                $area->name =  $row['name'];
                $area->pincode_id =  $pincode;
                $area->city_id =  $city;
                $area->state_id =  $state;
                $area->country_id =  $country;
                // $area->status = 1;
                $area->status =  $row['status'] == 'Yes' ? 1 : 0;
                $area->save();

                return $area;
            }
        } catch (\Throwable $th) {
            \Log::error($th);
        }

        return false;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:200',
            'pincode' => 'required|max:200|exists:pincodes,pincode',
            'city' => 'required|max:200|exists:cities,name',
            'state' => 'required|max:200|exists:states,name',
            'country' => 'required|max:200|exists:countries,name',
            'status' => 'required|in:Yes,No',
        ];
    }
}
