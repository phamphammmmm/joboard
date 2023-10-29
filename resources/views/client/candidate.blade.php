<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/client/candidate.css')}}">
    <title>Document</title>
</head>

<body>
    @extends('layout.layout')
    @section('title','Trang chủ')
    @section('content')
    <div class="candidate-title">
        <h1> Popular Candidates</h1>
        <p class=" scrolling-text">Recruiter can choose their employee from these. They are most skillful in their
            respected field with diversified experience
        </p>
    </div>
    <div class="candidate-container">
        <div class="candidate">
            <img src="storage/avatar/avatar.jpg" alt="logo">
            <div class="detail-infomation">
                <h2 class="name">AAhil</h2>
                <p class="position">Nusring Assitant</p>
            </div>
            <button class="view-profile-btn">View profile</button>
        </div>

        <div class="candidate">
            <img src="storage/avatar/avatar.jpg" alt="logo">
            <div class="detail-infomation">
                <h2 class="name">AAhil</h2>
                <p class="position">Nusring Assitant</p>
            </div>
            <button class="view-profile-btn">View profile</button>
        </div>

        <div class="candidate">
            <img src="storage/avatar/avatar.jpg" alt="logo">
            <div class="detail-infomation">
                <h2 class="name">AAhil</h2>
                <p class="position">Nusring Assitant</p>
            </div>
            <button class="view-profile-btn">View profile</button>
        </div>

        <div class="candidate">
            <img src="storage/avatar/avatar.jpg" alt="logo">
            <div class="detail-infomation">
                <h2 class="name">AAhil</h2>
                <p class="position">Nusring Assitant</p>
            </div>
            <button class="view-profile-btn">View profile</button>
        </div>
    </div>
    @endsection
</body>

</html>