<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Harmoney Wealth') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Montserrat:wght@100;200;300;400;500;600;700&family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Raleway:wght@100;200;300;400;500;600;700&family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;700&family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>
<body class="antialiased">
    <section class="pt-24 bg-white">
        <div class="px-12 mx-auto max-w-7xl">
            <div class="w-full mx-auto text-left md:w-11/12 xl:w-9/12 md:text-center">
                <h1 class="mb-8 text-4xl font-extrabold leading-none tracking-normal text-gray-900 md:text-6xl md:tracking-tight">
                    <span>Welcome to the</span> <span class="block w-full py-2 text-transparent bg-clip-text leading-12 bg-gradient-to-r from-green-400 to-purple-500 lg:inline">Harmoney Wealth</span> <span>intranet page 🚀</span>
                </h1>
                <p class="px-0 mb-8 text-lg text-gray-600 md:text-xl lg:px-24">
                    Start using the tools that gives you access to the customer information that you've always wanted. Generate reports and much more...
                </p>
                <div class="mb-4 space-x-0 md:space-x-2 md:mb-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center w-full px-6 py-3 mb-2 text-lg text-white bg-green-400 rounded-2xl sm:w-auto sm:mb-0">
                        Get Started
                        <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                    <a href="#_" class="inline-flex items-center justify-center w-full px-6 py-3 mb-2 text-lg bg-gray-100 rounded-2xl sm:w-auto sm:mb-0">
                        Learn More
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    </a>
                </div>
            </div>
            <div class="w-full mx-auto mt-20 text-center md:w-10/12">
                <div class="relative z-0 w-full mt-8">
                    <div class="relative overflow-hidden shadow-2xl">
                        <div class="flex items-center flex-none px-4 bg-green-400 rounded-b-none h-11 rounded-xl">
                            <div class="flex space-x-1.5">
                                <div class="w-3 h-3 border-2 border-white rounded-full"></div>
                                <div class="w-3 h-3 border-2 border-white rounded-full"></div>
                                <div class="w-3 h-3 border-2 border-white rounded-full"></div>
                            </div>
                        </div>
                        {{-- <img src="https://cdn.devdojo.com/images/march2021/green-dashboard.jpg"> --}}
                        <img src="{{ asset('img/hero_image_snap.jpg')}}">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <p class="text-gray-300 text-sm text-right">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
</body>
</html>
