<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    @csrf
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/recruiter/dashboard.css') }}">
</head>

<body>
    <div class="navbar">
        <div class="left_sidebar">
            <ul>
                <li class="logo">
                    <img src="{{asset('storage/logo/logo.png')}}" alt="logo">
                </li>
                <li class="navbar-link">
                    <a href="{{ route('recruiter.oversee') }}"><img src="{{asset('storage/logo/home.png')}}"
                            alt="home"></a>
                </li>
                <li class="navbar-link">
                    <a href="{{ route('job.show') }}"><img src="{{asset('storage/logo/dashboard.png')}}"
                            alt="category"></a>
                </li>
                <li class="navbar-link">
                    <a href="{{ route('company.show') }}"><img src="{{ asset('storage/logo/approved.png') }}"
                            alt="group-chat"></a>
                </li>
                <li>
                    <button id="dark-mode-toggle">
                        <ion-icon name="invert-mode-outline"></ion-icon>
                    </button>
                </li>
            </ul>
            <div id="spacing" style="height:20%;"> </div>
            <div class="logout">
                <form action="{{ route('logout') }}" method="POST" style="display:flex;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <img src="{{asset('storage/logo/shutdown.png')}}" alt="shutdown">
                    </button>
                </form>
            </div>
        </div>
        <div class="content">
            <button id="sidebar-toggle"><i class="fa-solid fa-equals"></i></button>
            <div id="content-container">
                @yield('content')
            </div>
        </div>
        <!-- <div class="right-sidebar">
            <div class="infomation">
                <div class="avatar">
                    <img src="{{ Auth::user()->path }}" alt="Avatar">
                    <div class="active-indicator"></div>
                </div>
                <div class="user-info">
                    <h3>{{ Auth::user()->name }}</h3>
                    <p>{{ Auth::user()->industry }}</p>
                </div>
            </div>
        </div> -->
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/recuiter/dashboard.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>