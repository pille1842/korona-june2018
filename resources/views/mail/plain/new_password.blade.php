@extends('layouts.mail.plain.app')

@section('content')
Dein Passwort für die Homepage wurde geändert.
Melde dich mit folgenden Zugangsdaten an:

Benutzername: {{ $user->login }}
Passwort:     {{ $password }}
@endsection
