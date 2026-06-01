<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forget_password');
    }

    public function sendResetLink(Request $request)
    {
          \Log::info('Forgot password submitted email: "' . $request->email . '"');
    \Log::info('Email length: ' . strlen($request->email));
    
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(64);

        // Delete old tokens for this email
        DB::table('password_resets')->where('email', $request->email)->delete();

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $action_link = route('reset.password.form', ['token' => $token, 'email' => $request->email]);

        try {
            Mail::send('auth.email-forgot', [
                'token' => $token,
                'email' => $request->email,
                'action_link' => $action_link
            ], function ($message) use ($request) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->to($request->email);
                $message->subject('Reset Password Notification');
            });

            return back()->with('success', 'We have emailed your password reset link!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email. Please try again.');
        }
    }
}