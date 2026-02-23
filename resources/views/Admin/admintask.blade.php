@extends('layouts.admin')

@push('customcss')
<link rel="stylesheet" href="{{ asset('css/adminrecord.css') }}">
<link rel="stylesheet" href="{{ asset('css/task.css') }}">
@endpush

@section('content')
<div class="main-content">

    <!-- Top Bar -->
    <div class="top-bar">
        <h1>Task Management</h1>
        <a href="{{ route('addtaskadmin') }}" class="btn-add-task" style="background:#4CAF50; color:white; padding:8px 15px; border-radius:5px; text-decoration:none;">Add Task</a>
    </div>

@if ($errors->any())
<div class="alert alert-danger" style="
    background-color: #fde2e2;
    color: green;
    border-left: 5px solid #f44336;
    padding: 15px 20px;
    margin: 20px 0;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
">
    <ul style="margin-top:10px; padding-left:20px;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
    

    <!-- Tasks Table -->
    <div class="card">
        <table class="task-table" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f2f2f2;">
                    <th>Task Title</th>
                    <th>Submitted By</th>
                    <th>Submission Deadline</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Dummy Data Rows --}}
                @foreach ($alltask as $item)
                <tr>
                    <td>{{ $item->task->title}}</td>
                    <td>{{ $item->user->name}}</td>
                    <td>{{ Carbon\Carbon::parse( $item->task->deadline)->format('l jS F Y') }}</td>
                    <td style="color:orange; font-weight:bold;">{{ $item->status}}</td>
                    <td style="display:flex; gap:10px;">
                        
                        <a href="{{ route('viewusertask' , [ 'usr' => $item->user->id, 'tsk' => $item->task->id] ) }}" class="btn-view" style="background:#2196F3; color:white; padding:5px 10px; border-radius:5px; text-decoration:none;">View</a>
                       
                        <form action="{{ route('aprrovestatus', $item->id ) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-approve" style="background:#4CAF50; color:white; padding:5px 10px; border-radius:5px; border:none; cursor:pointer;">Approve</button>
                        </form>
                        <form action="{{ route('rejectstatus', $item->id ) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-reject" style="background:#F44336; color:white; padding:5px 10px; border-radius:5px; border:none; cursor:pointer;">Reject</button>
                        </form>
                    </td>
                </tr>
                @endforeach
  
            </tbody>
        </table>
    </div>

</div>
@endsection