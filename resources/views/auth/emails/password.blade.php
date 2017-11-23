@extends('layouts.mail.app')

@section('title')
    Dein Passwort wurde zurückgesetzt
@endsection

@section('header')
    <h1>Dein Passwort wurde zurückgesetzt!</h1>
@endsection

@section('content')
    <p>Klick hier, um ein neues Passwort zu vergeben:</p>

    <p><a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a></p>
@endsection
