@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cars</h2>
    <a href="{{ route('cars.create') }}" class="btn btn-success mb-3">Add Car</a>

    @if($cars->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reg Number</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Owner</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cars as $car)
                <tr>
                    <td>{{ $car->id }}</td>
                    <td>{{ $car->reg_number }}</td>
                    <td>{{ $car->brand }}</td>
                    <td>{{ $car->model }}</td>
                    <td>{{ $car->owner->name ?? '' }} {{ $car->owner->surname ?? '' }}</td>
                    <td>
                        <a href="{{ route('cars.show', $car) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('cars.edit', $car) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('cars.destroy', $car) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p>No cars yet.</p>
    @endif
</div>
@endsection
