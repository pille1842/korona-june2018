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

  <body class="k-body-authentication">

    <div class="container">
        <header class="header">
            <a href="{{ url('/') }}"><img src="{{ asset('images/korona.png') }}" alt="Korona"></a>
        </header>

      @yield('content')

      <footer class="footer">
        <p>&copy; {{ date('Y') }} {{ config('fraternity.name') }}</p>
      </footer>

    </div> <!-- /container -->

  </body>
</html>
