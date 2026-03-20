<!-- resources/views/emails/custom_reset_password.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Hello, {{ $user->name }}</h1>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>Click the button below to reset your password:</p>
    <a href="{{ url('password/reset', $token) }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none;">Reset Password</a>
    <p>If you did not request a password reset, no further action is required.</p>
</body>
</html>
