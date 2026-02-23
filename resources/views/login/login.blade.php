<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance System - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">  </link>
</head>
<body>

<div class="login-container">
    <h2>Attendance Management System</h2>
    <p>Please login to continue</p>

    <form action="{{ route('loginn') }}" method="POST">
        @csrf
        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>
            @error('email')
            <span style="color:red; font-size:13px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>

        <button type="submit" class="btn-login">Login</button>
    </form>

        <div class="footer-text">
        Don't have an account? <a href="{{ route('register') }}" style="color:#4F46E5; text-decoration:none;">Register</a>
    </div>

 
</div>

</body>
</html>
