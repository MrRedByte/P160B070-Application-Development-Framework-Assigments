<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index() {
        return view('calculator');
    }

    public function result (Request $request){
        $sum=$request->x+$request->y;

        return view('result', ['sum'=>$sum]);
    }
}
