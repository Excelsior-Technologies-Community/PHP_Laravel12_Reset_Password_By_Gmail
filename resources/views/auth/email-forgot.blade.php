<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #0d6efd;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .button {
            display: inline-block;
            background-color: #0d6efd;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Password Reset Request</h2>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>We received a request to reset your password.</p>
            
            <!-- IMPORTANT: This link uses the correct GET route -->
            <p style="text-align: center;">
                <a href="{{ route('reset.password.form', ['token' => $token, 'email' => $email]) }}" 
                   class="button">
                    Reset Password
                </a>
            </p>
            
            <p>If you did not request a password reset, please ignore this email.</p>
            <p>This password reset link will expire in 60 minutes.</p>
            
            <p>Thanks,<br><strong>Laravel Team</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Laravel Password Reset System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>