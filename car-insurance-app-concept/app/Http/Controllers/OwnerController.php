<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Owner::with('cars');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }
        
        // Pagination
        $owners = $query->latest()->paginate(15);
        
        return view('owners.index', compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'email' => 'nullable|email|max:255|unique:owners',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date|before:today',
        ]);

        Owner::create($validated);

        return redirect()->route('owners.index')
            ->with('success', 'Owner was created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Owner $owner)
    {
        $owner->load(['cars', 'policies', 'drivers', 'quotes']);
        
        return view('owners.show', compact('owner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Owner $owner)
    {
        return view('owners.edit', compact('owner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Owner $owner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'email' => 'nullable|email|max:255|unique:owners,email,' . $owner->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date|before:today',
        ]);

        $owner->update($validated);

        return redirect()->route('owners.show', $owner)
            ->with('success', 'Owner was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Owner $owner)
    {
        if ($owner->policies()->count() > 0) {
            return redirect()->route('owners.show', $owner)
                ->with('error', 'Cannot delete owner with existing policies.');
        }

        $owner->delete();

        return redirect()->route('owners.index')
            ->with('success', 'Owner was deleted successfully.');
    }
}
