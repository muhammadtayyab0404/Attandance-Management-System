@extends('layouts.main')

@section('content')
<div class="main-content">

    <!-- Top Bar -->
    <div class="top-bar">
        <h1>Student Attendance </h1>
      
    </div>

    <!-- Summary Cards -->
    <div class="cards">
        <div class="card">
            <h3>Total Classes</h3>
            <p>{{ $totalattendance}}</p>
        </div>

        <div class="card">
            <h3>Present</h3>
            <p style="color:green;">{{ $present}}</p>
        </div>

        <div class="card">
            <h3>Absent</h3>
            <p style="color:red;">{{$absent}}</p>
        </div>    
            <div class="card">
            <h3>Leave</h3>
            <p style="color:purple;">{{$leave}}</p>
        </div>

        <div class="card">
            <h3>Attendance %</h3>
            <p style="color:#4F46E5;">{{$percent}}%</p>
        </div>
    </div>

    <!-- Mark Attendance Section -->
   

    <!-- Attendance History Table -->
    <h3 style="margin-bottom:15px;">Attendance History</h3>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Day</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

     @foreach ($alldata as $item)
            <tr>
                <td>{{\Carbon\Carbon::parse($item['date'])->format('jS M Y')}}</td>
                <td>{{ \Carbon\Carbon::parse($item['date'])->format('l') }} </td>
                
                @if ($item['status'] == 'Present')
                <td style="color:green; font-weight:bold;">Present</td>    
                
                @elseif ($item['status'] == 'Leave')
                <td style="color:purple; font-weight:bold;">Leave</td>    
                
                @else
                    <td style="color:red; font-weight:bold;">Not Present</td>
                @endif

    @endforeach
          
        </tbody>
    </table>

</div>

@endsection
