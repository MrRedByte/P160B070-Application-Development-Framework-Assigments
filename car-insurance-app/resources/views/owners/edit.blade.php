@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Owner</div>

                    <div class="card-body">
                        <form action="{{ route('owners.update', $owner->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">First Name:</label>
                                <input class="form-control" type="text" name="name" value="{{ old('name', $owner->name) }}">
                                @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Surname:</label>
                                <input class="form-control" type="text" name="surname" value="{{ old('surname', $owner->surname) }}">
                                @error('surname')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>
                            <button class="btn btn-success">Update Owner</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
