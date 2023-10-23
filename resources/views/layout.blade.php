<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
</head>

<body>
    @include('partials.header')

    <div class="content">
        @yield('content')
    </div>

    @include('partials.footer')
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>