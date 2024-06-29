<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification Email</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f8f9fa;
        }
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-body {
            text-align: center;
        }
        .verification-code {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Verify Your Account</h2>
        </div>
        <div class="email-body">
            <p>Dear [User],</p>
            <p>Please use the verification code below to verify your account:</p>
            <div class="verification-code">
                <p>{{ $body }}</p>
            </div>
            <p>If you did not request this, please ignore this email.</p>
            <p>Thank you,<br>CVSU</p>
        </div>
    </div>
</body>
</html>

{{-- 
<div>
    <h1>{{ $subject }}</h1>
    <p>{{ $body }}</p>
</div> --}}

