<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/styles.css')) }}">
    {{-- <script src="{{ asset(mix('js/app.js')) }}" async defer></script> --}}
</head>

<body>
    @include('partials.nav')
    @yield('content')
    @include('partials.footer')
    @hasSection('scripts')@yield('scripts')@endif
</body>

</html>
