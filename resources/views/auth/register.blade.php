@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="panel shadow-sm">
                <div class="p-4 border-bottom text-center">
                    <h4 class="mb-1">Register</h4>
                    <p class="text-muted mb-0">Create an account and verify your email.</p>
                </div>
                <div class="p-4">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <input type="text" name="name" value="{{ old('name') }}" class="form-control mb-3" placeholder="Name" required>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control mb-3" placeholder="Email" required>

                        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                        <input type="password" name="password_confirmation" class="form-control mb-3" placeholder="Confirm Password" required>
                        <small class="d-block text-muted mb-3">Password must contain uppercase, lowercase and number.</small>

                        <button class="btn btn-success w-100">Register</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="/login">Already have account? Login</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
