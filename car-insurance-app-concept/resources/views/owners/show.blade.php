@extends('layouts.app')

@section('title', $owner->full_name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('owners.index') }}">Owners</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $owner->full_name }}</li>
@endsection

@section('page-header')
    <h1 class="page-title"><i class="fas fa-user me-2"></i>{{ $owner->full_name }}</h1>
    <p class="page-subtitle">Owner Profile and Insurance Information</p>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-user"></i> Owner Information</span>
                <div class="action-buttons">
                    <a href="{{ route('owners.edit', $owner) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button onclick="confirmDelete('{{ route('owners.destroy', $owner) }}', 'Are you sure you want to delete this owner?')"
                            class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small mb-1">Full Name</label>
                        <div class="fs-5 fw-bold">{{ $owner->full_name }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-1">Email</label>
                        <div>
                            @if($owner->email)
                                <i class="fas fa-envelope text-primary me-1"></i>
                                <a href="mailto:{{ $owner->email }}">{{ $owner->email }}</a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small mb-1">Phone</label>
                        <div>
                            @if($owner->phone)
                                <i class="fas fa-phone text-primary me-1"></i>
                                <a href="tel:{{ $owner->phone }}">{{ $owner->phone }}</a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-1">Date of Birth</label>
                        <div>
                            @if($owner->date_of_birth)
                                <i class="fas fa-calendar-alt text-primary me-1"></i>
                                {{ $owner->date_of_birth->format('M d, Y') }}
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($owner->address)
                    <div class="mb-3">
                        <label class="text-muted small mb-1">Address</label>
                        <div><i class="fas fa-map-marker-alt text-primary me-1"></i>{{ $owner->address }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Cars -->
        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-car"></i> Vehicles ({{ $owner->cars->count() }})</span>
                <a href="{{ route('cars.create') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus"></i> Add Car
                </a>
            </div>
            <div class="card-body p-0">
                @if($owner->cars->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Registration</th>
                                    <th>Vehicle</th>
                                    <th>Year</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($owner->cars as $car)
                                    <tr>
                                        <td>{{ strtoupper($car->reg_number) }}</td>
                                        <td>{{ $car->full_description }}</td>
                                        <td>{{ $car->year ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('cars.show', $car) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state py-4">
                        <div class="empty-icon"><i class="fas fa-car"></i></div>
                        <div class="empty-title">No Vehicles</div>
                        <div class="empty-text">This owner doesn't have any vehicles registered</div>
                        <a href="{{ route('cars.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Register Car
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Policies -->
        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-file-contract"></i> Policies ({{ $owner->policies->count() }})</span>
                <a href="{{ route('policies.create', ['owner_id' => $owner->id]) }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus"></i> New Policy
                </a>
            </div>
            <div class="card-body p-0">
                @if($owner->policies->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Policy #</th>
                                    <th>Vehicle</th>
                                    <th>Status</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($owner->policies->take(5) as $policy)
                                    <tr>
                                        <td>
                                            <a href="{{ route('policies.show', $policy) }}">
                                                <strong>{{ $policy->policy_number }}</strong>
                                            </a>
                                        </td>
                                        <td>{{ $policy->car->full_description }}</td>
                                        <td>
                                            <span class="badge bg-{{ $policy->status === 'active' ? 'success' : 'warning' }}">
                                                {{ ucfirst($policy->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $policy->end_date->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state py-4">
                        <div class="empty-icon"><i class="fas fa-file-contract"></i></div>
                        <div class="empty-title">No Policies</div>
                        <div class="empty-text">This owner doesn't have any insurance policies</div>
                        <a href="{{ route('policies.create', ['owner_id' => $owner->id]) }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Create Policy
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card stat-card">
            <div class="card-header">
                <i class="fas fa-bolt"></i> Quick Actions
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('cars.create') }}" class="btn btn-success">
                        <i class="fas fa-car"></i> Register Car
                    </a>
                    <a href="{{ route('policies.create', ['owner_id' => $owner->id]) }}" class="btn btn-primary">
                        <i class="fas fa-file-contract"></i> New Policy
                    </a>
                    <a href="{{ route('quotes.create', ['owner_id' => $owner->id]) }}" class="btn btn-warning">
                        <i class="fas fa-calculator"></i> Get Quote
                    </a>
                    <a href="{{ route('drivers.create', ['owner_id' => $owner->id]) }}" class="btn btn-info">
                        <i class="fas fa-user-plus"></i> Add Driver
                    </a>
                    <a href="{{ route('owners.edit', $owner) }}" class="btn btn-secondary">
                        <i class="fas fa-edit"></i> Edit Owner
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-chart-bar"></i> Summary
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Total Cars</span>
                        <strong>{{ $owner->cars->count() }}</strong>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Active Policies</span>
                        <strong class="text-success">{{ $owner->policies->where('status', 'active')->count() }}</strong>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Total Drivers</span>
                        <strong>{{ $owner->drivers->count() }}</strong>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Pending Quotes</span>
                        <strong class="text-warning">{{ $owner->quotes->where('status', 'pending')->count() }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Information
            </div>
            <div class="card-body">
                <p class="small text-muted mb-2">
                    <strong>Owner Since:</strong> {{ $owner->created_at->format('M d, Y') }}
                </p>
                <p class="small text-muted mb-0">
                    <strong>Last Updated:</strong> {{ $owner->updated_at->format('M d, Y') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
