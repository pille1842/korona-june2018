<!DOCTYPE html>
<html lang="en">
    <head>
        @include('partials.head')
    </head>

    <body class="k-body-public">

        <div class="container">

            <div class="header clearfix">
                <nav>
                    <ul class="nav nav-pills pull-right">
                        <li{!! Route::getCurrentRoute()->getPath() == '/' ? ' class="active"' : '' !!}><a href="{{ url('/') }}">Startseite</a></li>
                        @if (Auth::guest())
                            <li><a href="{{ url('login') }}">Anmelden</a></li>
                        @else
                            <li><a href="{{ url('home') }}">Interner Bereich</a></li>
                        @endif
                    </ul>
                </nav>
                <h3 class="text-muted"><img src="{{ asset(config('fraternity.zirkel')) }}" alt=""> {{ config('fraternity.name') }}</h3>
            </div>

            @include('partials.messages')

            @yield('content')

            <footer class="footer">
                <p>&copy; {{ date('Y') }} {{ config('fraternity.name') }}</p>
            </footer>

        </div> <!-- /container -->

    </body>
</html>
