<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Policy;
use App\Models\Driver;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Claim::with(['policy', 'driver', 'agent']);
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('claim_number', 'LIKE', "%{$request->search}%");
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by policy
        if ($request->has('policy_id') && $request->policy_id) {
            $query->where('policy_id', $request->policy_id);
        }
        
        // Pagination
        $claims = $query->latest()->paginate(15);
        
        return view('claims.index', compact('claims'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $policies = Policy::where('status', 'active')->get();
        $drivers = Driver::all();
        
        // Pre-fill policy if provided
        $policyId = $request->get('policy_id');
        
        return view('claims.create', compact('policies', 'drivers', 'policyId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'policy_id' => 'required|exists:policies,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'incident_date' => 'required|date|before_or_equal:today',
            'description' => 'required|string',
            'location' => 'nullable|string',
            'police_report_number' => 'nullable|string',
            'damage_amount' => 'nullable|numeric|min:0',
            'assigned_adjuster' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['filed_date'] = now();
        $validated['status'] = 'filed';

        $claim = Claim::create($validated);

        return redirect()->route('claims.show', $claim)
            ->with('success', 'Claim was filed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Claim $claim)
    {
        $claim->load(['policy', 'driver', 'agent']);
        
        return view('claims.show', compact('claim'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Claim $claim)
    {
        $policies = Policy::all();
        $drivers = Driver::all();
        
        return view('claims.edit', compact('claim', 'policies', 'drivers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Claim $claim)
    {
        $validated = $request->validate([
            'policy_id' => 'required|exists:policies,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'incident_date' => 'required|date|before_or_equal:today',
            'description' => 'required|string',
            'location' => 'nullable|string',
            'police_report_number' => 'nullable|string',
            'damage_amount' => 'nullable|numeric|min:0',
            'assigned_adjuster' => 'nullable|string',
            'adjuster_notes' => 'nullable|string',
        ]);

        $claim->update($validated);

        return redirect()->route('claims.show', $claim)
            ->with('success', 'Claim was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Claim $claim)
    {
        $claim->delete();

        return redirect()->route('claims.index')
            ->with('success', 'Claim was deleted successfully.');
    }

    /**
     * Approve the specified claim.
     */
    public function approve(Request $request, Claim $claim)
    {
        $validated = $request->validate([
            'payout_amount' => 'required|numeric|min:0',
        ]);

        $claim->approve($validated['payout_amount']);

        return redirect()->route('claims.show', $claim)
            ->with('success', 'Claim was approved successfully.');
    }

    /**
     * Deny the specified claim.
     */
    public function deny(Request $request, Claim $claim)
    {
        $validated = $request->validate([
            'denial_reason' => 'required|string',
        ]);

        $claim->deny($validated['denial_reason']);

        return redirect()->route('claims.show', $claim)
            ->with('success', 'Claim was denied.');
    }

    /**
     * Mark the specified claim as paid.
     */
    public function markAsPaid(Claim $claim)
    {
        $claim->markAsPaid();

        return redirect()->route('claims.show', $claim)
            ->with('success', 'Claim was marked as paid.');
    }
}
