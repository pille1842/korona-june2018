@extends('layouts.backend')

@section('content')
    <h1>
        {{ trans('backend.roles') }}
        <a href="{{ action('Backend\RolesController@create') }}" class="btn btn-success"
            data-toggle="tooltip" title="{{ trans('backend.create_role') }}"
            id="btn-create-role">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </h1>

    <div class="table-responsive">
        <table class="table" id="k-roles-table">
            <thead>
                <tr>
                    <th>{{ trans('validation.attributes.id') }}</th>
                    <th>{{ trans('validation.attributes.name') }}</th>
                    <th>{{ trans('validation.attributes.level') }}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->level }}</td>
                        <td style="text-align:right;">
                            {!! Form::open(['action' => ['Backend\RolesController@destroy', $role], 'method' => 'delete']) !!}
                                <a href="{{ action('Backend\RolesController@edit', $role) }}" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <button type="button" class="btn btn-danger"
                                        onclick="confirm('{{ trans('backend.really_delete_role', ['role' => $role->name]) }}') &amp;&amp; form.submit();">
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
        $("#k-roles-table").DataTable({
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
                {orderable: false}
            ],
            order: [2, 'asc'],
        });
    </script>
@endsection
