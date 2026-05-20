@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Generate Quote</div>
        <div class="card-body">
            <form action="{{ route('quotes.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Owner</label>
                    <select name="owner_id" class="form-control" required>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->id }}">{{ $owner->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Vehicle</label>
                    <select name="car_id" class="form-control" required>
                        @foreach($cars as $car)
                            <option value="{{ $car->id }}">{{ $car->full_description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Estimated Premium</label>
                    <input type="number" name="estimated_premium" class="form-control" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label>Coverages (JSON)</label>
                    <textarea name="coverages" class="form-control" rows="3">{"liability": 100000}</textarea>
                </div>
                <button class="btn btn-success">Generate Quote</button>
            </form>
        </div>
    </div>
</div>
@endsection
