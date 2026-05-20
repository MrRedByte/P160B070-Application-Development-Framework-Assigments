@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('setLanguage', 'en') }}" class="btn btn-outline-primary btn-sm me-2">EN</a>
            <a href="{{ route('setLanguage', 'ro') }}" class="btn btn-outline-primary btn-sm">RO</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Car Owners') }}
                        <a href="{{ route('owners.create') }}" class="btn btn-success float-end">{{ __('Add New Owner') }}</a>
                    </div>

                    <div class="card-body">

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>{{ __('First Name') }}</th>
                                <th>{{ __('Surname') }}</th>
                                <th>{{ __('Actions') }}</th>
                                <th>{{ __('Cars') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($owners as $owner)
                                <tr>
                                    <td>{{ $owner->name }}</td>
                                    <td>{{ $owner->surname }}</td>

                                    <td>
                                        <a href="{{ route('owners.edit', $owner->id) }}" class="btn btn-info btn-sm">{{ __('Edit') }}</a>

                                        <form action="{{ route('owners.destroy', $owner->id) }}"
                                              method="POST"
                                              style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('{{ __('Are you sure?') }}');">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </td>

                                    <td>
                                        @if($owner->cars->isEmpty())
                                            <span class="text-muted">{{ __('No cars') }}</span>
                                        @else
                                            <ul class="mb-0">
                                                @foreach($owner->cars as $car)
                                                    <li>
                                                        {{ $car->reg_number }} - {{ $car->brand }} {{ $car->model }}

                                                        <a href="{{ route('cars.edit', $car->id) }}"
                                                           class="btn btn-sm btn-info">Edit</a>

                                                        <form action="{{ route('cars.destroy', $car->id) }}"
                                                              method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('{{ __('Are you sure?') }}');">
                                                                {{ __('Delete') }}
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif

                                        <a href="{{ route('cars.create') }}"
                                           class="btn btn-primary btn-sm mt-2">
                                            {{__("Add Car")}}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>

                        @if($owners->isEmpty())
                            <p class="text-muted">{{ __('No owners found.') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
