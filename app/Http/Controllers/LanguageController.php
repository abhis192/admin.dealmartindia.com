<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Currency;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        if (array_key_exists($lang, Config::get('languages'))) {
            Session::put('applocale', $lang);        }
        return Redirect::back();
    }

    public function switchCurr($id)
    {
        $currCode = Currency::findOrFail($id);
        if ($currCode) {
            Session::put('currency', $currCode->currency_code);
            Session::put('currency_symbol', $currCode->currency_symbol);
        }
        return Redirect::back();
    }
}
