@extends('layouts.admin')

@push('customcss')
    <link rel="stylesheet" href="{{ asset('css/viewsubmitadmintask.css') }}">

@endpush

@section('content')

<div class="main-content">

    <div class="top-bar">
        <h1>📄 Task Details</h1>
    </div>

    <div class="task-view-container">

        {{-- ================= ERROR MESSAGE ================= --}}
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- ================= TASK INFORMATION ================= --}}
        <div class="card">
            <h2 class="card-title">Task Information</h2>

            <div class="info-row">
                <span class="label">Title:</span>
                <span class="value">{{ $tasks->task->title }}</span>
            </div>

            <div class="info-column">
                <span class="label">Description:</span>
                <div class="description-box">
                    {!! $tasks->task->description !!}
                </div>
            </div>
        </div>


        {{-- ================= USER INFORMATION ================= --}}
        <div class="card">
            <h2 class="card-title">User Information</h2>

            <div class="info-row">
                <span class="label">User Name:</span>
                <span class="value">{{ $tasks->user->name }}</span>
            </div>

            <div class="info-row">
                <span class="label">Submission Date:</span>
                <span class="value">
                    {{ \Carbon\Carbon::parse($tasks->created_at)->format('l jS F Y') }}
                </span>
            </div>

            <div class="info-row">
                <span class="label">Current Status:</span>

                <span class="status-badge
                    @if($tasks->status == 'Completed') completed
                    @elseif($tasks->status == 'Rejected') rejected
                    @else pending
                    @endif
                ">
                    {{ $tasks->status }}
                </span>
            </div>

            <div class="info-column">
                <span class="label">Student Answer:</span>
                <div class="answer-box">
                    {{ $tasks->taskans }}
                </div>
            </div>

            @if ($tasks->document)
                <div class="info-column">
                    <span class="label">Submitted Document:</span>
                    <a href="{{ asset('storage/' .$tasks->document) }}" 
                       class="document-link" 
                       target="_blank">
                        Open Submitted File
                    </a>
                </div>
            @else
                <p class="no-doc">No document submitted.</p>
            @endif
        </div>


        {{-- ================= FEEDBACK FORM ================= --}}
        <div class="card">
            <h2 class="card-title">Provide Feedback</h2>

            <form action="{{ route('updateuserstask')}}" method="POST">
                @csrf

                <input type="hidden" name="usrid" value="{{ $tasks->user_id }}">
                <input type="hidden" name="tskid" value="{{ $tasks->task_id }}">

                <div class="form-group">
                    <label class="label">Feedback:</label>
                    <textarea name="feedback"
                        rows="5"
                        placeholder="Write your feedback here..."
                        class="form-control">{{ old('feedback') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="label">Change Status:</label>

                    <div class="radio-group">
                        <label class="radio-option completed-option">
                            <input type="radio" name="status" value="Completed">
                            Completed
                        </label>

                        <label class="radio-option rejected-option">
                            <input type="radio" name="status" value="Rejected">
                            Rejected
                        </label>

                        <label class="radio-option pending-option">
                            <input type="radio" name="status" value="Pending">
                            Pending
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                     Submit Update
                </button>

            </form>
        </div>

    </div>
</div>

@endsection


<style>

</style>