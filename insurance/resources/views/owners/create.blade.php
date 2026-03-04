@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Owner</h2>

    <form action="{{ route('owners.store') }}" method="POST">
        @csrf
        <input type="text" name="name" class="form-control mb-2" placeholder="Name">
        <input type="text" name="surname" class="form-control mb-2" placeholder="Surname">
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
