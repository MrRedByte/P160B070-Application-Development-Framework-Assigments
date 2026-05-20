@extends('layouts.app')

@section('title', 'File Claim')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('claims.index') }}">Claims</a></li>
    <li class="breadcrumb-item active" aria-current="page">File Claim</li>
@endsection

@section('page-header')
    <h1 class="page-title"><i class="fas fa-clipboard-list me-2"></i>File New Claim</h1>
    <p class="page-subtitle">Report an insurance claim</p>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-clipboard-list"></i> Claim Information
            </div>
            <div class="card-body">
                <form action="{{ route('claims.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="policy_id" class="form-label">
                                <i class="fas fa-file-contract me-1"></i> Policy <span class="text-danger">*</span>
                            </label>
                            <select name="policy_id" 
                                    id="policy_id"
                                    class="form-select @error('policy_id') is-invalid @enderror"
                                    required>
                                <option value="">Select Policy</option>
                                @foreach($policies as $policy)
                                    <option value="{{ $policy->id }}" {{ old('policy_id', $policyId) == $policy->id ? 'selected' : '' }}>
                                        {{ $policy->policy_number }} - {{ $policy->car->full_description }}
                                    </option>
                                @endforeach
                            </select>
                            @error('policy_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="driver_id" class="form-label">
                                <i class="fas fa-user me-1"></i> Driver (Optional)
                            </label>
                            <select name="driver_id" 
                                    id="driver_id"
                                    class="form-select @error('driver_id') is-invalid @enderror">
                                <option value="">Select Driver</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('driver_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="incident_date" class="form-label">
                                <i class="fas fa-calendar-alt me-1"></i> Incident Date & Time <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" 
                                   name="incident_date" 
                                   id="incident_date"
                                   class="form-control @error('incident_date') is-invalid @enderror" 
                                   value="{{ old('incident_date') }}"
                                   required>
                            @error('incident_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label">
                                <i class="fas fa-map-marker-alt me-1"></i> Location
                            </label>
                            <input type="text" 
                                   name="location" 
                                   id="location"
                                   class="form-control @error('location') is-invalid @enderror" 
                                   value="{{ old('location') }}"
                                   placeholder="Where did the incident occur?">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-1"></i> Description <span class="text-danger">*</span>
                        </label>
                        <textarea name="description" 
                                  id="description"
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="4"
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="police_report_number" class="form-label">
                                <i class="fas fa-file-alt me-1"></i> Police Report Number
                            </label>
                            <input type="text" 
                                   name="police_report_number" 
                                   id="police_report_number"
                                   class="form-control @error('police_report_number') is-invalid @enderror" 
                                   value="{{ old('police_report_number') }}">
                            @error('police_report_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="damage_amount" class="form-label">
                                <i class="fas fa-dollar-sign me-1"></i> Estimated Damage Amount
                            </label>
                            <input type="number" 
                                   name="damage_amount" 
                                   id="damage_amount"
                                   class="form-control @error('damage_amount') is-invalid @enderror" 
                                   value="{{ old('damage_amount', 0) }}"
                                   step="0.01"
                                   min="0">
                            @error('damage_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-save me-1"></i> File Claim
                        </button>
                        <a href="{{ route('claims.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
