<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function setLanguage(Request $request, $lang){
        $request->session()->put('lang', $lang);
        return redirect()->back();
    }
}
