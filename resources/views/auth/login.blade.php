@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="panel shadow-sm">
                <div class="p-4 border-bottom text-center">
                    <h4 class="mb-1">Login</h4>
                    <p class="text-muted mb-0">Access your account dashboard.</p>
                </div>
                <div class="p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif
                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter your email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" name="remember" value="1" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('forgot.password.form') }}">Forgot Password?</a>
                        <br>
                        <a href="{{ route('register') }}">Don't have an account? Register</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
