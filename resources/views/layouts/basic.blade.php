<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- =================================== --}}
    {{--                  Style              --}}
    {{-- =================================== --}}
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Icon --}}
    <link rel="shortcut icon" href="{{ asset('images/logo.svg') }}" type="image/x-icon">

    <title>@hasSection('title')@yield('title') | @endif{{ config('app.name','Find Job') }}</title>
</head>

<body>
    {{-- Navbar --}}
    @include('layouts.navbar')
    {{-- /Navbar --}}

    {{-- Messages --}}
    @hasSection('messages')
    
    @else
    @include('layouts.messages')
    @endif
    {{-- /Messages --}}


    {{-- Content --}}
    @yield('content')
    {{-- /Content --}}



    {{-- Footer --}}
    @yield('footer')
    {{-- /Footer --}}


    {{-- JQuery --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    {{-- Macy --}}
    <script src="{{ asset('js/macy.js') }}"></script>
    {{-- Main --}}
    <script src="{{ asset('js/main.js') }}"></script>


    {{-- Custome script for each page --}}
    @yield('script')

</body>

</html>