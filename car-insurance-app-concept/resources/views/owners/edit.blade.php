@extends('layouts.app')

@section('title', 'Edit Owner')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('owners.index') }}">Owners</a></li>
    <li class="breadcrumb-item"><a href="{{ route('owners.show', $owner) }}">{{ $owner->full_name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('page-header')
    <h1 class="page-title"><i class="fas fa-user-edit me-2"></i>Edit Owner</h1>
    <p class="page-subtitle">Update owner information</p>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-user"></i> Owner Information
            </div>
            <div class="card-body">
                <form action="{{ route('owners.update', $owner) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-1"></i> First Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $owner->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="surname" class="form-label">
                                <i class="fas fa-user me-1"></i> Surname <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="surname" 
                                   id="surname"
                                   class="form-control @error('surname') is-invalid @enderror" 
                                   value="{{ old('surname', $owner->surname) }}"
                                   required>
                            @error('surname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i> Email
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email"
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $owner->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">
                                <i class="fas fa-phone me-1"></i> Phone
                            </label>
                            <input type="text" 
                                   name="phone" 
                                   id="phone"
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $owner->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">
                            <i class="fas fa-map-marker-alt me-1"></i> Address
                        </label>
                        <textarea name="address" 
                                  id="address"
                                  class="form-control @error('address') is-invalid @enderror" 
                                  rows="2">{{ old('address', $owner->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">
                            <i class="fas fa-calendar-alt me-1"></i> Date of Birth
                        </label>
                        <input type="date" 
                               name="date_of_birth" 
                               id="date_of_birth"
                               class="form-control @error('date_of_birth') is-invalid @enderror" 
                               value="{{ old('date_of_birth', $owner->date_of_birth?->format('Y-m-d')) }}">
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Owner
                        </button>
                        <a href="{{ route('owners.show', $owner) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
