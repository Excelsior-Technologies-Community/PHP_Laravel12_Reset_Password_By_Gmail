<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResetPasswordController;

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// ==================== PASSWORD RESET ROUTES ====================
// Show Forgot Password Form
Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('forgot.password.form');

// Send Reset Link Email
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('forgot.password');

// Show Reset Password Form (GET request with token) - THIS IS THE CORRECT ONE
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('reset.password.form');

// Submit New Password (POST request)
Route::post('reset-password', [ResetPasswordController::class, 'resetPassword'])->name('reset.password');

// FALLBACK - Handle direct access to /reset-password without token
Route::get('reset-password', function () {
    return redirect()->route('forgot.password.form')
        ->with('error', 'Invalid password reset link. Please request a new one.');
});

// ==================== AUTHENTICATION ROUTES ====================
// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('change-password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::put('change-password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

// Test email route (remove after testing)
Route::get('test-email', function () {
    try {
        Mail::raw('Test email from Laravel!', function ($message) {
            $message->to('test@example.com')->subject('Test Email');
        });
        return '✅ Email sent successfully!';
    } catch (\Exception $e) {
        return '❌ Error: ' . $e->getMessage();
    }
});

