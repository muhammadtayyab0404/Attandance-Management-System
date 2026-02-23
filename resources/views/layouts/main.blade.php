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
    <h2>Student Attendance</h2>

    <a href="{{ route('dashboard') }}">Dashboard</a>
    

    <a href="{{ route('studentstats') }}">Report</a>

    <a href="{{ route('showleave') }}">Request Leave</a>

     <a href="{{ route('studenttask') }}">Tasks</a>

    <a href="{{ route('showprofilss') }}">Profile</a>

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
