@extends('layouts.app')

@section('content')
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Car Owners
                        <a href="{{ route('owners.create') }}" class="btn btn-success float-end">Add New Owner</a>
                    </div>

                    <div class="card-body">

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Surname</th>
                                <th>Actions</th>
                                <th>Cars</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($owners as $owner)
                                <tr>
                                    <td>{{ $owner->name }}</td>
                                    <td>{{ $owner->surname }}</td>

                                    <td>
                                        <a href="{{ route('owners.edit', $owner->id) }}" class="btn btn-info btn-sm">Edit</a>

                                        <form action="{{ route('owners.destroy', $owner->id) }}"
                                              method="POST"
                                              style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure?');">
                                                Delete
                                            </button>
                                        </form>
                                    </td>

                                    <td>
                                        @if($owner->cars->isEmpty())
                                            <span class="text-muted">No cars</span>
                                        @else
                                            <ul class="mb-0">
                                                @foreach($owner->cars as $car)
                                                    <li>
                                                        {{ $car->reg_number }} - {{ $car->brand }} {{ $car->model }}

                                                        <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-sm btn-info">Edit</a>

                                                        <form action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Are you sure you want to delete this car?');">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif

                                        <a href="{{ route('cars.create') }}"
                                           class="btn btn-primary btn-sm mt-2">
                                            Add Car
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>

                        @if($owners->isEmpty())
                            <p class="text-muted">No owners found.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
