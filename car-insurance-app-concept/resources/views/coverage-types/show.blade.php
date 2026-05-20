@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>{{ $coverageType->name }}</span>
            <a href="{{ route('coverage-types.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $coverageType->description ?? 'N/A' }}</p>
            <p><strong>Base Premium:</strong> 
                @if($coverageType->type === 'percentage')
                    {{ number_format($coverageType->base_premium, 2) }}%
                @else
                    ${{ number_format($coverageType->base_premium, 2) }}
                @endif
            </p>
            <p><strong>Type:</strong> {{ ucfirst($coverageType->type) }}</p>
            <p><strong>Mandatory:</strong> {{ $coverageType->is_mandatory ? 'Yes' : 'No' }}</p>
            <p><strong>Status:</strong> {{ $coverageType->is_active ? 'Active' : 'Inactive' }}</p>
        </div>
    </div>
</div>
@endsection
