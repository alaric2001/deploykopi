<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Seteguk Kopi</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo_icon_black.png') }}">
    <link rel="stylesheet" href="{{ asset('css/adminkopi.css') }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{-- @vite('resources/css/app.css') --}}
    @include('layouts.vitecode')

    <!-- Lightbox CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />
    
</head>
<body class="bg-[#f3f3f3]">
    <div class="flex gap-1">
        @include('layouts.sidebar')
        <div class="ml-[220px] flex-1 overflow-x-auto overflow-y-auto">
            @yield('admin-content')
        </div>
    </div>
    
    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
</body>
</html>