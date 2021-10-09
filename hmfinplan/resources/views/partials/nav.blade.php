<nav class="py-1 h-16 bg-white border-b border-gray-100 flex justify-evenly items-center">

    {{-- Navbar brand --}}
    <div class="ml-5 uppercase font-merriweather">
        {{-- <a href="#" class="flex items-center py-4 px-2"> --}}
        <a class="transform flex items-center py-4 px-2 hover:scale-110" href=" {{ url('/') }}">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-8 w-12 mr-2 " />
            <span class="font-semibold text-gray-500 text-lg">{{ config('app.name', 'Harmoney Wealth') }}</span>
        </a>
    </div>

    <!-- Left Side Of Navbar -->
    {{-- <ul class="flex-grow">
        <div>
            <li>Home</li>
        </div>
    
        <div>
            <li>Services</li>
        </div>
    
        <div>
            <li>About</li>
        </div>
    </ul> --}}

    <!-- Right Side Of Navbar -->
    <div class="flex-grow">
        <ul class="flex justify-end items-center">
        <!-- Authentication Links -->
        @guest
            @if (Route::has('login'))
                <li class="">
                        <a class=" " href=" {{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif

            @if (Route::has('register'))
                <li class="">
                        <a class="" href=" {{ route('register') }}">
                    {{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="flex-grow text-right mr-5">
                <span class="">Hello {{ Auth::user()->name }}</span>        
            </li>

            <li class="mr-3">
                <button class="px-4 py-2 text-sm font-medium border focus:outline-none focus:ring transition text-gray-600 border-gray-600 hover:text-white hover:bg-gray-600 active:bg-gray-700 focus:ring-gray-300 rounded inline-flex justify-center" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    <span>{{ __('Logout') }}</span>
                </button>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        @endguest
        </ul>
    </div>
</nav>
