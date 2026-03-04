@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $owner->name }} {{ $owner->surname }}</h2>

    <h3>Cars</h3>
    @if($cars->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Registration Number</th>
                    <th>Brand</th>
                    <th>Model</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cars as $car)
                <tr>
                    <td>{{ $car->reg_number }}</td>
                    <td>{{ $car->brand }}</td>
                    <td>{{ $car->model }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p>No cars for this owner yet.</p>
    @endif

    <a href="{{ route('owners.index') }}" class="btn btn-primary mt-3">Back to Owners</a>
</div>
@endsection
