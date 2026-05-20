@extends('layouts.app')

@section('title', 'Payments')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Payments</li>
@endsection

@section('page-header')
    <h1 class="page-title"><i class="fas fa-credit-card me-2"></i>Payments</h1>
    <p class="page-subtitle">Track insurance payments</p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('payments.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
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
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="form-check mt-2">
                        <input type="checkbox" 
                               name="overdue" 
                               id="overdue"
                               class="form-check-input"
                               value="1"
                               {{ request('overdue') ? 'checked' : '' }}>
                        <label class="form-check-label" for="overdue">
                            Show Overdue Only
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
                        <th>Policy</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Payment Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>
                                <a href="{{ route('policies.show', $payment->policy) }}">
                                    {{ $payment->policy->policy_number }}
                                </a>
                            </td>
                            <td class="fw-bold">${{ number_format($payment->amount, 2) }}</td>
                            <td>
                                {{ $payment->due_date->format('M d, Y') }}
                                @if($payment->isOverdue())
                                    <span class="badge bg-danger ms-1">Overdue</span>
                                @elseif($payment->isDueSoon())
                                    <span class="badge bg-warning ms-1">Due Soon</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $payment->status_badge_class }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>
                                @if($payment->payment_method)
                                    <i class="fas fa-{{ $payment->payment_method === 'card' ? 'credit-card' : 'university' }} me-1"></i>
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('payments.show', $payment) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($payment->status === 'pending')
                                        <form action="{{ route('payments.mark-paid', $payment) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Mark as Paid">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="fas fa-credit-card"></i></div>
                                    <div class="empty-title">No Payments Found</div>
                                    <div class="empty-text">No payment records found</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
