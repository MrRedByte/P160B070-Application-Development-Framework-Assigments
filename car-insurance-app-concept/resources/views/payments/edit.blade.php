@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Edit Payment</div>
        <div class="card-body">
            <form action="{{ route('payments.update', $payment) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label>Amount</label>
                    <input type="number" name="amount" class="form-control" value="{{ $payment->amount }}" step="0.01" required>
                </div>
                <button class="btn btn-primary">Update Payment</button>
            </form>
        </div>
    </div>
</div>
@endsection
