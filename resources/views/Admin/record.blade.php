@extends('layouts.admin')

@push('customcss')
<link rel="stylesheet" href="{{ asset('css/adminrecord.css') }}">
@endpush

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
                <th>Action</th>
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

   <td class="action-buttons">

    @if ($item['status'] == 'Present')
        <form action="{{ route('removeattend', $item['id']) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-delete">
                🗑 Delete
            </button>
        </form>
    
    @elseif ($item['status'] == 'Absent')
        <form action="{{ route('updateattend', $userid) }}" method="POST">
            @csrf
            <input type="hidden" name="usrdate" value="{{ $item['date'] }}">
            <button type="submit" class="btn btn-edit">
                ✔ Mark Present
            </button>
        </form>
    
    @elseif ($item['status'] == 'Leave')
        <form action="{{ route('updateattend', $userid) }}" method="POST">
            @csrf
            <input type="hidden" name="usrdate" value="{{ $item['date'] }}">
            <button type="submit" class="btn btn-edit">
                ✔ Mark Present
            </button>
        </form>
              <form action="{{ route('removeattend', $item['id']) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-delete">
                🗑 Delete
            </button>
        </form>
    @endif

</td>
                
            </tr>
      @endforeach
          
        </tbody>
    </table>

</div>

@endsection
