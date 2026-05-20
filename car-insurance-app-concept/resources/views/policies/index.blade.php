@extends('layouts.app')

@section('title', 'Insurance Policies')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Policies</li>
@endsection

@section('page-header')
    <h1 class="page-title"><i class="fas fa-file-contract me-2"></i>Insurance Policies</h1>
    <p class="page-subtitle">Manage all insurance policies</p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <!-- Search and Filter -->
        <form method="GET" action="{{ route('policies.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Search by policy number..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        <!-- Policies Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Policy Number</th>
                        <th>Owner</th>
                        <th>Vehicle</th>
                        <th>Status</th>
                        <th>Premium</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($policies as $policy)
                        <tr>
                            <td>
                                <a href="{{ route('policies.show', $policy) }}" class="fw-bold">
                                    {{ $policy->policy_number }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('owners.show', $policy->owner) }}">
                                    {{ $policy->owner->full_name }}
                                </a>
                            </td>
                            <td>{{ $policy->car->full_description }}</td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'active' => 'success',
                                        'expired' => 'secondary',
                                        'cancelled' => 'danger'
                                    ];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$policy->status] ?? 'secondary' }}">
                                    {{ ucfirst($policy->status) }}
                                </span>
                            </td>
                            <td>${{ number_format($policy->total_premium, 2) }}</td>
                            <td>
                                {{ $policy->end_date->format('M d, Y') }}
                                @if($policy->isExpiringSoon())
                                    <span class="badge bg-warning ms-1">Expiring Soon</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('policies.show', $policy) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('policies.edit', $policy) }}" 
                                       class="btn btn-sm btn-primary" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($policy->status === 'pending')
                                        <form action="{{ route('policies.activate', $policy) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Activate">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <button onclick="confirmDelete('{{ route('policies.destroy', $policy) }}', 'Are you sure you want to delete this policy?')"
                                            class="btn btn-sm btn-danger"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-file-contract"></i>
                                    </div>
                                    <div class="empty-title">No Policies Found</div>
                                    <div class="empty-text">
                                        @if(request('search') || request('status'))
                                            Try adjusting your search or filter criteria
                                        @else
                                            Create your first insurance policy to get started
                                        @endif
                                    </div>
                                    @if(!request('search') && !request('status'))
                                        <a href="{{ route('policies.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> New Policy
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($policies->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $policies->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-4">
    <a href="{{ route('policies.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Create New Policy
    </a>
</div>
@endsection
