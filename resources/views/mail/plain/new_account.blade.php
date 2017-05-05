@extends('layouts.mail.plain.app')

@section('content')
Für dich wurde ein Benutzerkonto auf der Homepage angelegt.

Gehe jetzt auf <{{ url('login') }}>
und melde dich mit den folgenden Zugangsdaten an:

Benutzername: {{ $user->login }}
Passwort:     {{ $password }}
@endsection
