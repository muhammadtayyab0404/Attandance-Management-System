@extends('layouts.admin')
@push('customcss')

<link rel="stylesheet" href="{{ asset('css/adminleaveacton.css') }}" > 

@endpush

@section('content')

<div class="leave-review-container">

    <div class="card">
        <h2 class="section-title">Leave Request Details</h2>

        <!-- Leave Information -->
        <div class="leave-details">
            <div class="detail-box">
                <label>Start Date</label>
                <p>{{Carbon\Carbon::parse( $leavedata->start_date)->format('l jS F Y') }}</p>
            </div>

            <div class="detail-box">
                <label>End Date</label>
                <p> <p>{{Carbon\Carbon::parse( $leavedata->end_date)->format('l jS F Y') }}</p></p>
            </div>
            <div class="detail-box">
            <label>Current Status</label>
                <p> {{ $leavedata->status }}</p>
            </div>

            <div class="detail-box full-width">
                <label>Reason</label>
                <p>{{ $leavedata->reason}}</p>
            </div>

            
        </div>
    </div>

<!-- Admin Action Section -->
<div class="card mt-20">
    <h2 class="section-title">Admin Decision</h2>

    @if ($errors->any())
        <div class="custom-alert">
            <div class="alert-header">
                ⚠ Please fix the following errors:
            </div>
            <ul class="alert-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    

        <form action="{{ route('adminleavereq', $leavedata->id ) }}" method="Post">
            @csrf

            <!-- Status Selection -->
            <div class="status-options">
                <label class="radio-option approved">
                    <input type="radio" name="status" value="approved">
                    <span>Approved</span>
                </label>

                <label class="radio-option rejected">
                    <input type="radio" name="status" value="disapproved">
                    <span>Disapproved</span>
                </label>

                <label class="radio-option pending">
                    <input type="radio" name="status" value="pending">
                    <span>Pending</span>
                </label>
            </div>

            <!-- Admin Comment -->
            <div class="form-group mt-20">
                <label>Admin Comment</label>
                <textarea 
                    name="admincomment" 
                    rows="4" 
                    placeholder="Enter reason for approval/disapproval..."
                ></textarea>
            </div>

        <input type="hidden" id="userId" name="startdate" value="{{$leavedata->start_date}}">

        <input type="hidden" id="userId" name="enddate" value="{{$leavedata->end_date}}">


            <!-- Submit Button -->
            <div class="mt-20">
                <button type="submit" class="btn-submit">
                    Submit Decision
                </button>
            </div>

        </form>
    </div>

</div>

@endsection
