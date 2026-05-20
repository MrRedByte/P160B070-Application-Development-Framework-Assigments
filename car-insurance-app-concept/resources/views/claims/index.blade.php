@extends('layouts.app')

@section('title', 'Claims')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Claims</li>
@endsection

@section('page-header')
    <h1 class="page-title"><i class="fas fa-clipboard-list me-2"></i>Insurance Claims</h1>
    <p class="page-subtitle">Manage all insurance claims</p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <!-- Search and Filter -->
        <form method="GET" action="{{ route('claims.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Search by claim number..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="filed" {{ request('status') == 'filed' ? 'selected' : '' }}>Filed</option>
                        <option value="investigating" {{ request('status') == 'investigating' ? 'selected' : '' }}>Investigating</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="denied" {{ request('status') == 'denied' ? 'selected' : '' }}>Denied</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        <!-- Claims Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Claim Number</th>
                        <th>Policy</th>
                        <th>Incident Date</th>
                        <th>Status</th>
                        <th>Damage Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($claims as $claim)
                        <tr>
                            <td>
                                <a href="{{ route('claims.show', $claim) }}" class="fw-bold">
                                    {{ $claim->claim_number }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('policies.show', $claim->policy) }}">
                                    {{ $claim->policy->policy_number }}
                                </a>
                            </td>
                            <td>{{ $claim->incident_date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $claim->status_badge_class }}">
                                    {{ ucfirst($claim->status) }}
                                </span>
                            </td>
                            <td>${{ number_format($claim->damage_amount, 2) }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('claims.show', $claim) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('claims.edit', $claim) }}" 
                                       class="btn btn-sm btn-primary" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete('{{ route('claims.destroy', $claim) }}', 'Are you sure you want to delete this claim?')"
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
                                    <div class="empty-icon"><i class="fas fa-clipboard-list"></i></div>
                                    <div class="empty-title">No Claims Found</div>
                                    <div class="empty-text">
                                        @if(request('search') || request('status'))
                                            Try adjusting your search or filter criteria
                                        @else
                                            File your first insurance claim to get started
                                        @endif
                                    </div>
                                    @if(!request('search') && !request('status'))
                                        <a href="{{ route('claims.create') }}" class="btn btn-danger">
                                            <i class="fas fa-plus"></i> New Claim
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
        @if($claims->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $claims->links() }}
            </div>
        @endif
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('claims.create') }}" class="btn btn-danger">
        <i class="fas fa-plus"></i> File New Claim
    </a>
</div>
@endsection
