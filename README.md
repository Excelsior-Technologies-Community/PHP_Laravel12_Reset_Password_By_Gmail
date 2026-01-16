# PHP_Laravel12_Reset_Password_By_Gmail


## Project Overview

PHP_Laravel12_Reset_Password_By_Gmail is a simple Laravel 12 application that demonstrates a Forgot Password & Reset Password functionality using Gmail SMTP.

This project allows users to reset their password securely via email.

## Technologies Used:

Laravel 12

PHP 8+

MySQL

Bootstrap 5

Gmail SMTP

## Key Features:

Users can log in using their email and password after resetting it.

Dashboard page confirms successful login.

Users can request a password reset link using their registered email.

The system generates a secure token and sends it via Gmail.

Users can reset their password using the link sent to their email.

Passwords are hashed securely using Laravel’s bcrypt method.

Fully functional with Laravel 12, PHP 8+, and MySQL.

## Features:

Forgot Password Form: Users request a password reset link by entering their email.

Password Reset Email: Gmail receives a secure reset link.

Reset Password Form: Users can set a new password via the emailed link.

Token Verification: Only valid tokens allow password reset, ensuring security.

Gmail SMTP Integration: Sends emails via Gmail SMTP server.

Validation & Security: Email/password validation, token expiration, and hashed passwords.



## Password Reset via Email (Important)


1. User Requests Reset:

On the Forgot Password page, the user enters their registered email and clicks Send Reset Link.


2. Token is Generated:

Laravel creates a secure random token and stores it in the password_resets table.


3. Email is Sent via Gmail SMTP:

The system sends an email to the user’s Gmail account.

The email contains a clickable reset link that includes the token and email.


4. User Clicks the Email Link:

Clicking the link opens the Reset Password page in the browser.


5. User Sets a New Password:

Laravel verifies the token and email.

If valid, the new password is hashed and updated in the users table.


6. Password Reset Complete:

The token is deleted from the database.

User can now log in using the new password.


 Key Point: The password cannot be reset directly in the app. It is reset only when the user clicks the link sent to their Gmail, ensuring maximum security.

---



# Installation & Setup

---

## STEP 1: Create Laravel 12 Project

### Command:

```
composer create-project laravel/laravel PHP_Laravel12_Reset_Password_By_Gmail "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_Reset_Password_By_Gmail

```


## STEP 2: Configure .env File

### Open .env file and set database.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reset_password_gmail
DB_USERNAME=root
DB_PASSWORD=


```

Create database reset_password_gmail in phpMyAdmin.



Step 3: Create password_resets Table

### Run this command in your terminal:

```
php artisan make:migration create_password_resets_table

```

### Open database/migrations/xxxx_xx_xx_create_password_resets_table.php

```

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
};

```

Now run:

```
php artisan migrate

```


## STEP 4 - Create User

### Run this in your terminal:

```
php artisan tinker

```


### Then type this exactly:

```

App\Models\User::create([
    'name' => 'demo',
    'email' => 'demo@gmail.com',
    'password' => bcrypt('12345678')
]);

```

### Then exit:

```
exit

```

Check in Database

Go to phpMyAdmin → users table

You should see:

id	 name 	email	          password


1	demo	demo@gmail.com    (hashed value)
	


## Step 5 - Gmail SMTP Configuration

### In .env:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=yourgmail@gmail.com
MAIL_PASSWORD=yourapppassword
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=yourgmail@gmail.com
MAIL_FROM_NAME="Laravel Reset"

```


## STEP 6 - Routes

### Open routes/web.php:

```

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;


Route::get('/', function () {
    return view('welcome');
});


// Forgot Password
Route::get('forgot-password', [ForgotPasswordController::class,'showForgotForm'])->name('forgot.password.form');
Route::post('forgot-password', [ForgotPasswordController::class,'sendResetLink'])->name('forgot.password');

// Reset Password
Route::get('reset-password/{token}', [ResetPasswordController::class,'showResetForm'])->name('reset.password.form');
Route::post('reset-password', [ResetPasswordController::class,'resetPassword'])->name('reset.password');



// -------------------
// LOGIN ROUTES
// -------------------

// Show Login Form
Route::get('login', function() {
    return view('auth.login');
})->name('login');

// Login POST
Route::post('login', function(\Illuminate\Http\Request $request){
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if(Auth::attempt($request->only('email','password'))){
        return redirect('/dashboard'); // Redirect after successful login
    } else {
        return back()->with('fail', 'Invalid email or password');
    }
});

// Dashboard (protected page)
Route::get('dashboard', function(){
    return "Login Successful! You are now on the dashboard.";
})->middleware('auth');

// Logout (optional)
Route::get('logout', function(){
    Auth::logout();
    return redirect('/login');
})->name('logout');



```





## STEP 7 - Create Controllers


### Run this command:

```
php artisan make:controller ForgotPasswordController 

php artisan make:controller ResetPasswordController


```

### Open : app/Http/Controllers/ForgotPasswordController.php

```

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forget_password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $action_link = route('reset.password.form', ['token' => $token, 'email' => $request->email]);

        $body = "We have received a request to reset your password. 
        Click the link below to reset it: <a href='$action_link'>Reset Password</a>";

        Mail::send('auth.email-forgot', [
            'token' => $token,
            'email' => $request->email
        ], function ($message) use ($request) {
            $message->from('yourgmail@gmail.com', 'Laravel Reset');
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });


        return back()->with('success', 'We have emailed your password reset link!');
    }
}

```


### Open : app/Http/Controllers/ResetPasswordController.php

