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
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Surname:</label>
                                <input class="form-control" type="text" name="surname" value="{{ old('surname') }}">
                            </div>

                            <hr>
                            <button class="btn btn-success">Add Owner</button>
                        </form>
                        @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
