@extends('layouts.app')

@section('title', 'Register Car')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Cars</a></li>
    <li class="breadcrumb-item active" aria-current="page">Register Car</li>
@endsection

@section('page-header')
    <h1 class="page-title"><i class="fas fa-car me-2"></i>Register New Car</h1>
    <p class="page-subtitle">Add a new vehicle to the insurance system</p>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-car"></i> Vehicle Information
            </div>
            <div class="card-body">
                <form action="{{ route('cars.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="reg_number" class="form-label">
                                <i class="fas fa-id-card me-1"></i> Registration Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="reg_number" 
                                   id="reg_number"
                                   class="form-control @error('reg_number') is-invalid @enderror" 
                                   value="{{ old('reg_number') }}"
                                   placeholder="e.g., ABC-123"
                                   required>
                            @error('reg_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="vin" class="form-label">
                                <i class="fas fa-fingerprint me-1"></i> VIN (Vehicle Identification Number)
                            </label>
                            <input type="text" 
                                   name="vin" 
                                   id="vin"
                                   class="form-control @error('vin') is-invalid @enderror" 
                                   value="{{ old('vin') }}"
                                   placeholder="17-character VIN"
                                   maxlength="17">
                            @error('vin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">
                                <i class="fas fa-industry me-1"></i> Brand/Make <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="brand" 
                                   id="brand"
                                   class="form-control @error('brand') is-invalid @enderror" 
                                   value="{{ old('brand') }}"
                                   placeholder="e.g., Toyota, BMW, Mercedes"
                                   required>
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="model" class="form-label">
                                <i class="fas fa-car-side me-1"></i> Model <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="model" 
                                   id="model"
                                   class="form-control @error('model') is-invalid @enderror" 
                                   value="{{ old('model') }}"
                                   placeholder="e.g., Camry, X5, C-Class"
                                   required>
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="year" class="form-label">
                                <i class="fas fa-calendar me-1"></i> Year
                            </label>
                            <input type="number" 
                                   name="year" 
                                   id="year"
                                   class="form-control @error('year') is-invalid @enderror" 
                                   value="{{ old('year', date('Y')) }}"
                                   min="1900" 
                                   max="{{ date('Y') + 1 }}">
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="color" class="form-label">
                                <i class="fas fa-palette me-1"></i> Color
                            </label>
                            <input type="text" 
                                   name="color" 
                                   id="color"
                                   class="form-control @error('color') is-invalid @enderror" 
                                   value="{{ old('color') }}"
                                   placeholder="e.g., Black, White, Silver">
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="mileage" class="form-label">
                                <i class="fas fa-tachometer-alt me-1"></i> Mileage (km)
                            </label>
                            <input type="number" 
                                   name="mileage" 
                                   id="mileage"
                                   class="form-control @error('mileage') is-invalid @enderror" 
                                   value="{{ old('mileage', 0) }}"
                                   min="0">
                            @error('mileage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="vehicle_type" class="form-label">
                                <i class="fas fa-car me-1"></i> Vehicle Type
                            </label>
                            <select name="vehicle_type" 
                                    id="vehicle_type"
                                    class="form-select @error('vehicle_type') is-invalid @enderror">
                                <option value="">Select Type</option>
                                <option value="sedan" {{ old('vehicle_type') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                                <option value="suv" {{ old('vehicle_type') == 'suv' ? 'selected' : '' }}>SUV</option>
                                <option value="hatchback" {{ old('vehicle_type') == 'hatchback' ? 'selected' : '' }}>Hatchback</option>
                                <option value="coupe" {{ old('vehicle_type') == 'coupe' ? 'selected' : '' }}>Coupe</option>
                                <option value="convertible" {{ old('vehicle_type') == 'convertible' ? 'selected' : '' }}>Convertible</option>
                                <option value="wagon" {{ old('vehicle_type') == 'wagon' ? 'selected' : '' }}>Wagon</option>
                                <option value="truck" {{ old('vehicle_type') == 'truck' ? 'selected' : '' }}>Truck</option>
                                <option value="van" {{ old('vehicle_type') == 'van' ? 'selected' : '' }}>Van</option>
                                <option value="motorcycle" {{ old('vehicle_type') == 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                                <option value="other" {{ old('vehicle_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('vehicle_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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
                                    <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                                        {{ $owner->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('owner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Register Car
                        </button>
                        <a href="{{ route('cars.index') }}" class="btn btn-secondary">
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
                <h6><i class="fas fa-exclamation-circle text-primary"></i> Required Fields</h6>
                <p class="small text-muted mb-3">Fields marked with <span class="text-danger">*</span> are required for vehicle registration.</p>
                
                <h6><i class="fas fa-id-card text-primary"></i> VIN Information</h6>
                <p class="small text-muted mb-3">The Vehicle Identification Number (VIN) is a unique 17-character code that identifies the vehicle.</p>
                
                <h6><i class="fas fa-shield-halved text-primary"></i> Insurance</h6>
                <p class="small text-muted">After registering the vehicle, you can create insurance policies for it.</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-lightbulb text-warning"></i> Tips
            </div>
            <div class="card-body">
                <ul class="small text-muted mb-0">
                    <li>Ensure the registration number matches the official vehicle documents</li>
                    <li>Double-check the VIN for accuracy</li>
                    <li>Accurate vehicle information helps with quote calculations</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
