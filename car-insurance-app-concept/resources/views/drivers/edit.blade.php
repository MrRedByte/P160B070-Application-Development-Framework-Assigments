@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Edit Driver</div>
        <div class="card-body">
            <form action="{{ route('drivers.update', $driver) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ $driver->first_name }}" required>
                </div>
                <div class="mb-3">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ $driver->last_name }}" required>
                </div>
                <div class="mb-3">
                    <label>License Number</label>
                    <input type="text" name="license_number" class="form-control" value="{{ $driver->license_number }}" required>
                </div>
                <div class="mb-3">
                    <label>License Expiry</label>
                    <input type="date" name="license_expiry" class="form-control" value="{{ $driver->license_expiry->format('Y-m-d') }}" required>
                </div>
                <button class="btn btn-primary">Update Driver</button>
            </form>
        </div>
    </div>
</div>
@endsection
