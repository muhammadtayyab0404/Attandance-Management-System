@extends('layouts.main')

@section('content')

<div class="main-content">

    <!-- Top Bar -->
    <div class="top-bar">
        <h1>Leave Request</h1>
        <div>Welcome, Student Name</div>
    </div>


    <!-- Leave Request Card -->
    <div class="card" style="max-width:700px; margin:auto;">

        <h3 style="margin-bottom:20px;">Apply for Leave</h3>
    {{-- Check if there are any errors --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form action="{{ route('leaverequest') }}" method="POST">
        @csrf
            <!-- Date Selection -->
            <div style="margin-bottom:20px;">
                <label><strong>Select Start Leave Date</strong></label><br>
                <input type="date" name="startdate"
                min="{{ $todaydate }}"
                       style="width:100%; padding:10px; margin-top:5px;
                              border-radius:6px; border:1px solid #ccc;">
            </div>

            <div style="margin-bottom:20px;">
                <label><strong>Select End Leave Date</strong></label><br>
                <input type="date" name="enddate"
                min="{{ $todaydate }}"
                       style="width:100%; padding:10px; margin-top:5px;
                              border-radius:6px; border:1px solid #ccc;">
            </div>

            <!-- Reason Field -->
            <div style="margin-bottom:20px;">
                <label><strong>Reason for Leave</strong></label><br>
                <textarea name="reason" rows="4"
                          placeholder="Enter your reason here..."
                          style="width:100%; padding:10px; margin-top:5px;
                                 border-radius:6px; border:1px solid #ccc;
                                 resize:none;"></textarea>
            </div>

            <!-- Submit Button -->
            <div style="text-align:right;">
                <button type="submit"
                        style="background: linear-gradient(135deg,#4F46E5,#7C3AED);
                               color:white;
                               border:none;
                               padding:10px 25px;
                               border-radius:6px;
                               cursor:pointer;
                               font-size:16px;">
                    Submit Leave Request
                </button>
            </div>

        </form>
    </div>


    <!-- Dummy Leave History -->

@if($alldata->count() >0)

 <div style="margin-top:40px;">
        <h3 style="margin-bottom:15px;">Previous Leave Requests</h3>

 
        <table>
            <thead>
                <tr>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Day</th>
                    <th>Status</th>
                    <th>Teacher Feedback </th>
                </tr>
            </thead>
            <tbody></tbody>


       
        @foreach ($alldata as $item)
        <tr>
        <td>{{$item->start_date}}</td>
        <td>{{$item->end_date}}</td>
        <td>{{\Carbon\Carbon::parse($item->start_date)->format('l')}}</td>

        @if ($item->status == 'pending')
        <td style="color:purple; font-weight:bold;">Pending</td>
        
        @elseif ($item->status == 'approved')
        <td style="color:green; font-weight:bold;">Approved</td>
        
        @elseif ($item->status == 'disapproved')
        <td style="color:red; font-weight:bold;">DisApproved</td>
    
        @endif
        
        @if (!empty ($item->comment))
             <td>{{$item->comment}}</td>
        @else
             <td>No Response Yet.</td>
        @endif
               

 </tr> 
       
        @endforeach
            </tbody>
        </table>
    </div>

    @endif


</div>

@endsection
