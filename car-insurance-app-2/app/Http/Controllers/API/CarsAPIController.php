<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarsAPIController extends Controller
{
    public function index()
    {
        return Car::with('owner')->get();
    }

    public function show($id)
    {
        return Car::with('owner')->find($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'reg_number' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'owner_id' => 'required|exists:owners,id'
        ]);

        $car = new Car();

        $car->reg_number = $request->reg_number;
        $car->brand = $request->brand;
        $car->model = $request->model;
        $car->owner_id = $request->owner_id;

        $car->save();

        return $car;
    }

    public function update(Request $request, $id)
    {
        $car = Car::find($id);

        $car->reg_number = $request->reg_number;
        $car->brand = $request->brand;
        $car->model = $request->model;
        $car->owner_id = $request->owner_id;

        $car->save();

        return $car;
    }

    public function destroy($id)
    {
        Car::destroy($id);

        return $id;
    }
}
