<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Laravel Auth'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fb; }
        .auth-shell { min-height: 100vh; display: flex; align-items: center; }
        .topbar { background: #ffffff; border-bottom: 1px solid #e5e7eb; }
        .panel { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; }
        .stat { border-left: 4px solid #0d6efd; }
    </style>
</head>
<body>
@auth
    <nav class="topbar py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand fw-semibold text-decoration-none text-dark" href="{{ route('dashboard') }}">Account Center</a>
            <div class="d-flex gap-2 align-items-center">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('profile.edit') }}">Profile</a>
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('password.edit') }}">Password</a>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-sm btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>
@endauth

<main class="@auth py-4 @else auth-shell @endauth">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('fail'))
            <div class="alert alert-danger">{{ session('fail') }}</div>
        @endif

        @yield('content')
    </div>
</main>
</body>
</html>
