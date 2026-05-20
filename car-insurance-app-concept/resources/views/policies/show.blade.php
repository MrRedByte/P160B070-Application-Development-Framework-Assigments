@extends('layouts.app')

@section('title', $policy->policy_number)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('policies.index') }}">Policies</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $policy->policy_number }}</li>
@endsection

@section('page-header')
    <h1 class="page-title">
        <i class="fas fa-file-contract me-2"></i>{{ $policy->policy_number }}
    </h1>
    <p class="page-subtitle">Policy Details and Coverage Information</p>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-file-contract"></i> Policy Information</span>
                <div class="action-buttons">
                    @if($policy->status === 'pending')
                        <form action="{{ route('policies.activate', $policy) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-check"></i> Activate
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('policies.edit', $policy) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button onclick="confirmDelete('{{ route('policies.destroy', $policy) }}', 'Are you sure you want to delete this policy?')"
                            class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small mb-1">Policy Number</label>
                        <div class="fs-5 fw-bold">{{ $policy->policy_number }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-1">Status</label>
                        <div>
                            @php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'active' => 'success',
                                    'expired' => 'secondary',
                                    'cancelled' => 'danger'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$policy->status] ?? 'secondary' }} fs-6">
                                {{ ucfirst($policy->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small mb-1">Owner</label>
                        <div>
                            <a href="{{ route('owners.show', $policy->owner) }}">
                                <i class="fas fa-user me-1"></i>{{ $policy->owner->full_name }}
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-1">Vehicle</label>
                        <div>
                            <a href="{{ route('cars.show', $policy->car) }}">
                                <i class="fas fa-car me-1"></i>{{ $policy->car->full_description }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="text-muted small mb-1">Start Date</label>
                        <div><i class="fas fa-calendar-alt text-primary me-1"></i>{{ $policy->start_date->format('M d, Y') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small mb-1">End Date</label>
                        <div><i class="fas fa-calendar-alt text-primary me-1"></i>{{ $policy->end_date->format('M d, Y') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small mb-1">Days Remaining</label>
                        <div>
                            @if($policy->daysUntilExpiration() > 0)
                                <span class="{{ $policy->isExpiringSoon() ? 'text-danger fw-bold' : '' }}">
                                    <i class="fas fa-clock me-1"></i>{{ $policy->daysUntilExpiration() }} days
                                </span>
                            @else
                                <span class="text-danger fw-bold"><i class="fas fa-exclamation-triangle me-1"></i>Expired</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label class="text-muted small mb-1">Total Premium</label>
                        <div class="fs-5 text-success fw-bold">${{ number_format($policy->total_premium, 2) }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small mb-1">Payment Frequency</label>
                        <div><i class="fas fa-sync-alt text-primary me-1"></i>{{ ucfirst($policy->payment_frequency) }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small mb-1">Deductible</label>
                        <div>${{ number_format($policy->deductible, 2) }}</div>
                    </div>
                </div>

                @if($policy->notes)
                    <hr>
                    <div>
                        <label class="text-muted small mb-1">Notes</label>
                        <p class="mb-0">{{ $policy->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Claims -->
        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clipboard-list"></i> Claims</span>
                <a href="{{ route('claims.create', ['policy_id' => $policy->id]) }}" class="btn btn-sm btn-danger">
                    <i class="fas fa-plus"></i> New Claim
                </a>
            </div>
            <div class="card-body p-0">
                @if($policy->claims->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Claim #</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($policy->claims as $claim)
                                    <tr>
                                        <td>
                                            <a href="{{ route('claims.show', $claim) }}">
                                                <strong>{{ $claim->claim_number }}</strong>
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
                                            <a href="{{ route('claims.show', $claim) }}" class="btn btn-sm btn-info">
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
                        <div class="empty-icon"><i class="fas fa-clipboard-list"></i></div>
                        <div class="empty-title">No Claims</div>
                        <div class="empty-text">This policy has no claims yet</div>
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
                    <a href="{{ route('claims.create', ['policy_id' => $policy->id]) }}" class="btn btn-danger">
                        <i class="fas fa-clipboard-list"></i> File Claim
                    </a>
                    <a href="{{ route('payments.create', ['policy_id' => $policy->id]) }}" class="btn btn-success">
                        <i class="fas fa-credit-card"></i> Record Payment
                    </a>
                    @if($policy->status === 'pending')
                        <form action="{{ route('policies.activate', $policy) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check"></i> Activate Policy
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('policies.edit', $policy) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Policy
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Information
            </div>
            <div class="card-body">
                <p class="small text-muted mb-2">
                    <strong>Created:</strong> {{ $policy->created_at->format('M d, Y') }}
                </p>
                <p class="small text-muted mb-2">
                    <strong>Last Updated:</strong> {{ $policy->updated_at->format('M d, Y') }}
                </p>
                @if($policy->activated_at)
                    <p class="small text-muted mb-2">
                        <strong>Activated:</strong> {{ $policy->activated_at->format('M d, Y') }}
                    </p>
                @endif
                @if($policy->cancelled_at)
                    <p class="small text-muted mb-0">
                        <strong>Cancelled:</strong> {{ $policy->cancelled_at->format('M d, Y') }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
