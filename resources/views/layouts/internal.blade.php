<!DOCTYPE html>
<html lang="en">
    <head>
        @include('partials.head')
    </head>

    <body class="k-body-internal">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#k-navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">{{ trans('internal.toggle_navigation') }}</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('home') }}">{{ settings('fraternity.name') }}</a>
                </div>
                <div id="k-navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">

                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Auth::user()->profilePictureRoute() }}" style="height:18px;">
                                {{ Auth::user()->member->getShortName() }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @permission('access.backend')
                                    <li><a href="{{ url('backend') }}">{{ trans('internal.go_to_backend') }}</a></li>
                                @endpermission
                                <li><a href="{{ url('logout') }}">{{ trans('internal.logout') }}</a></li>
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
                <p>&copy; {{ date('Y') }} {{ settings('fraternity.name') }}</p>
            </footer>

        </di v> <!-- /container -->

        <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>

        @stack('scripts')

    </body>
</html>
