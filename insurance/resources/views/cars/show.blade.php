@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Car Details</h2>

    <p><strong>Registration Number:</strong> {{ $car->reg_number }}</p>
    <p><strong>Brand:</strong> {{ $car->brand }}</p>
    <p><strong>Model:</strong> {{ $car->model }}</p>
    <p><strong>Owner:</strong> {{ $car->owner->name ?? '' }} {{ $car->owner->surname ?? '' }}</p>

    <a href="{{ route('cars.index') }}" class="btn btn-primary mt-3">Back to Cars</a>
</div>
@endsection
