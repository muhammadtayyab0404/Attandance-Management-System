@extends('layouts.main')

@section('content')
<div class="main-content">
    <div class="profile-form-container">
        <h1>Edit Profile</h1>

       

            <!-- Existing Profile Picture -->
            <div class="existing-picture">
                <p>Current Profile Picture:</p>
                @if($profilepic)
                <img src="{{asset('storage/'.($profilepic->photo))}}" alt="Profile Picture" class="profile-img">
                @else
            <img src="https://ui-avatars.com/" alt="No Profile Picture" class="profile-img">
                @endif
            </div>

         <form action="{{ route('updateprofiless') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Name -->
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" class="form-control" value="{{$user->name}}">
            </div>

            <!-- Age -->
            <div class="form-group">
                <label for="age">Age: </label>
                <input type="number" id="age" name="age" placeholder="Enter your age" class="form-control" value= {{intval( $user->age)}}>
            </div>

            <!-- Upload New Profile Picture -->
            <div class="form-group">
                <label for="profile_picture">Upload New Profile Picture:</label>
                <input type="file" id="profile_picture" name="photo" class="form-control">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">Update Profile</button>
        </form>
    </div>
</div>

<style>
.main-content {
    max-width: 600px;
    margin: 40px auto;
    padding: 25px;
    background: #f9f9f9;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.1);
}

.profile-form-container h1 {
    text-align: center;
    margin-bottom: 25px;
    font-size: 28px;
}

.existing-picture {
    text-align: center;
    margin-bottom: 20px;
}

.existing-picture p {
    font-weight: 500;
    margin-bottom: 10px;
}

.profile-img {
    width: 120px;
    height: 120px;
    min-width: 120px;
    min-height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #007bff;
    display: block;
    margin: 0 auto;
    flex-shrink: 0;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

.form-group label {
    font-weight: 500;
    margin-bottom: 5px;
}

.form-control {
    padding: 10px 12px;
    font-size: 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    width: 100%;
    box-sizing: border-box;
}

input[type="file"].form-control {
    padding: 5px;
}

.btn-submit {
    width: 100%;
    padding: 12px 0;
    background-color: #007bff;
    color: #fff;
    font-size: 16px;
    font-weight: 500;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-submit:hover {
    background-color: #0056b3;
}

/* Responsive */
@media (max-width: 480px) {
    .main-content {
        padding: 15px;
        margin: 20px;
    }

    .profile-img {
        width: 100px;
        height: 100px;
    }
}
</style>
@endsection
