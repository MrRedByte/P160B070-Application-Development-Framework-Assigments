<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Owner;
use App\Models\Car;
use App\Models\CoverageType;
use App\Models\Policy;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Quote::with(['owner', 'car', 'agent']);
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('quote_number', 'LIKE', "%{$request->search}%");
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by owner
        if ($request->has('owner_id') && $request->owner_id) {
            $query->where('owner_id', $request->owner_id);
        }
        
        // Pagination
        $quotes = $query->latest()->paginate(15);
        
        return view('quotes.index', compact('quotes'));
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
        
        return view('quotes.create', compact('owners', 'cars', 'coverageTypes', 'ownerId', 'carId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'car_id' => 'required|exists:cars,id',
            'coverages' => 'required|array',
            'estimated_premium' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_reason' => 'nullable|string',
            'notes' => 'nullable|string',
            'expires_at' => 'nullable|date|after:today',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        $quote = Quote::create($validated);

        return redirect()->route('quotes.show', $quote)
            ->with('success', 'Quote was generated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        $quote->load(['owner', 'car', 'agent', 'policy']);
        
        return view('quotes.show', compact('quote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        $owners = Owner::all();
        $cars = Car::all();
        $coverageTypes = CoverageType::where('is_active', true)->get();
        
        return view('quotes.edit', compact('quote', 'owners', 'cars', 'coverageTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'car_id' => 'required|exists:cars,id',
            'coverages' => 'required|array',
            'estimated_premium' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_reason' => 'nullable|string',
            'notes' => 'nullable|string',
            'expires_at' => 'nullable|date|after:today',
        ]);

        $quote->update($validated);

        return redirect()->route('quotes.show', $quote)
            ->with('success', 'Quote was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        $quote->delete();

        return redirect()->route('quotes.index')
            ->with('success', 'Quote was deleted successfully.');
    }

    /**
     * Convert the quote to a policy.
     */
    public function convertToPolicy(Request $request, Quote $quote)
    {
        if ($quote->isExpired()) {
            return redirect()->route('quotes.show', $quote)
                ->with('error', 'Cannot convert expired quote.');
        }

        if ($quote->isConverted()) {
            return redirect()->route('quotes.show', $quote)
                ->with('error', 'Quote already converted to policy.');
        }

        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'payment_frequency' => 'required|in:monthly,quarterly,annually',
            'deductible' => 'nullable|numeric|min:0',
        ]);

        $policy = $quote->convertToPolicy($validated);

        return redirect()->route('policies.show', $policy)
            ->with('success', 'Quote converted to policy successfully.');
    }
}
