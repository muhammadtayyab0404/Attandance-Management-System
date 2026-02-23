<!-- Add Task Form (Modal or Card) -->
@extends('layouts.admin')

@push('customcss')
<link rel="stylesheet" href="{{ asset('css/adminrecord.css') }}">
<link rel="stylesheet" href="{{ asset('css/task.css') }}">
@endpush
<div class="card" style="margin-top:20px; max-width:700px;">
    <h3>Add New Task</h3>

    <form method="POST" action="{{ route('taskadeed') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group" style="margin-bottom:15px;">
            <label for="taskTitle">Task Title</label>
            <input type="text" name="title" id="taskTitle" placeholder="Enter task title" style="width:100%; padding:8px; border-radius:5px; border:1px solid #ccc;" required>
        </div>

        <div class="form-group" style="margin-bottom:15px;">
            <label for="taskDescription">Task Description</label>
            <textarea name="description" id="taskDescription" placeholder="Enter task details" style="width:100%; height:150px;"></textarea>
        </div>

        <div class="form-group" style="margin-bottom:15px;">
    <label for="deadline">Deadline</label>
    <input 
        type="date" 
        name="deadline" 
        id="deadline" 
        style="width:100%; padding:8px; border-radius:5px; border:1px solid #ccc;" 
        required>
            </div>

        <button type="submit" style="background:#4CAF50; color:white; padding:8px 15px; border:none; border-radius:5px; cursor:pointer;">Add Task</button>
    </form>
</div>

<!-- CKEditor Script -->
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('taskDescription');
</script>