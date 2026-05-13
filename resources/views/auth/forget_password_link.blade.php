@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="panel shadow-sm">
                    <div class="p-4 border-bottom text-center">
                        <h4 class="mb-1">Reset Your Password</h4>
                        <p class="text-muted mb-0">This link is valid for 15 minutes.</p>
                    </div>
                    <div class="p-4">

                        <form action="{{ route('reset.password') }}" method="POST">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ request('email') }}">

                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control" required>

                                <!-- Password Hint -->
                                <small class="text-muted">
                                    Password must contain uppercase, lowercase & number
                                </small>

                                <!-- Show validation error -->
                                @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                                @error('password_confirmation')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100">
                                Reset Password
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
@endsection
