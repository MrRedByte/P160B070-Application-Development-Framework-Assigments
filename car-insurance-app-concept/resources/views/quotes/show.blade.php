@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>Quote: {{ $quote->quote_number }}</span>
            <a href="{{ route('quotes.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
        <div class="card-body">
            <p><strong>Owner:</strong> {{ $quote->owner->full_name }}</p>
            <p><strong>Vehicle:</strong> {{ $quote->car->full_description }}</p>
            <p><strong>Estimated Premium:</strong> ${{ number_format($quote->estimated_premium, 2) }}</p>
            <p><strong>Status:</strong> <span class="badge bg-{{ $quote->status_badge_class }}">{{ ucfirst($quote->status) }}</span></p>
            <p><strong>Expires:</strong> {{ $quote->expires_at->format('M d, Y') }}</p>
            @if(!$quote->isConverted() && !$quote->isExpired())
                <form action="{{ route('quotes.convert', $quote) }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-success">Convert to Policy</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
