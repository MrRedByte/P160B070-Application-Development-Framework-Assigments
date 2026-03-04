@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Updating lecturer</div>

                <div class="card-body">
                   <form action="{{ route('lecturers.update', $lecturer->id) }}" method="post">
                       @csrf
                       @method('put')

                       <div class="mb-3">
                           <label class="form-label">Name:</label>
                           <input class="form-control" type="text" name="name" value="{{ $lecturer->name }}">
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Surname:</label>
                           <input class="form-control" type="text" name="surname" value="{{ $lecturer->surname }}">
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Phone:</label>
                           <input class="form-control" type="text" name="phone" value="{{ $lecturer->phone }}">
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Email:</label>
                           <input class="form-control" type="email" name="email" value="{{ $lecturer->email }}">
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Birth date:</label>
                           <input class="form-control" type="date" name="birthday" value="{{ $lecturer->birthday }}">
                       </div>
                       <hr>
                       <button class="btn btn-success">Update lecturer</button>

                   </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
