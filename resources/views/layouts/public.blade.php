<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('fraternity.name') }}</title>

        <link href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
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

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

            <footer class="footer">
                <p>&copy; {{ date('Y') }} {{ config('fraternity.name') }}</p>
            </footer>

        </div> <!-- /container -->

    </body>
</html>
