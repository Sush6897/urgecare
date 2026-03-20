<!DOCTYPE html>
<html>
<head>
    <title>Reset Hospital Portal Password</title>
</head>
<body>
    <h1>Hello, {{ $hospital->hospital_name }}</h1>
    <p>You are receiving this email because we received a password reset request for your hospital portal account.</p>
    <p>Click the button below to reset your password:</p>
    <a href="{{ url('hospital/password/reset/'.$token) }}" style="background-color: #f70400; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; margin-top: 10px; margin-bottom: 10px; border-radius: 5px;">Reset Password</a>
    <p>If you did not request a password reset, no further action is required.</p>
</body>
</html>
