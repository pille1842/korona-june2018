@extends('layouts.mail.app')

@section('title')
    Dein neues Passwort
@endsection

@section('header')
    <h1>Dein Passwort wurde geändert!</h1>
@endsection

@section('content')
    <p>Dein Passwort für die <a href="{{ url('/') }}">Homepage</a> wurde geändert.
    Melde dich mit folgenden Zugangsdaten an:</p>

    <ul>
        <li><b>Benutzername:</b> {{ $user->login }}<br /></li>
        <li><b>Passwort:</b> <span style="font-family:monospace;">{{ $password }}</span></li>
    </ul>
@endsection
