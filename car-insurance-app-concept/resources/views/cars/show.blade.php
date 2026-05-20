@extends('layouts.app')

@section('title', $car->full_description)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Cars</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $car->full_description }}</li>
@endsection

@section('page-header')
    <h1 class="page-title">
        <i class="fas fa-car me-2"></i>{{ $car->brand }} {{ $car->model }}
    </h1>
    <p class="page-subtitle">Vehicle Details and Insurance Information</p>
@endsection

@section('content')
<div class="row">
    <!-- Vehicle Information -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-car"></i> Vehicle Information</span>
                <div class="action-buttons">
                    <a href="{{ route('cars.edit', $car) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button onclick="confirmDelete('{{ route('cars.destroy', $car) }}', 'Are you sure you want to delete this vehicle?')"
                            class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Registration Number</label>
                        <div class="fs-5 fw-bold">{{ strtoupper($car->reg_number) }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">VIN (Vehicle ID)</label>
                        <div class="fs-5 font-monospace">{{ $car->vin ?? 'N/A' }}</div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Brand/Make</label>
                        <div><i class="fas fa-industry text-primary me-2"></i>{{ $car->brand }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Model</label>
                        <div><i class="fas fa-car-side text-primary me-2"></i>{{ $car->model }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small mb-1">Year</label>
                        <div><i class="fas fa-calendar text-primary me-2"></i>{{ $car->year ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small mb-1">Color</label>
                        <div class="d-flex align-items-center">
                            @if($car->color)
                                <div class="rounded-circle me-2" 
                                     style="width: 24px; height: 24px; background-color: {{ $car->color }}; border: 1px solid #ddd;"></div>
                            @endif
                            <span><i class="fas fa-palette text-primary me-2"></i>{{ $car->color ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small mb-1">Vehicle Type</label>
                        <div>
                            @if($car->vehicle_type)
                                <span class="badge bg-info">{{ ucfirst($car->vehicle_type) }}</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Mileage</label>
                        <div><i class="fas fa-tachometer-alt text-primary me-2"></i>{{ number_format($car->mileage ?? 0) }} km</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Registered</label>
                        <div><i class="fas fa-clock text-primary me-2"></i>{{ $car->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Owner Information -->
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-user"></i> Owner Information
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px; font-size: 1.25rem;">
                                {{ substr($car->owner->name, 0, 1) }}{{ substr($car->owner->surname, 0, 1) }}
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $car->owner->full_name }}</h5>
                                <small class="text-muted">Owner since {{ $car->owner->created_at->format('M Y') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="{{ route('owners.show', $car->owner) }}" class="btn btn-outline-primary">
                            <i class="fas fa-eye"></i> View Owner Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Insurance Policies -->
        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-file-contract"></i> Insurance Policies</span>
                <a href="{{ route('policies.create', ['car_id' => $car->id]) }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus"></i> New Policy
                </a>
            </div>
            <div class="card-body p-0">
                @if($car->policies->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Policy Number</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Premium</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($car->policies as $policy)
                                    <tr>
                                        <td>
                                            <a href="{{ route('policies.show', $policy) }}">
                                                <strong>{{ $policy->policy_number }}</strong>
                                            </a>
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'active' => 'success',
                                                    'pending' => 'warning',
                                                    'expired' => 'secondary',
                                                    'cancelled' => 'danger'
                                                ];
                                            @endphp
                                            <span class="badge bg-{{ $statusColors[$policy->status] ?? 'secondary' }}">
                                                {{ ucfirst($policy->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $policy->start_date->format('M d, Y') }}</td>
                                        <td>{{ $policy->end_date->format('M d, Y') }}</td>
                                        <td>${{ number_format($policy->total_premium, 2) }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('policies.show', $policy) }}" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('policies.edit', $policy) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state py-4">
                        <div class="empty-icon">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <div class="empty-title">No Insurance Policies</div>
                        <div class="empty-text">This vehicle doesn't have any insurance policies yet</div>
                        <a href="{{ route('policies.create', ['car_id' => $car->id]) }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Create Policy
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Quick Stats -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-bar"></i> Vehicle Stats
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Total Policies</span>
                        <strong>{{ $car->policies->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Active Policies</span>
                        <strong class="text-success">{{ $car->policies->where('status', 'active')->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Vehicle Age</span>
                        <strong>{{ $car->year ? now()->year - $car->year : 'N/A' }} years</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-bolt"></i> Quick Actions
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('policies.create', ['car_id' => $car->id]) }}" class="btn btn-success">
                        <i class="fas fa-file-contract"></i> New Policy
                    </a>
                    <a href="{{ route('quotes.create', ['car_id' => $car->id]) }}" class="btn btn-warning">
                        <i class="fas fa-calculator"></i> Get Quote
                    </a>
                    <a href="{{ route('claims.create', ['car_id' => $car->id]) }}" class="btn btn-danger">
                        <i class="fas fa-clipboard-list"></i> File Claim
                    </a>
                    <a href="{{ route('cars.edit', $car) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Vehicle
                    </a>
                </div>
            </div>
        </div>

        <!-- Information -->
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Information
            </div>
            <div class="card-body">
                <p class="small text-muted mb-2">
                    <i class="fas fa-exclamation-circle text-primary"></i>
                    Keep vehicle information up to date to ensure accurate insurance quotes and coverage.
                </p>
                <p class="small text-muted mb-0">
                    <i class="fas fa-shield-halved text-primary"></i>
                    Multiple policies can be associated with a single vehicle for different coverage types or periods.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
