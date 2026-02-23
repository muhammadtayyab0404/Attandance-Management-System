@extends('layouts.admin')

@push('customcss')
<link rel="stylesheet" href="{{ asset('css/admindash.css') }}">
@endpush

@section('content')
<div class="main-content">
    <div class="top-bar">
        <h1> Students Attendance</h1>
      
    </div>

    <div class="table-wrapper">
        <table class="student-table">
                @if ($users->count() > 0)

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            @endif

            <tbody>
                <!-- Example rows; replace with backend data -->

                @foreach ($users as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->email}}</td>
        
                    <td>
                        <a href="{{ route('showattend' , $item->id) }}" class="btn-action" style="background:green;">View</a>
                    
                    {{-- <form action="{{ route('deleteattend' , $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                    <button type="submit" class="btn-action" style="background:red;">Delete</button>
                    </form> --}}
                       
                    </td>
   
                </tr>     
                @endforeach
               

                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
</div>
@endsection