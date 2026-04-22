<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center bg-success text-white">
                    <h4>Register</h4>
                </div>
                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <input type="text" name="name" class="form-control mb-3" placeholder="Name" required>
                        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

                        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                        <input type="password" name="password_confirmation" class="form-control mb-3" placeholder="Confirm Password" required>

                        <button class="btn btn-success w-100">Register</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="/login">Already have account? Login</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>