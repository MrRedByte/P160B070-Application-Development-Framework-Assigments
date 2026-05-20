@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>{{ $driver->full_name }}</span>
            <a href="{{ route('drivers.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
        <div class="card-body">
            <p><strong>Owner:</strong> {{ $driver->owner->full_name }}</p>
            <p><strong>License:</strong> {{ $driver->license_number }}</p>
            <p><strong>Date of Birth:</strong> {{ $driver->date_of_birth->format('M d, Y') }} ({{ $driver->age }} years old)</p>
            <p><strong>License Expiry:</strong> {{ $driver->license_expiry->format('M d, Y') }}</p>
            <p><strong>Primary Driver:</strong> {{ $driver->is_primary ? 'Yes' : 'No' }}</p>
        </div>
    </div>
</div>
@endsection
