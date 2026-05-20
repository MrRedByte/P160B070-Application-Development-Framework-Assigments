@extends('layouts.app')

@section('title', 'Drivers')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Drivers</li>
@endsection

@section('page-header')
    <h1 class="page-title"><i class="fas fa-id-card me-2"></i>Drivers</h1>
    <p class="page-subtitle">Manage additional drivers</p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('drivers.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Search by name or license..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check mt-2">
                        <input type="checkbox" 
                               name="primary" 
                               id="primary"
                               class="form-check-input"
                               value="1"
                               {{ request('primary') ? 'checked' : '' }}>
                        <label class="form-check-label" for="primary">
                            Primary Drivers Only
                        </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Driver</th>
                        <th>Owner</th>
                        <th>License Number</th>
                        <th>License Expiry</th>
                        <th>Primary</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($drivers as $driver)
                        <tr>
                            <td>
                                <a href="{{ route('drivers.show', $driver) }}" class="fw-bold">
                                    {{ $driver->full_name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('owners.show', $driver->owner) }}">
                                    {{ $driver->owner->full_name }}
                                </a>
                            </td>
                            <td>
                                <span class="font-monospace">{{ $driver->license_number }}</span>
                            </td>
                            <td>
                                {{ $driver->license_expiry->format('M d, Y') }}
                                @if($driver->isLicenseExpiringSoon())
                                    <span class="badge bg-warning ms-1">Expiring Soon</span>
                                @endif
                            </td>
                            <td>
                                @if($driver->is_primary)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="text-muted">No</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('drivers.show', $driver) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('drivers.edit', $driver) }}" 
                                       class="btn btn-sm btn-primary" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete('{{ route('drivers.destroy', $driver) }}', 'Are you sure you want to delete this driver?')"
                                            class="btn btn-sm btn-danger"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="fas fa-id-card"></i></div>
                                    <div class="empty-title">No Drivers Found</div>
                                    <div class="empty-text">
                                        @if(request('search') || request('primary'))
                                            Try adjusting your search or filter criteria
                                        @else
                                            Add your first driver to get started
                                        @endif
                                    </div>
                                    @if(!request('search') && !request('primary'))
                                        <a href="{{ route('drivers.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> New Driver
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($drivers->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $drivers->links() }}
            </div>
        @endif
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('drivers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Driver
    </a>
</div>
@endsection
