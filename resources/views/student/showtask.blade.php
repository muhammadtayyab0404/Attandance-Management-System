@extends('layouts.main')

@section('content')
@push('customcss')
        <link rel="stylesheet" href="{{ asset('css/showtask.css') }}">  </link>
@endpush

<div class="main-content">
    <div class="task-details">
        <!-- Task Header -->
        <div class="task-header">
            <h1>{{ $data->task->title ?? 'Task Title' }}</h1>
            <p class="deadline"><strong>Deadline:</strong> {{ $data->deadline ?? 'No Deadline' }}</p>
        </div>

        <!-- Task Description -->
        <div class="task-description">
            <h3>Description:</h3>
            <p>{!! $data->description ?? 'No Description Available' !!}</p>
        </div>

        <!-- Student Submission Form -->
        <div class="student-submission">
            <h3>Your Submission:</h3>
            <form action="{{ route('submittask', $data->id ) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Text Answer -->
                <div class="form-group">
                    <label for="taskans">Write your answer:</label>
                    <textarea name="taskans" id="taskans" rows="6" placeholder="Type your answer here..." class="form-control"></textarea>
                </div>

                <!-- File Upload -->
                <div class="form-group">
                    <label for="document">Upload file:</label>
                    <input type="file" name="document" id="document" class="form-control">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">Submit Task</button>
            </form>
        </div>
    </div>
</div>

@endsection
