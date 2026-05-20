@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>Payment Details</span>
            <a href="{{ route('payments.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
        <div class="card-body">
            <p><strong>Policy:</strong> {{ $payment->policy->policy_number }}</p>
            <p><strong>Amount:</strong> ${{ number_format($payment->amount, 2) }}</p>
            <p><strong>Status:</strong> <span class="badge bg-{{ $payment->status_badge_class }}">{{ ucfirst($payment->status) }}</span></p>
            <p><strong>Due Date:</strong> {{ $payment->due_date->format('M d, Y') }}</p>
            @if($payment->status === 'pending')
                <form action="{{ route('payments.mark-paid', $payment) }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-success">Mark as Paid</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
