<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Policy;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['policy']);
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->whereHas('policy', function($q) use ($request) {
                $q->where('policy_number', 'LIKE', "%{$request->search}%");
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by policy
        if ($request->has('policy_id') && $request->policy_id) {
            $query->where('policy_id', $request->policy_id);
        }
        
        // Filter overdue
        if ($request->has('overdue') && $request->overdue) {
            $query->where('due_date', '<', now())->where('status', 'pending');
        }
        
        // Pagination
        $payments = $query->latest('due_date')->paginate(15);
        
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $policies = Policy::where('status', 'active')->get();
        
        return view('payments.create', compact('policies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'policy_id' => 'required|exists:policies,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'payment_method' => 'nullable|in:card,bank_transfer,cash,check',
            'is_recurring' => 'nullable|boolean',
            'payment_number' => 'nullable|integer|min:1',
        ]);

        $validated['status'] = 'pending';

        $payment = Payment::create($validated);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment was created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load(['policy']);
        
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $policies = Policy::all();
        
        return view('payments.edit', compact('payment', 'policies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'policy_id' => 'required|exists:policies,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'payment_method' => 'nullable|in:card,bank_transfer,cash,check',
            'notes' => 'nullable|string',
            'late_fee' => 'nullable|numeric|min:0',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment was deleted successfully.');
    }

    /**
     * Mark the payment as paid.
     */
    public function markAsPaid(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'transaction_id' => 'nullable|string',
        ]);

        $payment->markAsPaid($validated['transaction_id'] ?? null);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment was marked as paid.');
    }
}
