<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="storage/logo/circle.png">
    <link rel="stylesheet" href="{{ asset('css/client/category.css') }}">
    <title>Category</title>
</head>

<body>
    @extends('layout')
    @section('title', 'Trang chủ')
    @section('content')
    <div class="category-title" style="width:52%;">
        <h4>Feature Categories</h4>
        <span class="scrolling-text">Find your desired job from the crowed. Those have been collected according to
        </span>
        <span class="scrolling-text" style="display: flex;align-items: center;justify-content: center;"> most popular
            and demandable for employees</span>
    </div>
    <div class="search-navigate">
        <div class="search">
            <div class="search-content"></div>
            <button>
                <ion-icon name="search-outline"></ion-icon>
            </button>
        </div>
    </div>
    <button class="view-all-btn">View All</button>
    <div class="category-container">
        <div class="category-job">
            @if(!empty($categories))
            @foreach($categories as $category)
            <form action="{{route('category.display')}}" method="GET" enctype="multipart/form-data">
                @csrf
                @method('GET')
                <button type="submit" class="submit-btn-primary" style="background:none;border:none;">
                    <div class="item">
                        <input type="hidden" name="category_id" id="category_id" value="{{$category->id}}">
                        <img src="{{ asset($category->path) }}" alt="path">
                        <h3>{{$category->name}}</h3>
                        <p>{{$category->jobs_count}} vacancies</p>
                    </div>
                </button>
            </form>
            @endforeach
            @endif
        </div>
    </div>



    <div class="discover-job">
        <div class="discover-overall">
            <div class="discover-content">
                <h1>Discover you job</h1>
                <p>There are a huge collection of latest job post. You can find out you
                    perfect job here to
                    discover you deserve job with high trustable for eneryone.
                </p>
            </div>
            <button class="brower-all-btn"><a href="{{route('job')}}">Brower All</a></button>
        </div>
        <div class="job-market">
            @foreach($topCategories as $categoryItem)
            <div class="job-brower-all">
                <img src="{{ asset( $categoryItem->path) }}" alt="path">
                <h3>{{ $categoryItem->name }}</h3>
                <p>{{ $categoryItem->jobs_count }} Vacancies</p>
            </div>
            @endforeach
        </div>
    </div>
    @endsection
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryItems = document.querySelectorAll('.category-job .item');
        const viewAllBtn = document.querySelector('.view-all-btn');

        const showItems = (startIndex, endIndex) => {
            categoryItems.forEach((item, index) => {
                if (index >= startIndex && index <= endIndex) {
                    item.style.display = 'grid';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        viewAllBtn.addEventListener('click', function() {
            showItems(0, categoryItems.length - 1);
            this.style.display = 'none';
        });

        // Ban đầu chỉ hiển thị 8 phần tử đầu tiên
        showItems(0, 7);
    });
    </script>
</body>

</html>