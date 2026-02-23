@extends('layouts.admin')

@push('customcss')
<link rel="stylesheet" href="{{ asset('css/adminrecord.css') }}">
<link rel="stylesheet" href="{{ asset('css/attensummary.css') }}">
@endpush

@section('content')
<div class="main-content">

    <!-- Top Bar -->
    <div class="top-bar">
        <h1>Student Attendance Record</h1>
    </div>

    <!-- Filter Card -->
    <div class="card filter-card">
        <h3>Filter By Date</h3>
        <form method="GET" action="{{ route('selecteddates') }}" class="filter-form">

            <div class="input-group">
                <label>From Date</label>
                <input type="date" name="from" value="{{ request('from') }}" required>
            </div>

            <div class="input-group">
                <label>To Date</label>
                <input type="date" name="to" value="{{ request('to') }}" required>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-search">Search</button>
            </div>

        </form>
    </div>

    <!-- Optional: Summary Section -->
    <div class="card summary-card" style="margin-top:20px;">
        <h3>Attendance Summary ({{ request('from') ?? '' }} - {{ request('to') ?? '' }})</h3>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Leave</th>
                </tr>
            </thead>
            <tbody>
    
                @foreach ($users as $name => $records)
                    <tr>
                        <td>{{ $name }}</td>
                        <td>{{ $records->last()['present'] ?? 0 }}</td>
                        <td>{{ $records->last()['absent'] ?? 0 }}</td>
                        <td>{{ $records->last()['leave'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Daily Records Table -->
    <div class="card" style="margin-top:20px;">
        <h3>Daily Attendance Records</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Day</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alldata as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item['date'])->format('jS M Y') }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['day'] }}</td>

                        @if ($item['status'] == 'Present')
                            <td style="color:green; font-weight:bold;">Present</td>
                        @elseif ($item['status'] == 'Leave')
                            <td style="color:purple; font-weight:bold;">Leave</td>
                        @else
                            <td style="color:red; font-weight:bold;">Not Present</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection