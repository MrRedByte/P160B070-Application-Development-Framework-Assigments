<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Owner;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Driver::with('owner');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }
        
        // Filter by owner
        if ($request->has('owner_id') && $request->owner_id) {
            $query->where('owner_id', $request->owner_id);
        }
        
        // Filter primary drivers
        if ($request->has('primary') && $request->primary) {
            $query->where('is_primary', true);
        }
        
        // Pagination
        $drivers = $query->latest()->paginate(15);
        
        return view('drivers.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $owners = Owner::all();
        
        return view('drivers.create', compact('owners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'license_number' => 'required|string|max:50',
            'license_state' => 'nullable|string|max:50',
            'license_country' => 'nullable|string|max:50',
            'date_of_birth' => 'required|date|before:today',
            'license_expiry' => 'required|date|after:today',
            'is_primary' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['is_primary'] = $request->has('is_primary');

        Driver::create($validated);

        return redirect()->route('drivers.index')
            ->with('success', 'Driver was added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        $driver->load(['owner', 'claims']);
        
        return view('drivers.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        $owners = Owner::all();
        
        return view('drivers.edit', compact('driver', 'owners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'license_number' => 'required|string|max:50',
            'license_state' => 'nullable|string|max:50',
            'license_country' => 'nullable|string|max:50',
            'date_of_birth' => 'required|date|before:today',
            'license_expiry' => 'required|date|after:today',
            'is_primary' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['is_primary'] = $request->has('is_primary');

        $driver->update($validated);

        return redirect()->route('drivers.show', $driver)
            ->with('success', 'Driver was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        if ($driver->claims()->count() > 0) {
            return redirect()->route('drivers.show', $driver)
                ->with('error', 'Cannot delete driver with existing claims.');
        }

        $driver->delete();

        return redirect()->route('drivers.index')
            ->with('success', 'Driver was deleted successfully.');
    }
}
