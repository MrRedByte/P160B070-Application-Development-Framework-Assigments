@extends('layouts.app')

@section('title', 'Coverage Types')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Coverage Types</li>
@endsection

@section('page-header')
    <h1 class="page-title"><i class="fas fa-shield-halved me-2"></i>Coverage Types</h1>
    <p class="page-subtitle">Manage insurance coverage types</p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Coverage Type</th>
                        <th>Description</th>
                        <th>Base Premium</th>
                        <th>Type</th>
                        <th>Mandatory</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coverageTypes as $coverage)
                        <tr>
                            <td>
                                <a href="{{ route('coverage-types.show', $coverage) }}" class="fw-bold">
                                    {{ $coverage->name }}
                                </a>
                            </td>
                            <td>{{ Str::limit($coverage->description, 50) ?? 'N/A' }}</td>
                            <td>
                                @if($coverage->type === 'percentage')
                                    {{ number_format($coverage->base_premium, 2) }}%
                                @else
                                    ${{ number_format($coverage->base_premium, 2) }}
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($coverage->type) }}</span>
                            </td>
                            <td>
                                @if($coverage->is_mandatory)
                                    <span class="badge bg-danger">Yes</span>
                                @else
                                    <span class="text-muted">Optional</span>
                                @endif
                            </td>
                            <td>
                                @if($coverage->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('coverage-types.show', $coverage) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('coverage-types.edit', $coverage) }}" 
                                       class="btn btn-sm btn-primary" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete('{{ route('coverage-types.destroy', $coverage) }}', 'Are you sure you want to delete this coverage type?')"
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
                                    <div class="empty-icon"><i class="fas fa-shield-halved"></i></div>
                                    <div class="empty-title">No Coverage Types Found</div>
                                    <div class="empty-text">Create your first coverage type to get started</div>
                                    <a href="{{ route('coverage-types.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> New Coverage Type
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($coverageTypes->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $coverageTypes->links() }}
            </div>
        @endif
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('coverage-types.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Coverage Type
    </a>
</div>
@endsection
