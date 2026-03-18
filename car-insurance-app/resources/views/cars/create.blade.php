@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Add Car</div>
            <div class="card-body">

                <form action="{{ route('cars.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Registration Number</label>
                        <input type="text" name="reg_number" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Brand</label>
                        <input type="text" name="brand" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Model</label>
                        <input type="text" name="model" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Owner</label>
                        <select name="owner_id" class="form-control">
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}">
                                    {{ $owner->name }} {{ $owner->surname }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-success">Save</button>
                </form>

            </div>
        </div>
    </div>
@endsection
