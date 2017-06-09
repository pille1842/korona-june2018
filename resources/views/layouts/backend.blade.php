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
                        <span class="sr-only">{{ trans('backend.toggle_navigation') }}</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('backend') }}">{{ settings('fraternity.name') }} &ndash; {{ trans('backend.backend') }}</a>
                </div>
                <div id="k-navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ trans('backend.core_data') }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @permission('backend.manage.users')
                                    <li><a href="{{ route('backend.user.index') }}">{{ trans('backend.accounts') }}</a></li>
                                @endpermission
                                @permission('backend.manage.roles')
                                    <li><a href="{{ route('backend.role.index') }}">{{ trans('backend.roles') }}</a></li>
                                @endpermission
                                @permission('backend.manage.members')
                                    <li><a href="{{ route('backend.member.index') }}">{{ trans('backend.members') }}</a></li>
                                @endpermission
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ trans('backend.system') }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @permission('backend.manage.settings')
                                    <li><a href="{{ route('backend.settings.index') }}">{{ trans('backend.settings') }}</a></li>
                                @endpermission
                                @permission('backend.see.logs')
                                    <li><a href="{{ route('backend.logs.index') }}">{{ trans('backend.logs') }}</a></li>
                                @endpermission
                                <li><a href="{{ route('backend.about') }}">{{ trans('backend.about') }}</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Auth::user()->member->profilePictureRoute() }}" style="height:18px;">
                                {{ Auth::user()->member->getShortName() }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('home') }}">{{ trans('backend.go_to_internal') }}</a></li>
                                <li><a href="{{ url('logout') }}">{{ trans('backend.logout') }}</a></li>
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
