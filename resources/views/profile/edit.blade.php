@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="panel shadow-sm">
                <div class="p-4 border-bottom">
                    <h4 class="mb-1">Profile Settings</h4>
                    <p class="text-muted mb-0">Confirm your current password to save profile changes.</p>
                </div>
                <div class="p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                            <small class="text-muted">Changing email will require verification again.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <button class="btn btn-primary">Save Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
