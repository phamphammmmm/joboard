<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/client/profile.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <title>Profile</title>
</head>

<body>
    @extends('layout')
    @section('title', 'Trang chủ')
    @section('content')
    <div class="container">
        <div class="col-8">
            <div class="preview">
                <img src="{{asset('storage/avatar/cover-image.jpg')}}" alt="cover-image" class="cover-image">
                <div class="information-overall">
                    <img src="{{ $user->path }}" alt="Avatar" class="avatar">
                    <div class="information">
                        <h3>{{$user->name}}</h3>
                        <div class="birthday">Birthday: {{$user->birthday}}</div>
                        <div class="email">Email: {{$user->email}}</div>
                        <div>Address: {{$user->address}}</div>
                        <div class="social_netwwork"></div>
                    </div>
                </div>
            </div>
            <div class="description">
                <div class="profile-header">
                    <h3>Description</h3>
                    <button class="edit-profile-btn" data-id="{{$user->id}}">
                        <img src="{{asset('storage/logo/draw.png')}}" alt="edit">
                    </button>
                </div>
                <span>Overall, I had a positive experience using your job board website, and I will certainly
                    continue to explore the opportunities it offers. Thank you for providing a platform that
                    facilitates the job search process effectively.One area for potential improvement could be in
                    the notification system for new job postings or updates. Implementing an email or notification
                    feature could keep users informed about relevant opportunities in real-time, enhancing
                    engagement and user satisfaction.
                </span>
            </div>
            <div class="education">
                <div class="profile-header">
                    <h3>University</h3>
                    <button class="edit-profile-btn" data-id="{{$user->id}}">
                        <img src="{{asset('storage/logo/draw.png')}}" alt="edit">
                    </button>
                </div>
                <span>PTIT</span>
            </div>
            <div class="activity">
                <div class="profile-header">
                    <h3>Activity</h3>
                    <button class="edit-profile-btn" data-id="{{$user->id}}">
                        <img src="{{asset('storage/logo/draw.png')}}" alt="edit">
                    </button>
                </div>
            </div>
            <div class="skill">
                <div class="profile-header">
                    <h3>Skills</h3>
                    <button class="edit-profile-btn" data-id="{{$user->id}}">
                        <img src="{{asset('storage/logo/draw.png')}}" alt="edit">
                    </button>
                </div>
                <span>{{$user->major}}</span>
            </div>

        </div>
        <div class="col-4">
            <div class="setting">

            </div>
            <img src="{{asset('storage/logo/preview.png')}}" alt="preview">
        </div>
    </div>
    @endsection
    <script src="{{ asset('js/profile.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>