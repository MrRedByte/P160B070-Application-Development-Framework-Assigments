@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Car</h2>

    <form action="{{ route('cars.update', $car) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="reg_number" class="form-control mb-2" value="{{ $car->reg_number }}" placeholder="Registration Number" required>
        <input type="text" name="brand" class="form-control mb-2" value="{{ $car->brand }}" placeholder="Brand" required>
        <input type="text" name="model" class="form-control mb-2" value="{{ $car->model }}" placeholder="Model" required>

        <select name="owner_id" class="form-control mb-2" required>
            <option value="">Select Owner</option>
            @foreach($owners as $owner)
                <option value="{{ $owner->id }}" @if($owner->id == $car->owner_id) selected @endif>
                    {{ $owner->name }} {{ $owner->surname }}
                </option>
            @endforeach
        </select>

        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
