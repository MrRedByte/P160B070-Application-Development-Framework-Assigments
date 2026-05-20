<?php

namespace App\Http\Controllers;

use App\Models\CoverageType;
use Illuminate\Http\Request;

class CoverageTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CoverageType::query();
        
        // Filter by active status
        if ($request->has('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        // Filter by mandatory
        if ($request->has('mandatory')) {
            $query->where('is_mandatory', true);
        }
        
        // Pagination
        $coverageTypes = $query->latest()->paginate(15);
        
        return view('coverage-types.index', compact('coverageTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('coverage-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:coverage_types',
            'description' => 'nullable|string',
            'base_premium' => 'required|numeric|min:0',
            'type' => 'required|in:percentage,fixed',
            'is_active' => 'nullable|boolean',
            'is_mandatory' => 'nullable|boolean',
            'requirements' => 'nullable|json',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_mandatory'] = $request->has('is_mandatory');

        CoverageType::create($validated);

        return redirect()->route('coverage-types.index')
            ->with('success', 'Coverage type was created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CoverageType $coverageType)
    {
        $coverageType->load('policies');
        
        return view('coverage-types.show', compact('coverageType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CoverageType $coverageType)
    {
        return view('coverage-types.edit', compact('coverageType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CoverageType $coverageType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:coverage_types,name,' . $coverageType->id,
            'description' => 'nullable|string',
            'base_premium' => 'required|numeric|min:0',
            'type' => 'required|in:percentage,fixed',
            'is_active' => 'nullable|boolean',
            'is_mandatory' => 'nullable|boolean',
            'requirements' => 'nullable|json',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_mandatory'] = $request->has('is_mandatory');

        $coverageType->update($validated);

        return redirect()->route('coverage-types.show', $coverageType)
            ->with('success', 'Coverage type was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoverageType $coverageType)
    {
        if ($coverageType->policies()->count() > 0) {
            return redirect()->route('coverage-types.show', $coverageType)
                ->with('error', 'Cannot delete coverage type that is used by policies.');
        }

        $coverageType->delete();

        return redirect()->route('coverage-types.index')
            ->with('success', 'Coverage type was deleted successfully.');
    }
}
