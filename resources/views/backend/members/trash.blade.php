@extends('layouts.backend')

@section('content')
    <h1>
        {{ trans('backend.members_trash') }}
        @if($members->count() > 0)
            {{ Form::open(['action' => 'Backend\MemberController@emptyTrash', 'method' => 'delete', 'style' => 'display:inline;']) }}
                <button type="button" class="btn btn-danger"
                        onclick="confirm('{{ trans('backend.really_empty_trash') }}') &amp;&amp; form.submit();"
                        data-toggle="tooltip" title="{{ trans('backend.empty_trash') }}">
                    <span class="glyphicon glyphicon-trash"></span>
                </button>
            {{ Form::close() }}
        @endif
        <span class="pull-right">
            <a href="{{ route('backend.member.index') }}" class="btn btn-default">
                <span class="glyphicon glyphicon-list"></span>
                {{ trans('backend.normal_view') }}
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
                    <th>{{ trans('validation.attributes.deleted_at') }}</th>
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
                        <td>{{ $member->deleted_at->diffForHumans() }}</td>
                        <td style="text-align:right;">
                            {{ Form::open(['action' => ['Backend\MemberController@restore', $member->id], 'style' => 'display:inline;']) }}
                                <button type="submit" class="btn btn-primary"
                                    data-toggle="tooltip" title="{{ trans('backend.restore') }}"
                                    data-placement="left">
                                    <span class="glyphicon glyphicon-list"></span>
                                </button>
                            {{ Form::close() }}
                            {{ Form::open(['action' => ['Backend\MemberController@purge', $member->id], 'method' => 'delete', 'style' => 'display:inline;']) }}
                                <button type="button" class="btn btn-danger"
                                        onclick="confirm('{{ trans('backend.really_purge_member', ['member' => $member->getFullName()]) }}') &amp;&amp; form.submit();">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            {{ Form::close() }}
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
                null,
                {orderable: false}
            ]
        });
    </script>
@endsection
