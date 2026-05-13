@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="panel shadow-sm">
                <div class="p-4 border-bottom">
                    <h4 class="mb-1">Change Password</h4>
                    <p class="text-muted mb-0">Use a strong password with uppercase, lowercase and number.</p>
                </div>
                <div class="p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button class="btn btn-primary">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
