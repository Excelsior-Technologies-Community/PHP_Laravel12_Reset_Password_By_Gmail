@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="text-center">
    <h1 class="display-4 mb-4">Welcome to Laravel Password Reset System</h1>
    <p class="lead mb-4">A complete authentication system with password reset functionality via Gmail SMTP.</p>
    
    @guest
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
            <a href="{{ route('register') }}" class="btn btn-success btn-lg">Register</a>
        </div>
    @else
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard</a>
        </div>
    @endguest
</div>

<div class="row mt-5">
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-key fa-3x text-primary mb-3"></i>
                <h5 class="card-title">Password Reset</h5>
                <p class="card-text">Secure password reset functionality via Gmail SMTP with token verification.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-envelope fa-3x text-success mb-3"></i>
                <h5 class="card-title">Email Verification</h5>
                <p class="card-text">Email verification required for full account access.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-shield-alt fa-3x text-info mb-3"></i>
                <h5 class="card-title">Secure Authentication</h5>
                <p class="card-text">BCrypt hashed passwords and protected routes with middleware.</p>
            </div>
        </div>
    </div>
</div>
@endsection