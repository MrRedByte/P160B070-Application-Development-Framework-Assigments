@extends('layouts.app')

@section('title', 'Create Policy')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('policies.index') }}">Policies</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Policy</li>
@endsection

@section('page-header')
    <h1 class="page-title"><i class="fas fa-file-contract me-2"></i>Create New Policy</h1>
    <p class="page-subtitle">Create a new insurance policy</p>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-file-contract"></i> Policy Information
            </div>
            <div class="card-body">
                <form action="{{ route('policies.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="owner_id" class="form-label">
                                <i class="fas fa-user me-1"></i> Owner <span class="text-danger">*</span>
                            </label>
                            <select name="owner_id" 
                                    id="owner_id"
                                    class="form-select @error('owner_id') is-invalid @enderror"
                                    required>
                                <option value="">Select Owner</option>
                                @foreach($owners as $owner)
                                    <option value="{{ $owner->id }}" {{ old('owner_id', $ownerId) == $owner->id ? 'selected' : '' }}>
                                        {{ $owner->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('owner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="car_id" class="form-label">
                                <i class="fas fa-car me-1"></i> Vehicle <span class="text-danger">*</span>
                            </label>
                            <select name="car_id" 
                                    id="car_id"
                                    class="form-select @error('car_id') is-invalid @enderror"
                                    required>
                                <option value="">Select Vehicle</option>
                                @foreach($cars as $car)
                                    <option value="{{ $car->id }}" {{ old('car_id', $carId) == $car->id ? 'selected' : '' }}>
                                        {{ $car->full_description }} ({{ $car->reg_number }})
                                    </option>
                                @endforeach
                            </select>
                            @error('car_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">
                                <i class="fas fa-calendar-alt me-1"></i> Start Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   name="start_date" 
                                   id="start_date"
                                   class="form-control @error('start_date') is-invalid @enderror" 
                                   value="{{ old('start_date', date('Y-m-d')) }}"
                                   required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">
                                <i class="fas fa-calendar-alt me-1"></i> End Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   name="end_date" 
                                   id="end_date"
                                   class="form-control @error('end_date') is-invalid @enderror" 
                                   value="{{ old('end_date', date('Y-m-d', strtotime('+1 year'))) }}"
                                   required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="payment_frequency" class="form-label">
                                <i class="fas fa-sync-alt me-1"></i> Payment Frequency <span class="text-danger">*</span>
                            </label>
                            <select name="payment_frequency" 
                                    id="payment_frequency"
                                    class="form-select @error('payment_frequency') is-invalid @enderror"
                                    required>
                                <option value="">Select Frequency</option>
                                <option value="monthly" {{ old('payment_frequency') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="quarterly" {{ old('payment_frequency') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                <option value="annually" {{ old('payment_frequency') == 'annually' ? 'selected' : '' }}>Annually</option>
                            </select>
                            @error('payment_frequency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="total_premium" class="form-label">
                                <i class="fas fa-dollar-sign me-1"></i> Total Premium
                            </label>
                            <input type="number" 
                                   name="total_premium" 
                                   id="total_premium"
                                   class="form-control @error('total_premium') is-invalid @enderror" 
                                   value="{{ old('total_premium', 0) }}"
                                   step="0.01"
                                   min="0">
                            @error('total_premium')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="deductible" class="form-label">
                            <i class="fas fa-hand-holding-usd me-1"></i> Deductible
                        </label>
                        <input type="number" 
                               name="deductible" 
                               id="deductible"
                               class="form-control @error('deductible') is-invalid @enderror" 
                               value="{{ old('deductible', 0) }}"
                               step="0.01"
                               min="0">
                        @error('deductible')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">
                            <i class="fas fa-sticky-note me-1"></i> Notes
                        </label>
                        <textarea name="notes" 
                                  id="notes"
                                  class="form-control @error('notes') is-invalid @enderror" 
                                  rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Create Policy
                        </button>
                        <a href="{{ route('policies.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Information
            </div>
            <div class="card-body">
                <p class="small text-muted mb-0">
                    <i class="fas fa-exclamation-circle text-primary"></i>
                    Fields marked with <span class="text-danger">*</span> are required.
                </p>
                <hr>
                <p class="small text-muted mb-0">
                    <i class="fas fa-shield-halved text-primary"></i>
                    After creating the policy, you can add coverage types and activate it.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
