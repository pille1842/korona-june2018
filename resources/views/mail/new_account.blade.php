@extends('layouts.mail.app')

@section('title')
    Dein Benutzerzugang steht bereit
@endsection

@section('header')
    <h1>Dein neues Benutzerkonto ist fertig!</h1>
@endsection

@section('content')
    <p>
        Für dich wurde ein Benutzerkonto auf der <a href="{{ url('login') }}">Homepage</a>
        angelegt. Melde dich mit folgenden Zugangsdaten an:
    </p>

    <ul>
        <li><b>Benutzername:</b> {{ $user->login }}<br /></li>
        <li><b>Passwort:</b> <span style="font-family:monospace;">{{ $password }}</span></li>
    </ul>
@endsection
