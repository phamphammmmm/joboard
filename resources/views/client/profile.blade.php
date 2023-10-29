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
    @extends('layout.layout')
    @section('title', 'Trang chủ')
    @section('content')
    <div class="container">
        <div class="col-8">
            <div class="preview">
                <img src="{{asset('storage/avatar/cover-image.jpg')}}" alt="cover-image" class="cover-image">
                <div class="information-overall">
                    <img src="{{ $user->path }}" alt="Avatar" class="avatar">
                    <div class="overall-information">
                        <div class="information">
                            <h3>{{$user->name}}</h3>
                            <div class="birthday">Birthday: {{$user->birthday}}</div>
                            <div class="email">Email: {{$user->email}}</div>
                            <div class="address">Address: {{$user->location}}</div>
                            <div class="social_netwwork"></div>
                        </div>
                        <button id="edit-profile-btn" data-id="{{$user->id}}">
                            <img src="{{asset('storage/logo/draw.png')}}" alt="edit">
                        </button>
                    </div>
                </div>
            </div>
            <div class="description">
                <div class="profile-header">
                    <h3>Description</h3>
                </div>
                <span>
                    {{$user->description}}
                </span>
            </div>
            <div class="education">
                <div class="profile-header">
                    <h3>University</h3>

                </div>
                <span>PTIT</span>
            </div>
            <div class="activity">
                <div class="profile-header">
                    <h3>Activity</h3>

                </div>
            </div>
            <div class="skill">
                <div class="profile-header">
                    <h3>Skills</h3>
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

    <div class="popup-overlay" id="Edit-Profile-Popup">
        <div class="popup-content">
            <h3>Add Information</h3>
            <form id="Edit-Profile-Form" method="POST" action="{{ route('manage.edit') }}"
                enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input type="hidden" name="editUserId" value="" id="editUserId">

                <label for="name">Username:</label>
                <input type="text" name="name" id="editName">

                <label for="fullname">Fullname:</label>
                <input type="text" name="fullname" id="editFullname">

                <label for="email">Email*</label>
                <input type="text" name="email" id="editEmail" placeholder="Email">

                <label for="description">Desciption*</label>
                <textarea type="text" name="description" id="editDescription" placeholder="description"></textarea>

                <label for="location">Address*</label>
                <input type="text" name="location" id="editLocation" placeholder="address">

                <label for="major">Major:</label>
                <input type="text" name="major" id="editMajor">

                <button type="submit" class="save-button">Save</button>
            </form>
        </div>
    </div>
    @endsection
    <script src="{{ asset('js/client/profile.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>