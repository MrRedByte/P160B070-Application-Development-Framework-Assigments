@extends('layouts.app')

@section('title', 'All Cars')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Cars</li>
@endsection

@section('page-header')
    <h1 class="page-title"><i class="fas fa-car me-2"></i>Registered Vehicles</h1>
    <p class="page-subtitle">Manage all insured vehicles in the system</p>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <!-- Search and Filter -->
        <form method="GET" action="{{ route('cars.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Search by registration, brand, model, or VIN..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="vehicle_type" class="form-select">
                        <option value="">All Vehicle Types</option>
                        <option value="sedan" {{ request('vehicle_type') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                        <option value="suv" {{ request('vehicle_type') == 'suv' ? 'selected' : '' }}>SUV</option>
                        <option value="hatchback" {{ request('vehicle_type') == 'hatchback' ? 'selected' : '' }}>Hatchback</option>
                        <option value="coupe" {{ request('vehicle_type') == 'coupe' ? 'selected' : '' }}>Coupe</option>
                        <option value="convertible" {{ request('vehicle_type') == 'convertible' ? 'selected' : '' }}>Convertible</option>
                        <option value="wagon" {{ request('vehicle_type') == 'wagon' ? 'selected' : '' }}>Wagon</option>
                        <option value="truck" {{ request('vehicle_type') == 'truck' ? 'selected' : '' }}>Truck</option>
                        <option value="van" {{ request('vehicle_type') == 'van' ? 'selected' : '' }}>Van</option>
                        <option value="motorcycle" {{ request('vehicle_type') == 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                        <option value="other" {{ request('vehicle_type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        <!-- Cars Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Registration</th>
                        <th>Vehicle</th>
                        <th>VIN</th>
                        <th>Year</th>
                        <th>Type</th>
                        <th>Color</th>
                        <th>Owner</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cars as $car)
                        <tr>
                            <td>
                                <a href="{{ route('cars.show', $car) }}" class="fw-bold">
                                    {{ strtoupper($car->reg_number) }}
                                </a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-2 me-2">
                                        <i class="fas fa-car text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $car->brand }}</div>
                                        <small class="text-muted">{{ $car->model }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <small class="font-monospace">{{ $car->vin ?? 'N/A' }}</small>
                            </td>
                            <td>{{ $car->year ?? 'N/A' }}</td>
                            <td>
                                @if($car->vehicle_type)
                                    <span class="badge bg-info">{{ ucfirst($car->vehicle_type) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($car->color)
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle me-2" 
                                             style="width: 20px; height: 20px; background-color: {{ $car->color }}; border: 1px solid #ddd;"></div>
                                        <span>{{ ucfirst($car->color) }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('owners.show', $car->owner) }}">
                                    {{ $car->owner->full_name }}
                                </a>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('cars.show', $car) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('cars.edit', $car) }}" 
                                       class="btn btn-sm btn-primary" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete('{{ route('cars.destroy', $car) }}', 'Are you sure you want to delete this vehicle?')"
                                            class="btn btn-sm btn-danger"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-car"></i>
                                    </div>
                                    <div class="empty-title">No Cars Found</div>
                                    <div class="empty-text">
                                        @if(request('search') || request('vehicle_type'))
                                            Try adjusting your search or filter criteria
                                        @else
                                            Register your first vehicle to get started
                                        @endif
                                    </div>
                                    @if(!request('search') && !request('vehicle_type'))
                                        <a href="{{ route('cars.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Register Car
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
        @if($cars->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $cars->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-4">
    <a href="{{ route('cars.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Register New Car
    </a>
</div>
@endsection
