@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Edit Car</div>
            <div class="card-body">

                <form action="{{ route('cars.update', $car->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label>Registration Number</label>
                        <input type="text" name="reg_number" class="form-control" value="{{ $car->reg_number }}">
                    </div>
                    <div class="mb-3">
                        <label>Brand</label>
                        <input type="text" name="brand" class="form-control" value="{{ $car->brand }}">
                    </div>
                    <div class="mb-3">
                        <label>Model</label>
                        <input type="text" name="model" class="form-control" value="{{ $car->model }}">
                    </div>
                    <div class="mb-3">
                        <label>Owner</label>
                        <select name="owner_id" class="form-control">
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}"
                                    {{ $car->owner_id == $owner->id ? 'selected' : '' }}>
                                    {{ $owner->name }} {{ $owner->surname }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-success">Update Car</button>
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
            <hr>
            <h5>Car Photos</h5>
            <div class="row mb-3">
                @foreach($car->photos as $photo)
                    <div class="col-md-3 text-center mb-3">
                        <img src="{{ asset('storage/' . $photo->path) }}" class="img-fluid mb-2"
                             style="height:150px; object-fit:cover;" alt="There is no image available for this car">

                        <form action="{{ route('photos.delete', $photo->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                @endforeach
            </div>
            <form action="{{ route('cars.photos.upload', $car->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>Upload Photos</label>
                    <input type="file" name="photos[]" multiple class="form-control">
                </div>
                <button class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
@endsection
