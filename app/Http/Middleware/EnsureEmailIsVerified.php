<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')
                ->with('fail', 'Please verify your email before accessing your account.');
        }

        return $next($request);
    }
}
