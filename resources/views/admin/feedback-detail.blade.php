<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin/feedback-detail.css') }}">
    <title>Document</title>
</head>

<body>
    @extends('admin.dashboard')
    @section('content')
    <div class="filter">
        <form id="feedbackFilterForm" action="{{route('feedback.search')}}" method="GET">
            @csrf
            <div class="form-group">
                <div class="form-col">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter user...">
                </div>
                <div class="form-col">
                    <select class="form-control" id="dateRange" name="dateRange">
                        <option value="" disabled selected>Week</option>
                        <option value="7">1 week</option>
                        <option value="14">2 weeks</option>
                        <option value="30">1 month</option>
                        <option value="60">2 month</option>
                        <option value="90">3 month</option>
                    </select>
                </div>
                <div class="form-col">
                    <select class="form-control" id="rating" name="rating">
                        <option value="" disabled selected>Rating</option>
                        <option value="1">1 &#9733</option>
                        <option value="2">2 &#9733</option>
                        <option value="3">3 &#9733</option>
                        <option value="4">4 &#9733</option>
                        <option value="5">5 &#9733</option>
                    </select>
                </div>
                <div class="form-col">
                    <select class="form-control" id="sortOrder" name="sortOrder">
                        <option value="" disabled selected>Sort</option>
                        <option value="asc">asc</option>
                        <option value="desc">desc</option>
                    </select>
                </div>
            </div>
            <div class="active-btn-primary">
                <button type="submit" class="search-btn-primary">
                    <ion-icon name="search-outline"></ion-icon>
                </button>
                <button type="button" id="show-all-button">
                    <ion-icon name="refresh-outline"></ion-icon>
                </button>
            </div>
        </form>
    </div>

    <div class="feedback-list">
        @foreach($feedbacks as $feedback)
        <div class="feedback-item">
            <div class="user">
                <h3 class="name">{{ $feedback->user->name }}</h3>
                <div class="rating">
                    <span class="star">&#9733;</span>{{ $feedback->rating }}/5
                    <form method="POST" action="{{ route('feedback.delete', ['id' => $feedback->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure to delete?')"
                            id="delete-feedback-btn">
                            <ion-icon name="close-outline"></ion-icon>
                        </button>
                    </form>
                </div>
            </div>
            <p class="comment" style="text-align: justify;">
                {{ $feedback->comment }}
            </p>
            <div class="time">
                <p class="created_at">
                    {{ \Carbon\Carbon::parse($feedback->created_at)->format('d M Y') }}
                </p>
                <p class="email">{{ $feedback->user->email }}</p>
            </div>
        </div>
        @endforeach
    </div>
    <script>
    const showAllButton = document.getElementById('show-all-button');
    showAllButton.addEventListener('click', function() {
        window.location.href = "{{ route('feedback.display') }}";
    });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="{{asset('js/admin/feedback-detail.js')}}"></script>
    @endsection
</body>

</html>