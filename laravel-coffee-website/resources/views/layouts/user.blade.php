<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('judul') | Seteguk Kopi</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo1.png') }}">
    <link rel="stylesheet" href="{{ asset('css/kopi.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{-- @vite('resources/css/app.css') --}}
    @include('layouts.vitecode')

    <!-- PWA  -->
    {{-- <meta name="theme-color" content="#6777ef"/> --}}
    {{-- <link rel="manifest" href="{{ asset('/manifest.json') }}"> --}}
    <link rel="apple-touch-icon" href="{{ asset('images/logo1.png') }}">
    <link rel="manifest" crossorigin="use-credentials" href="{{ asset('/manifest.json?v=1.0.1') }}">
    <meta name='theme-color' content="#3d372b">

</head>
<body class="bg-[#ececec]">
    @include('layouts.nav_user')
    
    <div class="">
        {{-- <h2>Layout User</h2> --}}
        @yield('content')
    </div>

    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if ("serviceWorker" in navigator) {
            // Register a service worker hosted at the root of the
            // site using the default scope.
            navigator.serviceWorker.register("/sw.js").then(
            (registration) => {
                console.log("Service worker registration succeeded:", registration);
            },
            (error) => {
                console.error(`Service worker registration failed: ${error}`);
            },
            );
        } else {
            console.error("Service workers are not supported.");
        }
    </script>
</body>
</html>