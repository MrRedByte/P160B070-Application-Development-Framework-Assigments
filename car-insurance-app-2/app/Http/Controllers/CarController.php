<?php

namespace App\Http\Controllers;
use App\Http\Requests\CarRequest;
use App\Models\Car;
use App\Models\Owner;
use Illuminate\Http\Request;
use App\Models\CarPhoto;
class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
        $owners = Owner::all();
        return view('cars.create', compact('owners'));
    }

    public function store(CarRequest $request)
    {
        $request->validate([
            'reg_number' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'owner_id' => 'required|exists:owners,id'
        ]);

        Car::create($request->all());

        return redirect()->route('insurance')
            ->with('success', 'Car was added successfully.');
    }

    public function edit(Car $car)
    {
        $owners = Owner::all();
        return view('cars.edit', compact('car', 'owners'));
    }

    public function update(CarRequest $request, Car $car)
    {
        $request->validate([
            'reg_number' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'owner_id' => 'required|exists:owners,id'
        ]);

        $car->update($request->all());

        return redirect()->route('insurance')
            ->with('success', 'Car was edited successfully.');
    }

    public function destroy(Car $car)
    {
        $car->delete();

        return redirect()->route('insurance')
            ->with('success', 'Car was deleted successfully.');
    }

    public function uploadPhotos(Request $request, $id)
    {
        $request->validate([
            'photos.*' => 'image|max:2048'
        ]);

        $car = Car::findOrFail($id);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('cars', 'public');

                $car->photos()->create([
                    'path' => $path
                ]);
            }
        }

        return back();
    }

    public function deletePhoto($id)
    {
        $photo = CarPhoto::findOrFail($id);

        \Storage::disk('public')->delete($photo->path);

        $photo->delete();

        return back();
    }
}
