@extends('layouts.main')

@section('content')


<div class="main-content">
    <div class="top-bar">
        <h1>Student Dashboard</h1>
        <div>Welcome, {{ Auth::user()->name}}</div>
    </div>


    <!-- Today Card -->
    <div class="cards">
        <div class="card">
            <h3>Today</h3>
            <p>{{ $displaydate }}</p>
        </div>

        <div class="card">
            <h3>Attendance Status</h3>
            <p id="attendance-status">
                @if ($exists && $exists->mark == 1)
                    Present ✅
                @elseif(($exists && $exists->mark == 0))
                Leave

                @else
                Not Marked ❌
        
                @endif
                {{-- {{ $exists ? 'Present ✅' : 'Not Marked ❌' }} --}}
            </p>
        </div>
    </div>

    @if (!$exists)
        
    <div class="card" style="margin-top:20px;">
       

   

        <div style="text-align:center; margin-top:10px;">
            <form action="{{ route('newattendance') }}" method="POST">
                @csrf
             <input type="hidden" name="todaydate" value="{{ $todaydate }}">   
            <button id="markBtn" type="submit" 
                    style="background: linear-gradient(135deg,#4F46E5,#7C3AED);
                        color:white;
                        border:none;
                        padding:10px 20px;
                        border-radius:6px;
                        cursor:pointer;">
                Mark Your Attendance
            </button>
            </form>

    @endif

    
        </div>
    </div>
</div>

@endsection
