<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/client/feedback.css')}}">
    <title>Document</title>
</head>

<body>
    @extends('layout.layout')
    @section('title', 'Trang chủ')
    @section('content')
    <h1>Top Feedback</h1>
    <div class="feedback-title">
        <div class="feedback-overall">
            <div class="feedback-header">
                <h2 style="font-size: 30px;">What our client saying about us?</h2>
                <p>Our users are saying about us how they have got their job from this platform. From these
                    insights, you can make a better decision by analyzing those.
                </p>
            </div>
            <button class="view-all-btn">View All</button>
        </div>
    </div>
    <div class="list-feedback">
        @if (!empty($feedback))
        @foreach($feedback as $feedbackItem)
        <div class="item feedback-item">
            <img src="{{ asset( $feedbackItem->user->path) }}" alt="path">
            <div class="item-detail">
                <div class="rating" data-rating="{{ $feedbackItem->rating }}">
                    <!-- JavaScript sẽ tự động thêm sao vào đây -->
                </div>
                <p class="feedback-content">
                    {{ $feedbackItem->comment }}
                </p>
                <h3 class="name">{{ $feedbackItem->user->name }}</h3>
                <p class="position">{{ $feedbackItem->user->major }}</p>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const feedbackItems = document.querySelectorAll('.feedback-item');
        const viewAllBtn = document.querySelector('.view-all-btn');

        const showItems = (startIndex, endIndex) => {
            feedbackItems.forEach((item, index) => {
                if (index >= startIndex && index <= endIndex) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        viewAllBtn.addEventListener('click', function() {
            showItems(0, feedbackItems.length - 1);
            this.style.display = 'none';
        });

        // Ban đầu chỉ hiển thị 9 phần tử đầu tiên
        showItems(0, 5);
    });
    </script>
    <script src="{{asset('js/feedback.js')}}"></script>
    @endsection
</body>

</html>