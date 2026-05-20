@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Record Payment</div>
        <div class="card-body">
            <form action="{{ route('payments.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Policy</label>
                    <select name="policy_id" class="form-control" required>
                        @foreach($policies as $policy)
                            <option value="{{ $policy->id }}">{{ $policy->policy_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Amount</label>
                    <input type="number" name="amount" class="form-control" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label>Due Date</label>
                    <input type="date" name="due_date" class="form-control" required>
                </div>
                <button class="btn btn-success">Record Payment</button>
            </form>
        </div>
    </div>
</div>
@endsection
