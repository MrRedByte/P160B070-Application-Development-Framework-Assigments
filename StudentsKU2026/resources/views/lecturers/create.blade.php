@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lecturers</div>

                <div class="card-body">
                   <form action="{{ route('lecturers.store') }}" method="post">
                       @csrf

                       <div class="mb-3">
                           <label class="form-label">Name:</label>
                           <input class="form-control" type="text" name="name">
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Surname:</label>
                           <input class="form-control" type="text" name="surname">
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Phone:</label>
                           <input class="form-control" type="text" name="phone">
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Email:</label>
                           <input class="form-control" type="email" name="email">
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Birth date:</label>
                           <input class="form-control" type="date" name="birthday">
                       </div>
                       <hr>
                       <button class="btn btn-success">Add new Lecturer</button>

                   </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
