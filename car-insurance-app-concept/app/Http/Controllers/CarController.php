<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Owner;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Car::with('owner');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reg_number', 'LIKE', "%{$search}%")
                  ->orWhere('brand', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%")
                  ->orWhere('vin', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter by vehicle type
        if ($request->has('vehicle_type') && $request->vehicle_type) {
            $query->where('vehicle_type', $request->vehicle_type);
        }
        
        // Pagination
        $cars = $query->latest()->paginate(15);
        
        return view('cars.index', compact('cars'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        $car->load(['owner', 'policies.coverages.coverageType']);
        
        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $owners = Owner::all();
        return view('cars.create', compact('owners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reg_number' => 'required|string|max:50|unique:cars',
            'vin' => 'nullable|string|max:17|unique:cars',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'nullable|string|max:50',
            'vehicle_type' => 'nullable|string|max:50',
            'mileage' => 'nullable|integer|min:0',
            'owner_id' => 'required|exists:owners,id',
        ]);

        Car::create($validated);

        return redirect()->route('cars.index')
            ->with('success', 'Car was registered successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        $owners = Owner::all();
        return view('cars.edit', compact('car', 'owners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'reg_number' => 'required|string|max:50|unique:cars,reg_number,' . $car->id,
            'vin' => 'nullable|string|max:17|unique:cars,vin,' . $car->id,
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'nullable|string|max:50',
            'vehicle_type' => 'nullable|string|max:50',
            'mileage' => 'nullable|integer|min:0',
            'owner_id' => 'required|exists:owners,id',
        ]);

        $car->update($validated);

        return redirect()->route('cars.show', $car)
            ->with('success', 'Car was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        if ($car->policies()->count() > 0) {
            return redirect()->route('cars.show', $car)
                ->with('error', 'Cannot delete car with existing policies.');
        }

        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', 'Car was deleted successfully.');
    }
}
