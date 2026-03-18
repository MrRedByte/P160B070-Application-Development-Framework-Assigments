@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add New Owner</div>

                    <div class="card-body">
                        <form action="{{ route('owners.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">First Name:</label>
                                <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                                @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Surname:</label>
                                <input class="form-control" type="text" name="surname" value="{{ old('surname') }}">
                                @error('surname')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>
                            <button class="btn btn-success">Add Owner</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
