@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Owner</h2>

    <form action="{{ route('owners.update', $owner) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $owner->name }}" class="form-control mb-2">
        <input type="text" name="surname" value="{{ $owner->surname }}" class="form-control mb-2">

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
