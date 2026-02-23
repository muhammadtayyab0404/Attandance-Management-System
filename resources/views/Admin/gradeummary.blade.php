@extends('layouts.admin')

@push('customcss')
<link rel="stylesheet" href="{{ asset('css/adminrecord.css') }}">
<link rel="stylesheet" href="{{ asset('css/attensummary.css') }}">
@endpush

@section('content')
<div class="main-content">

    <!-- Top Bar -->
    <div class="top-bar">
        <h1>Attendance Grade Summary</h1>
        <p>From: <strong>{{ $startdate }}</strong> | To: <strong>{{ $enddate }}</strong></p>
    </div>

    <!-- Summary Table -->
    <div class="card">
        <table class="attendance-summary">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Leave</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alldata as $student)
                <tr>
                    <td>{{ $student['name'] }}</td>
                    <td style="color:green; font-weight:bold;">{{ $student['present'] }}</td>
                    <td style="color:red; font-weight:bold;">{{ $student['absent'] }}</td>
                    <td style="color:purple; font-weight:bold;">{{ $student['leave'] }}</td>
                    <td>
                        @if ($student['grade'] == 'A')
                            <span style="color:#4CAF50; font-weight:bold;">A</span>
                        @elseif ($student['grade'] == 'B')
                            <span style="color:#2196F3; font-weight:bold;">B</span>
                        @elseif ($student['grade'] == 'C')
                            <span style="color:#FFC107; font-weight:bold;">C</span>
                        @elseif ($student['grade'] == 'D')
                            <span style="color:#FF9800; font-weight:bold;">D</span>
                        @else
                            <span style="color:#F44336; font-weight:bold;">F</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection