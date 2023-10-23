<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/client/company.css')}}">
    <title>Company</title>
</head>

<body>
    @extends('layout')
    @section('title','Trang chủ')
    @section('content')
    <div class="company-title" style="width:52%;">
        <h2> Top Companies</h2>
        <span class="scrolling-text">Higt level of companies are offering job to recruite for their company. You can
        </span>
        <span class="scrolling-text" style="display: flex;align-items: center;justify-content: center;">discover you
            perfect job from the bellow companies. </span>
    </div>
    <div class="list-company">
        @foreach($companies as $company)
        <!-- <form action="{{route('company.display')}}" method="GET" enctype="multipart/form-data"> -->
        @csrf
        <!-- <button type="submit" class="submit-btn-primary"> -->
        <div class="item">
            <input type="hidden" id="company_id" name="company_id" value="{{ $company->id}}">
            <img src="{{ asset($company->path) }}" alt="path">
            <div class="company">
                <h4 class="name">{{ $company->name}}</h4>
                <p class="position">Nursing Assistant</p>
                <p>Fairfield</p>
            </div>
            <div class="description">
                <button class="vacancies">{{$company->jobs_count}} Vacancies</button>
                <p class="time">$30-$50/Hourly</p>
            </div>
        </div>
        </button>
        </form>
        @endforeach
        @endsection
</body>

</html>