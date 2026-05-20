@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Add Driver</div>
        <div class="card-body">
            <form action="{{ route('drivers.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Owner</label>
                    <select name="owner_id" class="form-control" required>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->id }}">{{ $owner->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>License Number</label>
                    <input type="text" name="license_number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>License Expiry</label>
                    <input type="date" name="license_expiry" class="form-control" required>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="is_primary" class="form-check-input" id="is_primary">
                    <label class="form-check-label" for="is_primary">Primary Driver</label>
                </div>
                <button class="btn btn-success">Add Driver</button>
            </form>
        </div>
    </div>
</div>
@endsection
