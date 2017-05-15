@extends('layouts.backend')

@section('content')
    <h1>{{ trans('backend.edit_member', ['member' => $member->getFullName()]) }}</h1>

    <div class="row">
        {{ Form::model($member, ['route' => ['backend.member.update', $member], 'method' => 'put', 'class' => 'form']) }}
            <div class="col-xs-12">
                <div class="well">
                    <button type="submit" class="btn btn-primary">
                        {{ trans('backend.save') }}
                    </button>
                    <a href="{{ route('backend.member.index') }}" class="btn btn-default">
                        {{ trans('backend.close') }}
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.profile_picture') }}</h3>
                    </div>
                    <div class="panel-body">
                        TODO
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.personal_details') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsText('firstname') }}
                        {{ Form::bsText('lastname') }}
                        {{ Form::bsText('nickname') }}
                        {{ Form::bsText('birthname') }}
                        {{ Form::bsText('title') }}
                        {{ Form::bsText('profession') }}
                        {{ Form::bsDate('birthday') }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.fraternity_details') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsText('nickname') }}
                        {{ Form::bsSelect('parent_id', $members, $member->parent_id, ['data-live-search' => 'true', 'data-size' => 5]) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.system_details') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsSlug('slug', $member->slug, 'nickname') }}
                        {{ Form::bsCheckbox('active', '1', $member->active) }}
                        {{ Form::bsSelect('user_id', $users, $member->user_id, ['data-live-search' => 'true']) }}
                        {{ Form::bsText('created_at', $member->created_at->formatLocalized('%c'), ['readonly' => true]) }}
                        {{ Form::bsText('updated_at', $member->updated_at->formatLocalized('%c'), ['readonly' => true]) }}
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>

    <div class="row">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#history" aria-controls="history" role="tab" data-toggle="tab">
                    {{ trans('backend.history') }}
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="table-responsive tab-pane active" id="history">
                <table class="table" id="k-history-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('backend.date') }}</th>
                            <th>{{ trans('backend.user') }}</th>
                            <th>{{ trans('backend.field_name') }}</th>
                            <th>{{ trans('backend.old_value') }}</th>
                            <th>{{ trans('backend.new_value') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($member->revisionHistory as $history)
                            @if ($history->key == 'created_at')
                                <tr>
                                    <td>{{ $history->id }}</td>
                                    <td>{{ $history->created_at->format('d.m.Y H:i') }}</td>
                                    <td>{{ $history->userResponsible() !== false ? $history->userResponsible()->login : 'SYSTEM' }}</td>
                                    <td><span class="glyphicon glyphicon-plus"></span> {{ trans('backend.model_created') }}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @elseif ($history->key == 'deleted_at')
                                <tr>
                                    <td>{{ $history->id }}</td>
                                    <td>{{ $history->created_at->format('d.m.Y H:i') }}</td>
                                    <td>{{ $history->userResponsible() !== false ? $history->userResponsible()->login : 'SYSTEM' }}</td>
                                    <td>
                                        @if ($history->newValue() === null)
                                            <span class="glyphicon glyphicon-asterisk"></span>
                                            {{ trans('backend.model_restored') }}
                                        @else
                                            <span class="glyphicon glyphicon-trash"></span>
                                            {{ trans('backend.model_deleted') }}
                                        @endif
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $history->id }}</td>
                                    <td>{{ $history->created_at->format('d.m.Y H:i') }}</td>
                                    <td>{{ $history->userResponsible() !== false ? $history->userResponsible()->login : '' }}</td>
                                    <td>{{ $history->fieldName() }}</td>
                                    <td><span class="text-danger">{{ $history->oldValue() }}</span></td>
                                    <td><span class="text-success">{{ $history->newValue() }}</span></td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('stylesheets')
    <link href="{{ asset('bower_components/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap-select/dist/js/i18n/defaults-de_DE.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $("#k-history-table").DataTable({
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
            order: [[1, 'desc'], [0, 'desc']]
        });
    </script>
@endsection
