@extends('layouts.app')

@section('title', 'Quotes')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Quotes</li>
@endsection

@section('page-header')
    <h1 class="page-title"><i class="fas fa-calculator me-2"></i>Insurance Quotes</h1>
    <p class="page-subtitle">Manage insurance quotes</p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('quotes.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Search by quote number..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>Converted</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="declined" {{ request('status') == 'declined' ? 'selected' : '' }}>Declined</option>
                    </select>
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
                        <th>Quote Number</th>
                        <th>Owner</th>
                        <th>Vehicle</th>
                        <th>Premium</th>
                        <th>Status</th>
                        <th>Expires</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotes as $quote)
                        <tr>
                            <td>
                                <a href="{{ route('quotes.show', $quote) }}" class="fw-bold">
                                    {{ $quote->quote_number }}
                                </a>
                            </td>
                            <td>{{ $quote->owner->full_name }}</td>
                            <td>{{ $quote->car->full_description }}</td>
                            <td>${{ number_format($quote->estimated_premium, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $quote->status_badge_class }}">
                                    {{ ucfirst($quote->status) }}
                                </span>
                            </td>
                            <td>
                                {{ $quote->expires_at->format('M d, Y') }}
                                @if($quote->isExpiringSoon())
                                    <span class="badge bg-warning ms-1">Expiring Soon</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('quotes.show', $quote) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(!$quote->isConverted() && !$quote->isExpired())
                                        <form action="{{ route('quotes.convert', $quote) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Convert to Policy">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <button onclick="confirmDelete('{{ route('quotes.destroy', $quote) }}', 'Are you sure you want to delete this quote?')"
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
                                    <div class="empty-icon"><i class="fas fa-calculator"></i></div>
                                    <div class="empty-title">No Quotes Found</div>
                                    <div class="empty-text">
                                        @if(request('search') || request('status'))
                                            Try adjusting your search or filter criteria
                                        @else
                                            Create your first insurance quote to get started
                                        @endif
                                    </div>
                                    @if(!request('search') && !request('status'))
                                        <a href="{{ route('quotes.create') }}" class="btn btn-warning">
                                            <i class="fas fa-plus"></i> New Quote
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($quotes->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $quotes->links() }}
            </div>
        @endif
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('quotes.create') }}" class="btn btn-warning">
        <i class="fas fa-plus"></i> Generate New Quote
    </a>
</div>
@endsection
