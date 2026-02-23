<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}"> 
     <link rel="stylesheet" href="{{ asset('css/dash.css') }}">

     @stack('customcss')
    
    
</head>
<body>

    
<div class="sidebar">
    <h2>Admin Panel</h2>

    <a href="{{ route('admindashboard') }}">Students</a>

    <a href="{{ route('stuattend') }}">Attendance</a>

    <a href="{{ route('adminleave') }}">Leave Request </a>

    <a href="{{ route('attensummary') }}">Attendance Summary </a>

    <a href="{{ route('checkgrades') }}">Check Grade</a>

     <a href="{{ route('viewadmintask') }}">Assign Tasks</a>

    <a href="{{ route('showprofile') }}">Profile</a>
    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
        @csrf
        <button type="submit" class="sidebar-btn">
            Logout
        </button>
    </form>
</div>


@yield('content')



</body>
</html>
