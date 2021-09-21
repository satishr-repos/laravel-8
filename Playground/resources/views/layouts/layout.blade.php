<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/app.css')) }}">
    {{-- <script src="{{ asset(mix('js/app.js')) }}" async defer></script> --}}
</head>

<body>
    @include('partials.nav')
    @yield('content')
    @include('partials.footer')
    @hasSection('scripts')@yield('scripts')@endif
</body>

</html>
