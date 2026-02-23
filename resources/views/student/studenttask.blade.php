@extends('layouts.main')

@push('customcss')
<link rel="stylesheet" href="{{ asset('css/studenttask.css') }}">    
@endpush  

@section('content')
<div class="main-content">
    <div class="top-bar">
        <h1>Student Tasks Dashboard</h1>
    </div>

    <div class="task-cards">
       @foreach($alltask as $task)
    <div class="task-card">
        <h3>{{ $task->title }}</h3>
        <p><strong>Deadline:</strong> {{ $task->deadline }}</p>

        @php
            $submission = $submittedtask->get($task->id);
        @endphp

        @if($submission)

            <p><strong>Status:</strong> {{ $submission->status }}</p>

            <p><strong>Tutor Feedback:</strong>
                {{ $submission->feedback ?? 'No feedback yet' }}
            </p>

            <button disabled
                style="padding:8px 15px; background:#ccc; border:none; border-radius:5px; cursor:not-allowed;">
                Already Submitted
            </button>

        @else

            <p><strong>Status:</strong> Not Submitted</p>
            <p><strong>Tutor Feedback:</strong> - </p>

            <a href="{{ route('studenttask.show', $task->id ) }}"
               class="open-task-primary">
               Open Task
            </a>

        @endif

    </div>
@endforeach
    </div>
</div>

@endsection



