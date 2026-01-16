<!DOCTYPE html>
<html>
<body style="background:#f4f4f4; font-family: Arial, sans-serif;">

<div style="max-width:600px; margin:20px auto; background:white; padding:20px; border-radius:5px;">
    <h3>Password Reset Request</h3>

    <p>Hello,</p>

    <p>
        We received a request to reset your password.  
        Click the button below to reset it:
    </p>

    <p style="text-align:center;">
        <a href="{{ route('reset.password.form', ['token' => $token, 'email' => $email]) }}"
           style="background:#0d6efd; color:white; padding:10px 15px; text-decoration:none; border-radius:5px;">
            Reset Password
        </a>
    </p>

    <p>If you did not request this, please ignore this email.</p>

    <p>Thanks,<br>Laravel Team</p>
</div>

</body>
</html>
