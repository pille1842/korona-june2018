@extends('layouts.backend')

@section('content')
    <h1>
        {{ trans('backend.members') }}
        <a href="{{ action('Backend\MemberController@create') }}" class="btn btn-success"
            data-toggle="tooltip" title="{{ trans('backend.create_member') }}"
            id="btn-create-member">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
        <span class="pull-right">
            <a href="{{ route('backend.member.trash') }}" class="btn btn-default">
                <span class="glyphicon glyphicon-trash"></span>
                {{ trans('backend.trash') }}
            </a>
        </span>
    </h1>

    <div class="table-responsive">
        <table class="table" id="k-members-table">
            <thead>
                <tr>
                    <th>{{ trans('validation.attributes.id') }}</th>
                    <th>{{ trans('validation.attributes.firstname') }}</th>
                    <th>{{ trans('validation.attributes.lastname') }}</th>
                    <th>{{ trans('validation.attributes.nickname') }}</th>
                    <th>{{ trans('validation.attributes.active') }}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td>{{ $member->firstname }}</td>
                        <td>{{ $member->lastname }}</td>
                        <td>{{ $member->nickname }}</td>
                        <td>
                            @if($member->active)
                                <span class="glyphicon glyphicon-ok text-success"></span>
                            @else
                                <span class="glyphicon glyphicon-remove text-danger"></span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            {!! Form::open(['action' => ['Backend\MemberController@destroy', $member], 'method' => 'delete']) !!}
                                <a href="{{ action('Backend\MemberController@edit', $member) }}" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <button type="button" class="btn btn-danger"
                                        onclick="confirm('{{ trans('backend.really_delete_member', ['member' => $member->getFullName()]) }}') &amp;&amp; form.submit();">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('stylesheets')
    <link href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $("#k-members-table").DataTable({
            language: {
                processing:     "Verarbeite...",
                search:         "Suchen:",
                lengthMenu:    "Zeige _MENU_ Elemente",
                info:           "Zeige Elemente _START_ bis _END_ von _TOTAL_",
                infoEmpty:      "Keine Elemente vorhanden",
                infoFiltered:   "(gefiltert von _MAX_ Elementen insgesamt)",
                infoPostFix:    "",
                loadingRecords: "Lade Datensätze...",
                zeroRecords:    "Keine Datensätze vorhanden",
                emptyTable:     "Tabelle ist leer",
                paginate: {
                    first:      "Anfang",
                    previous:   "Zurück",
                    next:       "Weiter",
                    last:       "Ende"
                },
                aria: {
                    sortAscending:  ": anklicken, um nach dieser Spalte aufsteigend zu sortieren",
                    sortDescending: ": anklicken, um nach dieser Spalte absteigend zu sortieren"
                }
            },
            columns: [
                null,
                null,
                null,
                null,
                {orderable: false},
                {orderable: false}
            ]
        });
    </script>
@endsection
