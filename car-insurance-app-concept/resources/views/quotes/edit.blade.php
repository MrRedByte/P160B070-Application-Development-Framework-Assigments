@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Edit Quote</div>
        <div class="card-body">
            <form action="{{ route('quotes.update', $quote) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label>Estimated Premium</label>
                    <input type="number" name="estimated_premium" class="form-control" value="{{ $quote->estimated_premium }}" step="0.01" required>
                </div>
                <button class="btn btn-primary">Update Quote</button>
            </form>
        </div>
    </div>
</div>
@endsection
