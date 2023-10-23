<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="storage/logo/circle.png">
    <link rel="stylesheet" href="{{ asset('css/client/home.css') }}">
    <title>Home</title>
</head>

<body>
    @extends('layout')
    @section('title', 'Trang chủ')
    @section('content')
    <div class="home-page">
        <div class="home-content">
            <h1>Find Your Next Job And Make Your Own Goal.</h1>
            <p>We are best global job finder agency and millons
                of people liked trusted our platform
            </p>
            <div class="navigate-btn">
                <div class="job-title">
                    <h5>Job Title</h5>
                    <p>Type Here</p>
                </div>
                <div class="location">
                    <h5>Location</h5>
                    <p>Select Here</p>
                </div>
                <div class="get-started">
                    <button class="get-started-btn"><a href="{{ route('job')}}">Get Started</a></button>
                </div>
            </div>
            <div class="company">
                <h2 class="sponsor">
                    We are Trusted By
                </h2>
                <div class="company-image">
                    <img src="storage/logo/facebook.png" alt="logo"
                        style="border-radius: 50%;height: 50px;width: 50px;">
                    <img src="storage/logo/google.png" alt="logo" style="border-radius: 50%;height: 50px;width: 50px;">
                    <img src="storage/logo/spotify.png" alt="logo" style="border-radius: 50%;height: 50px;width: 50px;">
                    <img src="storage/logo/twitter.png" alt="logo" style="border-radius: 50%;height: 50px;width: 50px;">
                    <img src="storage/logo/ibm.png" alt="logo" style="border-radius: 50%;height: 50px;width: 50px;">
                </div>
            </div>
        </div>
        <div class="home-image">
            <div class="col">
                <img src="storage/logo/pexels-djordje-petrovic-2102416.jpg" alt="logo"
                    style="border-radius: 5px;height: 150px;width: 150px;">
                <img src="storage/logo/pexels-djordje-petrovic-2102416.jpg" alt="logo"
                    style="border-radius: 5px;height: 150px;width: 150px;">
            </div>
            <div class="col">
                <img src="storage/logo/pexels-cottonbro-studio-4064840.jpg" alt="logo"
                    style="border-radius: 5px;height: 185px;width: 150px;">
                <img src="storage/logo/pexels-cottonbro-studio-4064840.jpg" alt="logo"
                    style="border-radius: 5px;height: 115px;width: 150px;">
            </div>
        </div>
    </div>
    @endsection
</body>

</html>