<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ url('/') }}">
            {{-- <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28"> --}}
            <img src="{{url('/images/logo.png')}}" width="112" height="28">
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="{{ url('/') }}">
                Home
            </a>

            <a class="navbar-item" href="{{ url('/employees') }}"">
                Employees 
            </a>
        </div>
    </div>

    <div class="navbar-end">
        @guest
            @if (Route::has('login'))
                <a class="navbar-item" href="{{ route('login') }}">{{ __('Login') }}</a>
            @endif

            @if (Route::has('register'))
                <a class="navbar-item" href="{{ route('register') }}">{{ __('Register') }}</a>
            @endif
        @else
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    {{ Auth::user()->name }}
                </a>

                <div class="navbar-dropdown">
                    <a href="{{ route('logout') }} class=" navbar-item" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        @endguest
    </div>
</nav>