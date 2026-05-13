<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    private const RESET_LINK_THROTTLE_SECONDS = 60;

    public function showForgotForm()
    {
        return view('auth.forget_password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $existingToken = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if ($existingToken && now()->diffInSeconds($existingToken->created_at) < self::RESET_LINK_THROTTLE_SECONDS) {
            $waitSeconds = self::RESET_LINK_THROTTLE_SECONDS - now()->diffInSeconds($existingToken->created_at);

            return back()
                ->withInput($request->only('email'))
                ->with('fail', 'Please wait '.$waitSeconds.' seconds before requesting another reset link.');
        }

        $token = Str::random(64);

        // Updated: Prevent duplicate tokens
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        Mail::send('auth.email-forgot', [
            'token' => $token,
            'email' => $request->email
        ], function ($message) use ($request): void {
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });

        return back()->with('success', 'We have emailed your password reset link!');
    }
}
