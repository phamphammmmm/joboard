<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/recruiter/oversee.css')}}">
</head>

<body>
    @extends('recruiter.dashboard')
    @section('content')
    <div class="header-title">
        <div class="account">
            <h1 class="h1-title">HELLO,{{Auth::user()->name}}</h1>
            <p>Track job progress here. You almost reach a goal!!</p>
        </div>
        <div class="time">
            {{ \Carbon\Carbon::now()->format('d M. Y') }}
            <img src="{{asset('storage/logo/calendar.png')}}" alt="calendar">
        </div>
    </div>
    <div class="overview">
        <div class="efficiency">
            <img src="{{asset('storage/logo/up-arrow.png')}}" alt="up-arrow">
            <div class="efficiency-percent">
                <h4>Efficiency</h4>
                <span class="percent">93%</span>
            </div>
        </div>
        <div class="efficiency">
            <img src="{{asset('storage/logo/up-arrow.png')}}" alt="up-arrow">
            <div class="efficiency-percent">
                <h4>Efficiency</h4>
                <span class="percent">93%</span>
            </div>
        </div>
        <div class="efficiency">
            <img src="{{asset('storage/logo/up-arrow.png')}}" alt="up-arrow">
            <div class="efficiency-percent">
                <h4>Efficiency</h4>
                <span class="percent">93%</span>
            </div>
        </div>
    </div>
    <div class="performance">
        <h3>PERFOMRANCE</h3>
        <div class="chart">

        </div>
    </div>
    <div class="current-job">

    </div>
    @endsection
</body>

</html>