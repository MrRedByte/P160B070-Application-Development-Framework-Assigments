<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BmiController extends Controller
{
    public function index() {
        return view('bmi');
    }

    public function calculate(Request $request) {
        $request->validate([
            'weight' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:0.5'
        ]);

        $weight = $request->weight;
        $height = $request->height;

        $bmi = $weight / ($height * $height);
        $bmi = round($bmi, 2);

        return view('bmi', compact('bmi'));
    }
}
