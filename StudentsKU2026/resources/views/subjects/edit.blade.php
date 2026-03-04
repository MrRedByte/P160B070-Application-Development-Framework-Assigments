@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">New Subject</div>

                <div class="card-body">
                   <form action="{{ route('subjects.update', $subject->id) }}" method="post">
                       @csrf
                       @method('put')

                       <div class="mb-3">
                           <label class="form-label">Name:</label>
                           <input class="form-control" type="text" name="name" value="{{ $subject->name }}">
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Description:</label>
                           <textarea name="description" class="form-control">{{ $subject->description }}</textarea>
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Semester:</label>
                           <input class="form-control" type="number" name="semester" value="{{ $subject->semester }}">
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Lecturer ID:</label>
                           <select name="lecturer_id" class="form-control">
                               @foreach($lecturers as $lecturer)
                                    <option value="{{ $lecturer->id }}"   {{ ($lecturer->id==$subject->lecturer_id)?"selected":"" }}  >{{$lecturer->name}} {{ $lecturer->surname }}</option>
                               @endforeach

                           </select>

                       </div>

                       <hr>
                       <button class="btn btn-success">Update Subject</button>

                   </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
