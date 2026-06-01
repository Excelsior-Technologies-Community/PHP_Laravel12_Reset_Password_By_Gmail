<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    // Show the reset password form (GET request)
    public function showResetForm($token)
    {
        // Get email from query string
        $email = request()->get('email');
        
        return view('auth.forget_password_link', compact('token', 'email'));
    }

    // Handle the password reset (POST request)
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        $check_token = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$check_token) {
            return back()->with('error', 'Invalid or expired token! Please request a new reset link.');
        }

        // Check if token is expired (60 minutes)
        if (now()->diffInMinutes($check_token->created_at) > 60) {
            DB::table('password_resets')->where('email', $request->email)->delete();
            return back()->with('error', 'Reset link has expired! Please request a new one.');
        }

        // Update password
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // Delete the token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Password reset successfully! Please login with your new password.');
    }
}