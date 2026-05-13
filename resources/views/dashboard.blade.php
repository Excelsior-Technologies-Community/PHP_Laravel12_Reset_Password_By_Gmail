@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="panel p-4 shadow-sm">
                <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                    <div>
                        <h2 class="h4 mb-1">Welcome, {{ $user->name }}</h2>
                        <p class="text-muted mb-0">Your account security and profile settings are ready.</p>
                    </div>
                    <span class="badge text-bg-success align-self-start">Email Verified</span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel stat p-4 h-100">
                <div class="text-muted small">Email</div>
                <div class="fw-semibold text-break">{{ $user->email }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel stat p-4 h-100">
                <div class="text-muted small">Joined</div>
                <div class="fw-semibold">{{ $user->created_at->format('d M Y') }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel stat p-4 h-100">
                <div class="text-muted small">Login Protection</div>
                <div class="fw-semibold">5 attempts, 15 minute lock</div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel p-4 h-100">
                <h3 class="h5">Profile</h3>
                <p class="text-muted">Keep your name and email address up to date.</p>
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">Edit Profile</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel p-4 h-100">
                <h3 class="h5">Password</h3>
                <p class="text-muted">Change your password with current password confirmation.</p>
                <a href="{{ route('password.edit') }}" class="btn btn-outline-secondary">Change Password</a>
            </div>
        </div>
    </div>
@endsection
