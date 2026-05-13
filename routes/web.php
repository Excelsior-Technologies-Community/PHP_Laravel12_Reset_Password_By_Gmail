
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResetPasswordController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('forgot-password', [ForgotPasswordController::class,'showForgotForm'])->name('forgot.password.form');
Route::post('forgot-password', [ForgotPasswordController::class,'sendResetLink'])->name('forgot.password');

Route::get('reset-password/{token}', [ResetPasswordController::class,'showResetForm'])->name('reset.password.form');
Route::post('reset-password', [ResetPasswordController::class,'resetPassword'])->name('reset.password');

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationController::class, 'send'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('verified')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('change-password', [ProfileController::class, 'editPassword'])->name('password.edit');
        Route::put('change-password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });
});
