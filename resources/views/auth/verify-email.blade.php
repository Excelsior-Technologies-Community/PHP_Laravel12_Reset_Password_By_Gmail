@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Verify Your Email Address</h4>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Before proceeding, please check your email for a verification link.
                    If you did not receive the email, click the button below to request another.
                </p>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-info w-100">Resend Verification Email</button>
                </form>

                <div class="mt-3 text-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection