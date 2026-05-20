<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\Owner;
use App\Models\Car;
use App\Models\CoverageType;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Policy::with(['owner', 'car', 'agent']);
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('policy_number', 'LIKE', "%{$request->search}%");
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by car
        if ($request->has('car_id') && $request->car_id) {
            $query->where('car_id', $request->car_id);
        }
        
        // Pagination
        $policies = $query->latest()->paginate(15);
        
        return view('policies.index', compact('policies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $owners = Owner::all();
        $cars = Car::all();
        $coverageTypes = CoverageType::where('is_active', true)->get();
        
        // Pre-fill owner and car if provided
        $ownerId = $request->get('owner_id');
        $carId = $request->get('car_id');
        
        return view('policies.create', compact('owners', 'cars', 'coverageTypes', 'ownerId', 'carId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'payment_frequency' => 'required|in:monthly,quarterly,annually',
            'deductible' => 'nullable|numeric|min:0',
            'total_premium' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        $policy = Policy::create($validated);

        return redirect()->route('policies.show', $policy)
            ->with('success', 'Policy was created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Policy $policy)
    {
        $policy->load(['owner', 'car', 'coverages', 'claims', 'payments']);
        
        return view('policies.show', compact('policy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Policy $policy)
    {
        $owners = Owner::all();
        $cars = Car::all();
        $coverageTypes = CoverageType::where('is_active', true)->get();
        
        return view('policies.edit', compact('policy', 'owners', 'cars', 'coverageTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Policy $policy)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'payment_frequency' => 'required|in:monthly,quarterly,annually',
            'deductible' => 'nullable|numeric|min:0',
            'total_premium' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $policy->update($validated);

        return redirect()->route('policies.show', $policy)
            ->with('success', 'Policy was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Policy $policy)
    {
        if ($policy->claims()->count() > 0) {
            return redirect()->route('policies.show', $policy)
                ->with('error', 'Cannot delete policy with existing claims.');
        }

        $policy->delete();

        return redirect()->route('policies.index')
            ->with('success', 'Policy was deleted successfully.');
    }

    /**
     * Activate the specified policy.
     */
    public function activate(Policy $policy)
    {
        $policy->activate();

        return redirect()->route('policies.show', $policy)
            ->with('success', 'Policy was activated successfully.');
    }

    /**
     * Cancel the specified policy.
     */
    public function cancel(Request $request, Policy $policy)
    {
        $validated = $request->validate([
            'cancellation_reason' => 'required|string',
        ]);

        $policy->cancel($validated['cancellation_reason']);

        return redirect()->route('policies.show', $policy)
            ->with('success', 'Policy was cancelled successfully.');
    }
}
