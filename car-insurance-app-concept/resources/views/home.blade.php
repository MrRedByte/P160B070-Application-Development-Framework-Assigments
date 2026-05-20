@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title"><i class="fas fa-chart-line me-2"></i>Dashboard</h1>
    <p class="page-subtitle">Overview of your car insurance business</p>
</div>

<!-- Statistics Cards -->
<div class="row">
    <!-- Owners -->
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon stat-icon-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['total_owners']) }}</div>
            <div class="stat-label">Total Owners</div>
            <a href="{{ route('owners.index') }}" class="btn btn-sm btn-outline-primary mt-3">
                <i class="fas fa-arrow-right"></i> View All
            </a>
        </div>
    </div>

    <!-- Cars -->
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon stat-icon-info">
                <i class="fas fa-car"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['total_cars']) }}</div>
            <div class="stat-label">Total Cars</div>
            <a href="{{ route('cars.index') }}" class="btn btn-sm btn-outline-info mt-3">
                <i class="fas fa-arrow-right"></i> View All
            </a>
        </div>
    </div>

    <!-- Policies -->
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon stat-icon-success">
                <i class="fas fa-file-contract"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['active_policies']) }}</div>
            <div class="stat-label">Active Policies</div>
            <small class="text-muted">of {{ $stats['total_policies'] }} total</small>
            <a href="{{ route('policies.index') }}" class="btn btn-sm btn-outline-success mt-3">
                <i class="fas fa-arrow-right"></i> View All
            </a>
        </div>
    </div>

    <!-- Claims -->
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon stat-icon-warning">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-value">{{ number_format($stats['pending_claims']) }}</div>
            <div class="stat-label">Pending Claims</div>
            <small class="text-muted">of {{ $stats['total_claims'] }} total</small>
            <a href="{{ route('claims.index') }}" class="btn btn-sm btn-outline-warning mt-3">
                <i class="fas fa-arrow-right"></i> View All
            </a>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bolt"></i> Quick Actions
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('owners.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-user-plus"></i> New Owner
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('cars.create') }}" class="btn btn-success w-100">
                            <i class="fas fa-car"></i> Register Car
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('policies.create') }}" class="btn btn-info w-100">
                            <i class="fas fa-file-contract"></i> New Policy
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('quotes.create') }}" class="btn btn-warning w-100">
                            <i class="fas fa-calculator"></i> Get Quote
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Policies -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-file-contract"></i> Recent Policies</span>
                <a href="{{ route('policies.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @if($recentPolicies->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Policy #</th>
                                    <th>Owner</th>
                                    <th>Vehicle</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPolicies as $policy)
                                    <tr>
                                        <td>
                                            <a href="{{ route('policies.show', $policy) }}">
                                                <strong>{{ $policy->policy_number }}</strong>
                                            </a>
                                        </td>
                                        <td>{{ $policy->owner->full_name }}</td>
                                        <td>{{ $policy->car->full_description }}</td>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <div class="empty-title">No Policies Yet</div>
                        <div class="empty-text">Create your first insurance policy</div>
                        <a href="{{ route('policies.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Policy
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Claims -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clipboard-list"></i> Recent Claims</span>
                <a href="{{ route('claims.index') }}" class="btn btn-sm btn-outline-warning">View All</a>
            </div>
            <div class="card-body p-0">
                @if($recentClaims->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Claim #</th>
                                    <th>Policy</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentClaims as $claim)
                                    <tr>
                                        <td>
                                            <a href="{{ route('claims.show', $claim) }}">
                                                <strong>{{ $claim->claim_number }}</strong>
                                            </a>
                                        </td>
                                        <td>{{ $claim->policy->policy_number }}</td>
                                        <td>{{ $claim->incident_date->format('M d, Y') }}</td>
                                        <td>
                                            @php
                                                $claimStatusColors = [
                                                    'filed' => 'warning',
                                                    'investigating' => 'info',
                                                    'approved' => 'success',
                                                    'denied' => 'danger',
                                                    'paid' => 'success'
                                                ];
                                            @endphp
                                            <span class="badge bg-{{ $claimStatusColors[$claim->status] ?? 'secondary' }}">
                                                {{ ucfirst($claim->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="empty-title">No Claims Yet</div>
                        <div class="empty-text">No insurance claims have been filed</div>
                        <a href="{{ route('claims.create') }}" class="btn btn-warning">
                            <i class="fas fa-plus"></i> New Claim
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Expiring Policies -->
@if($expiringPolicies->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-exclamation-triangle text-warning"></i> Policies Expiring Soon
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Policy #</th>
                                <th>Owner</th>
                                <th>Vehicle</th>
                                <th>Expiry Date</th>
                                <th>Days Left</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expiringPolicies as $policy)
                                @php
                                    $daysLeft = now()->diffInDays($policy->end_date, false);
                                    $daysClass = $daysLeft <= 7 ? 'text-danger fw-bold' : ($daysLeft <= 15 ? 'text-warning fw-bold' : 'text-info');
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ route('policies.show', $policy) }}">
                                            <strong>{{ $policy->policy_number }}</strong>
                                        </a>
                                    </td>
                                    <td>{{ $policy->owner->full_name }}</td>
                                    <td>{{ $policy->car->full_description }}</td>
                                    <td>{{ $policy->end_date->format('M d, Y') }}</td>
                                    <td class="{{ $daysClass }}">
                                        <i class="fas fa-clock"></i> {{ $daysLeft }} days
                                    </td>
                                    <td>
                                        <a href="{{ route('policies.edit', $policy) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-sync"></i> Renew
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
    // Auto-refresh dashboard every 5 minutes
    setTimeout(function() {
        location.reload();
    }, 300000);
</script>
@endpush