```

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function showResetForm($token)
    {
        return view('auth.forget_password_link', compact('token'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'=>'required|email|exists:users,email',
            'password'=>'required|min:8|confirmed',
            'token'=>'required'
        ]);

        $check_token = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$check_token) {
            return back()->with('fail','Invalid token!');
        }

        User::where('email', $request->email)
            ->update(['password'=>Hash::make($request->password)]);

        DB::table('password_resets')->where('email',$request->email)->delete();

  return redirect('/forgot-password')->with('success','Your password has been changed successfully!');

    }
}

```



## STEP 8 - Create Views

### resources/views/auth/forget_password.blade.php

```

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Forgot Password</h4>
                </div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('forgot.password') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Send Reset Link
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

```

## resources/views/auth/forget_password_link.blade.php

```

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center bg-success text-white">
                    <h4>Reset Your Password</h4>
                </div>
                <div class="card-body">

                    @if(session('fail'))
                        <div class="alert alert-danger">
                            {{ session('fail') }}
                        </div>
                    @endif

                    <form action="{{ route('reset.password') }}" method="POST">
                        @csrf

                        <!-- Hidden inputs for email and token -->
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ request('email') }}">

                        <!-- Only show password fields -->
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Reset Password
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

```


## resources/views/auth/email-forgot.blade.php

```

<!DOCTYPE html>
<html>
<body style="background:#f4f4f4; font-family: Arial, sans-serif;">

<div style="max-width:600px; margin:20px auto; background:white; padding:20px; border-radius:5px;">
    <h3>Password Reset Request</h3>

    <p>Hello,</p>

    <p>
        We received a request to reset your password.  
        Click the button below to reset it:
    </p>

    <p style="text-align:center;">
        <a href="{{ route('reset.password.form', ['token' => $token, 'email' => $email]) }}"
           style="background:#0d6efd; color:white; padding:10px 15px; text-decoration:none; border-radius:5px;">
            Reset Password
        </a>
    </p>

    <p>If you did not request this, please ignore this email.</p>

    <p>Thanks,<br>Laravel Team</p>
</div>

</body>
</html>

```

## resources/views/auth/login.blade.php

```

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Login</h4>
                </div>
                <div class="card-body">

                    <!-- Show error message if login fails -->
                    @if(session('fail'))
                        <div class="alert alert-danger">
                            {{ session('fail') }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('forgot.password.form') }}">Forgot Password?</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

```






# STEP 9 – Test It

1. Login Page:

Go to /login in your browser.

Enter the email and password of a registered user (e.g., demo@gmail.com / 12345678).

Click Login.

If credentials are correct, you will be redirected to the dashboard:

```
Login Successful! You are now on the dashboard.

```

If credentials are wrong, an error message appears:

```
Invalid email or password

```

2. Forgot Password / Reset Flow:

Go to /forgot-password.

Enter the registered email (e.g., demo@gmail.com) and click Send Reset Link.

Check your Gmail inbox — you will receive a password reset email.

Click the Reset Password button in the email.

3. Reset Password:

The link opens the reset password form.

Enter your new password and confirm password, then click Reset Password.

If successful, a message appears:

```
Your password has been changed successfully!

```


4. Login with New Password:

Go back to /login.

Enter the email and the new password you just set.

You should be able to log in successfully and reach the dashboard.



## So you can see this type Output:


### Login Page:


<img width="1913" height="964" alt="Screenshot 2026-01-16 131513" src="https://github.com/user-attachments/assets/567d4a08-d8f8-4722-b019-317ce5bcddad" />


### Forgot-Password Page(if you change password):


<img width="1919" height="964" alt="Screenshot 2026-01-16 114126" src="https://github.com/user-attachments/assets/6ec9476b-74a1-4c58-a6fb-0b01cacd1d0d" />

after click on send resent link button show message:

<img width="1915" height="961" alt="Screenshot 2026-01-16 114335" src="https://github.com/user-attachments/assets/ea69ed6e-ae62-406e-8acc-e0b1108a505b" />


### In Your Gmail:


<img width="1414" height="473" alt="Screenshot 2026-01-16 115425" src="https://github.com/user-attachments/assets/ccc71471-cbfa-4203-83d8-83536cd10f66" />


### After click reset password button in your Gmail:


<img width="1914" height="965" alt="Screenshot 2026-01-16 124050" src="https://github.com/user-attachments/assets/f65ff94d-56a5-4303-99c6-b4c2e4077629" />


### Your password change then show success message:


<img width="1919" height="971" alt="Screenshot 2026-01-16 124502" src="https://github.com/user-attachments/assets/121629a4-93e9-42f0-b768-f5e665852882" />





---


# Folder Structure: PHP_Laravel12_Reset_Password_By_Gmail

```

PHP_Laravel12_Reset_Password_By_Gmail/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ForgotPasswordController.php
│   │   │   └── ResetPasswordController.php
│   │   └── Kernel.php
│   ├── Models/
│   │   └── User.php
│   └── ...
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   │   ├── 2014_10_12_000000_create_users_table.php
│   │   ├── xxxx_xx_xx_create_password_resets_table.php
│   │   └── ...
│   └── seeders/
├── public/
│   ├── index.php
│   └── ...
├── resources/
│   ├── views/
│   │   └── auth/
│   │       ├── forget_password.blade.php
│   │       ├── forget_password_link.blade.php
│   │       ├── email-forgot.blade.php
│   │       └── login.blade.php
│   └── ...
├── routes/
│   └── web.php
├── storage/
├── tests/
├── .env
├── artisan
├── composer.json
└── README.md

```
