<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Management System - Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}"> <!-- reuse the same CSS as login -->
</head>
<body>

<div class="login-container">
    <h2>Register</h2>
    <p>Create your account to continue</p>

@if ($errors->any())
    <div style="background-color:#fee2e2; color:#b91c1c; padding:10px; border-radius:5px; margin-bottom:15px;">
        <ul style="margin:0; padding-left:20px;">
            @foreach ($errors->all() as $error)
                <li> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    <form action="{{ route('regis')  }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="input-group">
            <label>Name</label>
            <input type="text" name="name" placeholder="Enter your name" required>
        </div>

        <div class="input-group">
            <label>Age</label>
            <input type="number" name="age" placeholder="Enter your Age" required>
        </div>

        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>

        <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" placeholder="Confirm your password" required>
        </div>

        <div class="input-group">
            <label>Profile Photo</label>
            <input type="file" name="photo">
        </div>

        <button type="submit" class="btn-login">Register</button>
    </form>

    <div class="footer-text">
        Already have an account? <a href="{{ route('login') }}" style="color:#4F46E5; text-decoration:none;">Login</a>
    </div>
</div>

</body>
</html>
