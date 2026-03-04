@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Calculator</div>

                    <div class="card-body">
                        <form action="{{ route("result") }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Enter first number</label>
                                <input placeholder="" name="x" value="" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Enter second number</label>
                                <input placeholder="" name="y" value="" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-success" >Add two numbers</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
