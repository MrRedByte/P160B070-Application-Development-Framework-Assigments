@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lecturers</div>

                <div class="card-body">
                    <a href="{{ route('subjects.create') }}" class="btn btn-success float-end">Add new Subject</a>
                    <hr class="mt-5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Semester</th>
                                <th>Lecturer</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->description }}</td>
                                <td>{{ $subject->semester }}</td>
                                <td>{{ $subject->lecturer->name }} {{ $subject->lecturer->surname }}</td>

                                <td>
                                    <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-info">Edit</a>
                                    <a href="#" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
