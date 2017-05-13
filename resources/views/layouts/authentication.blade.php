<!DOCTYPE html>
<html lang="en">
    <head>
        @include('partials.head')
    </head>

    <body class="k-body-authentication">

        <div class="container">

            <header class="header">
                <a href="{{ url('/') }}"><img src="{{ asset('images/korona.png') }}" alt="Korona"></a>
            </header>

            @include('partials.messages')

            @yield('content')

            <footer class="footer">
                <p>&copy; {{ date('Y') }} {{ settings('fraternity.name') }}</p>
            </footer>

        </div> <!-- /container -->

    </body>
</html>
