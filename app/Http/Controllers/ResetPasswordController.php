<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    // Show the reset password form
    public function showResetForm(Request $request, $token)
    {
        // Pass token and email from query string to view
        $email = $request->query('email'); 
        return view('auth.forget_password_link', compact('token', 'email'));
    }

    // Handle the password reset form submission
    public function resetPassword(Request $request)
    {
        // Validate only password and token (email comes hidden)
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        // Check if token exists for this email
        $check_token = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$check_token) {
            return back()->with('fail','Invalid token!');
        }

        // Update user password
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // Delete used token
        DB::table('password_resets')->where('email', $request->email)->delete();

        // Redirect to login page with success message
        return redirect('/forgot-password')->with('success','Your password has been changed successfully!');
    }
}
