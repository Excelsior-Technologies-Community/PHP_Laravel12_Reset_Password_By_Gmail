<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');
        return view('auth.forget_password_link', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        //  Password Strength Validation
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'token' => 'required'
        ], [
            'password.regex' => 'Password must contain at least one uppercase, one lowercase, and one number.'
        ]);

        // Check token
        $check_token = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$check_token) {
            return back()->with('fail','Invalid token!');
        }

        //  Token Expiry (15 minutes)
        if (now()->diffInMinutes($check_token->created_at) > 15) {
            return back()->with('fail','Token expired! Please request a new link.');
        }

        // Update password
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // Delete token after use
        DB::table('password_resets')
            ->where('email', $request->email)
            ->delete();

        return redirect('/login')->with('success','Password reset successful! Please login.');
    }
}