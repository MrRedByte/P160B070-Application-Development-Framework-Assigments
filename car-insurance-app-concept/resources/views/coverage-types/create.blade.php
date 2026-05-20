@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Add Coverage Type</div>
        <div class="card-body">
            <form action="{{ route('coverage-types.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label>Base Premium</label>
                    <input type="number" name="base_premium" class="form-control" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label>Type</label>
                    <select name="type" class="form-control" required>
                        <option value="percentage">Percentage</option>
                        <option value="fixed">Fixed Amount</option>
                    </select>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" checked>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="is_mandatory" class="form-check-input" id="is_mandatory">
                    <label class="form-check-label" for="is_mandatory">Mandatory</label>
                </div>
                <button class="btn btn-success">Add Coverage Type</button>
            </form>
        </div>
    </div>
</div>
@endsection
