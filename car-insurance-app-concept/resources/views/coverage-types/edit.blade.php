@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Edit Coverage Type</div>
        <div class="card-body">
            <form action="{{ route('coverage-types.update', $coverageType) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $coverageType->name }}" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ $coverageType->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label>Base Premium</label>
                    <input type="number" name="base_premium" class="form-control" value="{{ $coverageType->base_premium }}" step="0.01" required>
                </div>
                <button class="btn btn-primary">Update Coverage Type</button>
            </form>
        </div>
    </div>
</div>
@endsection
