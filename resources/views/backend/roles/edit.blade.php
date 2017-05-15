@extends('layouts.backend')

@section('content')
    <h1>{{ trans('backend.edit_role', ['role' => $role->name]) }}</h1>

    <div class="row">
        {{ Form::model($role, ['route' => ['backend.role.update', $role], 'method' => 'put', 'class' => 'form']) }}
            <div class="col-xs-12">
                <div class="well">
                    <button type="submit" class="btn btn-primary">
                        {{ trans('backend.save') }}
                    </button>
                    <a href="{{ route('backend.role.index') }}" class="btn btn-default">
                        {{ trans('backend.close') }}
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.role') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsText('name') }}
                        {{ Form::bsText('slug') }}
                        {{ Form::bsText('level') }}
                        {{ Form::bsTextarea('description', $role->description, ['rows' => 3]) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.role_permissions') }}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="permissions">{{ trans('validation.attributes.permissions') }}</label>
                            <select id="permissions" name="permissions[]" class="form-control selectpicker" aria-describedby="permissionsHelpBlock" data-live-search="true" data-actions-box="true" multiple>
                                @foreach($permissions as $label => $group)
                                    <optgroup label="{{ $label }}">
                                        @foreach ($group as $key => $item)
                                            <option value="{{ $key }}"{{ in_array($key, $currentPermissions) ? ' selected' : '' }}>
                                                {{ $item }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#effectivePermissionsModal">
                            <span class="glyphicon glyphicon-info-sign"></span> {{ trans('backend.effective_permissions') }}
                        </button>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('backend.role_users') }}</h3>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table" id="k-role-users-table">
                        <thead>
                            <tr>
                                <th>{{ trans('validation.attributes.id') }}</th>
                                <th>{{ trans('validation.attributes.login') }}</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($role->users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->login }}</td>
                                    <td>
                                        <a href="{{ route('backend.user.edit', $user) }}" class="btn btn-default">
                                            <span class="glyphicon glyphicon-link"></span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="effectivePermissionsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('backend.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <span class="glyphicon glyphicon-info-sign"></span>
                        {{ trans('backend.effective_permissions') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <ul>
                        @forelse($effectivePermissions as $group => $groups)
                            <li>
                                <strong>{{ $group }}</strong>
                                <ul>
                                    @foreach($groups as $permission)
                                        <li>{{ $permission }}</li>
                                    @endforeach
                                </ul>
                            </li>
                        @empty
                            <li><em>{{ trans('backend.role_has_no_permissions') }}</em></li>
                        @endforelse
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('backend.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('stylesheets')
    <link href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $("#k-role-users-table").DataTable({
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
                {orderable: false}
            ]
        });
    </script>
    <script src="{{ asset('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap-select/dist/js/i18n/defaults-de_DE.min.js') }}"></script>
@endsection
