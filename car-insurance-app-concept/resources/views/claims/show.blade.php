@extends('layouts.app')

@section('title', $claim->claim_number)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('claims.index') }}">Claims</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $claim->claim_number }}</li>
@endsection

@section('page-header')
    <h1 class="page-title"><i class="fas fa-clipboard-list me-2"></i>{{ $claim->claim_number }}</h1>
    <p class="page-subtitle">Claim Details</p>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clipboard-list"></i> Claim Information</span>
                <div class="action-buttons">
                    <a href="{{ route('claims.edit', $claim) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button onclick="confirmDelete('{{ route('claims.destroy', $claim) }}', 'Are you sure you want to delete this claim?')"
                            class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small mb-1">Claim Number</label>
                        <div class="fs-5 fw-bold">{{ $claim->claim_number }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-1">Status</label>
                        <div>
                            <span class="badge bg-{{ $claim->status_badge_class }} fs-6">
                                {{ ucfirst($claim->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small mb-1">Policy</label>
                        <div>
                            <a href="{{ route('policies.show', $claim->policy) }}">
                                <i class="fas fa-file-contract me-1"></i>{{ $claim->policy->policy_number }}
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-1">Incident Date</label>
                        <div><i class="fas fa-calendar-alt text-primary me-1"></i>{{ $claim->incident_date->format('M d, Y h:i A') }}</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small mb-1">Description</label>
                    <p>{{ $claim->description }}</p>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Location</label>
                        <div>{{ $claim->location ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small mb-1">Police Report #</label>
                        <div>{{ $claim->police_report_number ?? 'N/A' }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label class="text-muted small mb-1">Damage Amount</label>
                        <div class="fs-5 text-danger fw-bold">${{ number_format($claim->damage_amount, 2) }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small mb-1">Estimated Payout</label>
                        <div class="fs-5 text-success fw-bold">${{ number_format($claim->estimated_payout, 2) }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small mb-1">Actual Payout</label>
                        <div class="fs-5 text-success fw-bold">${{ number_format($claim->actual_payout ?? 0, 2) }}</div>
                    </div>
                </div>

                @if($claim->adjuster_notes)
                    <hr>
                    <div>
                        <label class="text-muted small mb-1">Adjuster Notes</label>
                        <p class="mb-0">{{ $claim->adjuster_notes }}</p>
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
                    @if($claim->status === 'filed' || $claim->status === 'investigating')
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                            <i class="fas fa-check"></i> Approve Claim
                        </button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#denyModal">
                            <i class="fas fa-times"></i> Deny Claim
                        </button>
                    @endif
                    @if($claim->status === 'approved' && !$claim->isPaid())
                        <form action="{{ route('claims.pay', $claim) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-dollar-sign"></i> Mark as Paid
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('claims.edit', $claim) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Claim
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('claims.approve', $claim) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Approve Claim</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Payout Amount</label>
                        <input type="number" name="payout_amount" class="form-control" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Deny Modal -->
<div class="modal fade" id="denyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('claims.deny', $claim) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Deny Claim</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Denial Reason</label>
                        <textarea name="denial_reason" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Deny Claim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
