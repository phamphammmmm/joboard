<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="{{ asset('css/client/header.css') }}">
</head>

<body>
    <div class="header">
        <div class="logo">
            <a href="{{ route('home')}}"><img src="{{asset('storage/logo/logo.png')}}" alt="logo"></a>
            <h3>Jobored</h3>
        </div>
        <div class="main-title">
            <ul>
                <li><a href="{{ route('home')}}">Home</a></li>
                <li><a href="{{ route('job')}}">Jobs</a></li>
                <li><a href="{{ route('category')}}">Category</a></li>
                <li><a href="{{ route('company')}}">Company</a></li>
                <li><a href="{{ route('candidate')}}">Candidate</a></li>
                <li><a href="{{ route('feedback')}}">About us</a></li>
            </ul>
        </div>
        <div class="notify">
            <ul>
                <li id="notification-icon">
                    <a href="">
                        <ion-icon name="notifications-outline"></ion-icon>
                    </a>
                </li>
                <li>
                    <a href="">
                        <ion-icon name="mail-outline"></ion-icon>
                    </a>
                </li>
                <li id="avatar-container">
                    @if (Auth::check())
                    @php
                    $user = Auth::user();
                    $avatarPath = $user->path ? asset($user->path) : asset('storage/avatar/avatar.jpg');
                    @endphp
                    <img src="{{ $avatarPath }}" alt="Avatar" id="avatar">
                    @endif
                    <div id="popup" class="hidden">
                        <a href="{{ route('profile') }}">View Profile</a>
                        <a href="{{route('favorite')}}">
                            <ion-icon name="bookmark-outline"></ion-icon>Save
                        </a>
                        <form action="{{ route('logout') }}" method="POST" style="display:flex;">
                            @csrf
                            <button type="submit" class="logout-btn">Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div id="notification-popup" class="popup-notification" data-receiver-id="{{ Auth::id() }}">
        <div id="popup-notification-content">
            <ul class="notification-list">
                <li></li>
            </ul>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var notificationPopup = document.getElementById('notification-popup');
        var receiverId = notificationPopup.dataset.receiverId;
        console.log(receiverId);

        var notificationIcon = document.getElementById('notification-icon');
        var notificationList = document.querySelector('.notification-list');
        var notificationPopupContent = document.getElementById('popup-notification-content');

        // Function to open popup
        function openPopup() {
            notificationPopup.style.display = 'flex';
            fetchNotifications();
        }

        notificationIcon.addEventListener('click', function(event) {
            event.preventDefault();
            openPopup();
        });

        // Function to fetch notifications
        function fetchNotifications() {
            // Gọi API để lấy thông tin người tuyển dụng
            fetch(`/api/applications/received/${receiverId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(notification => {
                            // Tạo một phần tử li mới chứa thông tin người tuyển dụng
                            var listItem = document.createElement('li');
                            listItem.textContent =
                                `${notification.applicant} is applying for the ${notification.job}`;
                            notificationList.appendChild(listItem);
                        });
                    } else {
                        // Hiển thị thông báo nếu không có thông tin
                        var listItem = document.createElement('li');
                        listItem.textContent = 'No new notifications.';
                        notificationList.appendChild(listItem);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        notificationPopup.addEventListener('click', (event) => {
            if (event.target === notificationPopup) {
                notificationPopup.style.display = 'none';
            }
        });
    });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>