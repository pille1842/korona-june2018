@extends('layouts.mail.plain.app')

@section('content')
{{ $revisions[0]['user_id'] > 0 ? \Korona\User::findOrFail($revisions[0]['user_id'])->login : 'SYSTEM' }} hat folgende Änderungen an {{ $member->getFullName() }} durchgeführt:

@foreach($revisions as $revision)
@if ($revision['key'] == 'created_at')
Hat das Mitglied erstellt.
@elseif ($revision['key'] == 'deleted_at')
Hat das Mitglied gelöscht.
@else
{{ strtoupper($revision['key']) }}: "{{ $revision['old_value'] }}" => "{{ $revision['new_value'] }}"
@endif
@endforeach

Du kannst dir die Änderungen im Backend ansehen:
{{ route('backend.member.edit', $member) }}
@endsection
