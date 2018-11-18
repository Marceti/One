<div class="card-body">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ route('home')}}">Home</a>
                <a href="{{ route('logout') }}">{{Auth::user()->name}} | Logout</a>

            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif
</div>