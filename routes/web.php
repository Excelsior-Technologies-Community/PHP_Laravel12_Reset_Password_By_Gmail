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


// Register Form
Route::get('register', function () {
    return view('auth.register');
})->name('register');

// Register POST
Route::post('register', function (\Illuminate\Http\Request $request) {

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed'
    ]);

    \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password)
    ]);

    return redirect('/login')->with('success', 'Registration successful! Please login.');
});

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