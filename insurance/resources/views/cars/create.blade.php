@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Car</h2>

    <form action="{{ route('cars.store') }}" method="POST">
        @csrf
        <input type="text" name="reg_number" class="form-control mb-2" placeholder="Registration Number" required>
        <input type="text" name="brand" class="form-control mb-2" placeholder="Brand" required>
        <input type="text" name="model" class="form-control mb-2" placeholder="Model" required>

        <select name="owner_id" class="form-control mb-2" required>
            <option value="">Select Owner</option>
            @foreach($owners as $owner)
                <option value="{{ $owner->id }}">{{ $owner->name }} {{ $owner->surname }}</option>
            @endforeach
        </select>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
