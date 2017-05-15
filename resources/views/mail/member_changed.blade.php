@extends('layouts.mail.app')

@section('title')
    Ein Mitglied wurde verändert
@endsection

@section('header')
    <h1>Mitglied {{ $member->getFullName() }} wurde verändert!</h1>
@endsection

@section('content')
    <p>{{ $revisions[0]['user_id'] > 0 ? \Korona\User::findOrFail($revisions[0]['user_id'])->login : 'SYSTEM' }} hat folgende Änderungen an {{ $member->getFullName() }} durchgeführt:</p>

    <table border="1" style="width:100%;">
        <thead>
            <tr>
                <th>Feld</th>
                <th>Alter Wert</th>
                <th>Neuer Wert</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revisions as $revision)
                @if ($revision['key'] == 'created_at')
                    <tr>
                        <td colspan="3">Hat das Mitglied erstellt.</td>
                    </tr>
                @elseif ($revision['key'] == 'deleted_at')
                    <tr>
                        <td colspan="3">Hat das Mitglied gelöscht.</td>
                    </tr>
                @else
                    <tr>
                        <td>{{ strtoupper($revision['key']) }}</td>
                        <td>{{ $revision['old_value'] }}</td>
                        <td>{{ $revision['new_value'] instanceof \Carbon\Carbon ? $revision['new_value']->format('Y-m-d') : $revision['new_value'] }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <p>
        Du kannst dir die Änderungen im Backend
        <a href="{{ route('backend.member.edit', $member) }}">ansehen</a>.
    </p>
@endsection
