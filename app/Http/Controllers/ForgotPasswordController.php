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
