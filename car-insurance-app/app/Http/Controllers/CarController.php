<?php

namespace App\Http\Controllers;
use App\Models\Car;
use App\Models\Owner;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function create()
    {
        $owners = Owner::all();
        return view('cars.create', compact('owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reg_number' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'owner_id' => 'required|exists:owners,id'
        ]);

        Car::create($request->all());

        return redirect()->route('owners.index')
            ->with('success', 'Car was added successfully.');
    }

    public function edit(Car $car)
    {
        $owners = Owner::all();
        return view('cars.edit', compact('car', 'owners'));
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'reg_number' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'owner_id' => 'required|exists:owners,id'
        ]);

        $car->update($request->all());

        return redirect()->route('owners.index')
            ->with('success', 'Car was edited successfully.');
    }

    public function destroy(Car $car)
    {
        $car->delete();

        return redirect()->route('owners.index')
            ->with('success', 'Car was deleted successfully.');
    }
}
