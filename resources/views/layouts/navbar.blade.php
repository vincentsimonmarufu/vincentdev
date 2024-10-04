<nav class="nav-menu d-none d-lg-block">
    <ul>
        <li 
            @if (Route::currentRouteName() == 'welcome')
                class="active"
            @endif
        >
            <a href="{{ route('welcome') }}">Home</a>
        </li>
        <li
            @if (Route::currentRouteName() == 'flight')
                class="active"
            @endif
        >
            <a href="{{route('flight')}}">Flights</a>
        </li>
        <li
            @if (Route::currentRouteName() == 'car_hire')
                class="active"
            @endif
            
            >
            <a href="{{route('car_hire')}}">Car Hire</a>
        </li>
        <li
            @if (Route::currentRouteName() == 'apartments.all')
                class="active"
            @endif
        >
            <a href="{{ route('apartments.all') }}">Apartments</a>
        </li>
        <li
            @if (Route::currentRouteName() == 'gallery')
                class="active"
            @endif
        >
            <a href="{{route('gallery')}}">Gallery</a>
        </li>       

        <li>
            <a href="{{route('register')}}">List property & car</a>
        </li>
        <li 
            @if (Route::currentRouteName() == 'contact')
                class="active"
            @endif
        >
            <a href="{{route('contact')}}">Contact</a>
        </li>
        <div id="mobileLogin">
            <li><a href="{{route('login')}}">Sign in</a></li>
            <li><a href="{{route('register')}}">Register</a></li>
        </div>
        @if (auth()->user() != null)
            <li class="drop-down ml-4">
                <a href="">{{ auth()->user()->name }}</a>
                <ul>
                    <li><a href="{{ route('home') }}">Dashboard</a></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                    </li>
                </ul>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endif
    </ul>
</nav><!-- .nav-menu -->