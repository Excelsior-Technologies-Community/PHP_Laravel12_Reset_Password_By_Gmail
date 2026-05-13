@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="panel shadow-sm">
                <div class="p-4 border-bottom text-center">
                    <h4 class="mb-1">Verify Your Email</h4>
                    <p class="text-muted mb-0">Open the verification link we sent to {{ auth()->user()->email }}.</p>
                </div>
                <div class="p-4">
                    <p class="mb-4">Your account is created, but dashboard access starts after email verification.</p>
                    <form action="{{ route('verification.send') }}" method="POST">
                        @csrf
                        <button class="btn btn-primary w-100">Resend Verification Link</button>
                    </form>
                    <form action="{{ route('logout') }}" method="POST" class="mt-3 text-center">
                        @csrf
                        <button class="btn btn-link">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
