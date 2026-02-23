@extends('layouts.admin')

@push('customcss')
<link rel="stylesheet" href="{{ asset('css/admindash.css') }}">
@endpush

@section('content')
<div class="main-content">
    <div class="top-bar">
        <h1> Students Leave</h1>
      
    </div>

    <div class="table-wrapper">
        <table class="student-table">
                {{-- @if ($users->count() > 0) --}}

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Start date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            {{-- @endif --}}

            <tbody>
                <!-- Example rows; replace with backend data -->

                @foreach ($users as $item)
                <tr>
                    <td>{{$item->users->id}}</td>
                    <td>{{$item->users->name}}</td>
                    <td>{{$item->users->email}}</td>
                    
                    <td>{{ Carbon\Carbon::parse( $item->start_date)->format('d-m-Y')}} </td>
                    <td>{{Carbon\Carbon::parse( $item->end_date)->format('d-m-Y')}}</td>
        
                    <td>
                        <a href="{{ route('adminshowleave' , $item->id) }}" class="btn-action" style="background:green;">View</a>
                    
                    <form action="{{ route('deleteleave' , $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                    <button type="submit" class="btn-action" style="background:red;">Delete</button>
                    </form>
                       
                    </td>
   
                </tr>     
                @endforeach
               

                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
</div>
@endsection