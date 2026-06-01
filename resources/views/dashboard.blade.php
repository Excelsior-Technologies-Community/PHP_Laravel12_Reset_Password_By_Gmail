@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Dashboard</h4>
            </div>
            <div class="card-body">
                <!-- Remove this warning block -->
                {{-- 
                @if(!auth()->user()->hasVerifiedEmail())
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        Your email address is not verified. 
                        <a href="{{ route('verification.notice') }}">Click here to verify your email.</a>
                    </div>
                @endif
                --}}

                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Welcome, {{ auth()->user()->name }}!</h5>
                                <p class="card-text">You have successfully logged in to your account.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Email Status</h5>
                                <p class="card-text">
                                    <span class="badge bg-success">Registered</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-secondary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Account Info</h5>
                                <p class="card-text mb-0">{{ auth()->user()->email }}</p>
                                <small>Member since: {{ auth()->user()->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h5>Quick Actions</h5>
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-user-edit"></i> Edit Profile
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('password.edit') }}" class="btn btn-outline-warning w-100">
                                <i class="fas fa-key"></i> Change Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection