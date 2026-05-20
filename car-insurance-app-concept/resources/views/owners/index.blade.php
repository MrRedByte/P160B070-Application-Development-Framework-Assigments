@extends('layouts.app')

@section('title', 'Owners')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Owners</li>
@endsection

@section('page-header')
    <h1 class="page-title"><i class="fas fa-users me-2"></i>Car Owners</h1>
    <p class="page-subtitle">Manage all car owners</p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <!-- Search -->
        <form method="GET" action="{{ route('owners.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Search by name or email..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Search
                    </button>
                </div>
            </div>
        </form>

        <!-- Owners Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Owner</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Cars</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($owners as $owner)
                        <tr>
                            <td>
                                <a href="{{ route('owners.show', $owner) }}" class="fw-bold">
                                    {{ $owner->full_name }}
                                </a>
                            </td>
                            <td>{{ $owner->email ?? 'N/A' }}</td>
                            <td>{{ $owner->phone ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $owner->cars->count() }}</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('owners.show', $owner) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('owners.edit', $owner) }}" 
                                       class="btn btn-sm btn-primary" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete('{{ route('owners.destroy', $owner) }}', 'Are you sure you want to delete this owner?')"
                                            class="btn btn-sm btn-danger"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="empty-title">No Owners Found</div>
                                    <div class="empty-text">
                                        @if(request('search'))
                                            Try adjusting your search criteria
                                        @else
                                            Add your first car owner to get started
                                        @endif
                                    </div>
                                    @if(!request('search'))
                                        <a href="{{ route('owners.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> New Owner
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
        @if($owners->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $owners->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-4">
    <a href="{{ route('owners.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Owner
    </a>
</div>
@endsection
