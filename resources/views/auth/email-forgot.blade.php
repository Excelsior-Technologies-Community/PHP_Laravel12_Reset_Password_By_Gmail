<!DOCTYPE html>
<html lang="en">
<body style="background:#f4f6fb; font-family: Arial, sans-serif; margin:0; padding:0;">

<div style="max-width:600px; margin:24px auto; background:white; padding:28px; border-radius:8px; border:1px solid #e5e7eb;">
    <h2 style="margin-top:0; color:#111827;">Password Reset Request</h2>

    <p style="color:#374151;">Hello,</p>

    <p style="color:#374151; line-height:1.6;">
        We received a request to reset your password. This secure link will expire in 15 minutes.
    </p>

    <p style="text-align:center;">
        <a href="{{ route('reset.password.form', ['token' => $token, 'email' => $email]) }}"
           style="display:inline-block; background:#0d6efd; color:white; padding:12px 18px; text-decoration:none; border-radius:6px; font-weight:bold;">
            Reset Password
        </a>
    </p>

    <p style="color:#6b7280; line-height:1.6;">
        If you did not request this, you can safely ignore this email. Your password will not change unless this link is used.
    </p>

    <p style="color:#374151;">Thanks,<br>{{ config('app.name', 'Laravel Auth') }}</p>
</div>

</body>
</html>
