<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConfigGeneral;
use Illuminate\Http\Request;

class ConfigurationApiController extends Controller
{
    // show data of config_general table
   public function list(){
    $configurations = ConfigGeneral::all();

    foreach ($configurations as $key => $configuration) {
        $configurations[$key]['logo'] = '/storage/setting/' . $configuration->logo;
        $configurations[$key]['icon'] = '/storage/setting/' . $configuration->icon;
    }

    return $configurations;
   }
}
