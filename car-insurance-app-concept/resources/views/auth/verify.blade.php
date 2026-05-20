@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4 class="mb-0"><i class="fas fa-envelope-circle-check me-2"></i>Verify Your Email Address</h4>
                </div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            A fresh verification link has been sent to your email address.
                        </div>
                    @endif

                    <p>
                        Before proceeding, please check your email for a verification link.
                        If you did not receive the email,
                    </p>

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                click here to request another
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
