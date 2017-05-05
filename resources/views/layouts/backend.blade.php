<!DOCTYPE html>
<html lang="en">
    <head>
        @include('partials.head')
    </head>

    <body class="k-body-backend">

        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#k-navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Navigation ein-/ausblenden</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('backend') }}">{{ config('fraternity.name') }} &ndash; Backend</a>
                </div>
                <div id="k-navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                Benutzer
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @permission('backend.manage.users')
                                    <li><a href="{{ action('Backend\UserController@index') }}">{{ trans('backend.accounts') }}</a></li>
                                @endpermission
                                <li><a href="#">Seitenrollen</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->login }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('home') }}">Zum internen Bereich</a></li>
                                <li><a href="{{ url('logout') }}">Abmelden</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="k-main-container" class="container">

            @include('partials.messages')

            @yield('content')

            <footer class="footer">
                <p>&copy; {{ date('Y') }} {{ config('fraternity.name') }}</p>
            </footer>

        </di v> <!-- /container -->

        <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>

        @yield('scripts')

    </body>
</html>
