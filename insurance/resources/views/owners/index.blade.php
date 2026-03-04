
@extends('layouts.app')

@section('content')
<h2>Car Owners</h2>
<a href="{{ route('owners.create') }}" class="btn btn-success mb-3">Add Owner</a>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Actions</th>
        </tr>
        @foreach($owners as $owner)
        <tr>
            <td>{{ $owner->id }}</td>
            <td>{{ $owner->name }}</td>
            <td>{{ $owner->surname }}</td>
            <td>
                <a href="{{ route('owners.edit', $owner) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('owners.destroy', $owner) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>

