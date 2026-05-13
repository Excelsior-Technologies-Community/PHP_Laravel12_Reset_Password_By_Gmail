@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="panel shadow-sm">
                <div class="p-4 border-bottom text-center">
                    <h4 class="mb-1">Forgot Password</h4>
                    <p class="text-muted mb-0">We will send a secure reset link to your inbox.</p>
                </div>
                <div class="p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('forgot.password') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter your email" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Send Reset Link
                        </button>
                        <small class="d-block text-muted mt-3 text-center">For security, you can request one reset link per minute.</small>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}">Back to login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
