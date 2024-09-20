<!DOCTYPE html>
<html>
<head>
    <title>Admin OTP Verification</title>
</head>
<body>
    <h1>Admin OTP Verification</h1>
    <p>Hi,</p>
    <p>Your OTP Code is: <strong>{{ $otpCode }}</strong></p>
    <p>Please use this code to verify your email and set your password.</p>
    <p>If you did not request this, please ignore this email.</p>

    <p>Verification Link: <a href="{{ $verificationUrl }}">Click here to verify</a></p>
</body>
</html>
