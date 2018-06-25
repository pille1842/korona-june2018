@extends('layouts.backend')

@section('title')
    {{ trans('backend.edit_mailinglist', ['mailinglist' => $mailinglist->name]) }}
@endsection

@section('content')
    <h1>{{ trans('backend.edit_mailinglist', ['mailinglist' => $mailinglist->name]) }}</h1>

    <div class="row">
        {{ Form::model($mailinglist, ['route' => ['backend.mailinglist.update', $mailinglist], 'method' => 'put', 'class' => 'form']) }}
        <div class="col-xs-12">
            <div class="well">
                <button type="submit" class="btn btn-primary">
                    {{ trans('backend.save') }}
                </button>
                <a href="{{ route('backend.mailinglist.index') }}" class="btn btn-default">
                    {{ trans('backend.close') }}
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('backend.mailinglist') }}</h3>
                </div>
                <div class="panel-body">
                    {{ Form::bsText('name') }}
                    {{ Form::bsCheckbox('subscribable', '1', $mailinglist->subscribable) }}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('backend.info') }}</h3>
                </div>
                <div class="panel-body">
                    {{ Form::bsText('created_at', $mailinglist->created_at->formatLocalized('%c'), ['readonly' => true]) }}
                    {{ Form::bsText('updated_at', $mailinglist->updated_at->formatLocalized('%c'), ['readonly' => true]) }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('backend.subscribers') }}</h3>
                </div>
                <div class="panel-body table-responsive">
                    @if (!empty($nonmembers))
                        {{ Form::bsSelect('addmembers', $nonmembers, null, ['multiple' => true, 'data-live-search' => 'true']) }}
                    @endif
                    @if (!empty($nonpeople))
                        {{ Form::bsSelect('addpeople', $nonpeople, null, ['multiple' => true, 'data-live-search' => 'true']) }}
                    @endif
                    {{ Form::close() }}
                    <table class="table" id="k-mailinglist-subscribers-table">
                        <thead>
                            <tr>
                                <th>{{ trans('validation.attributes.id') }}</th>
                                <th>{{ trans('validation.attributes.name') }}</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mailinglist->members as $member)
                                <tr>
                                    <td>{{ $member->id }}</td>
                                    <td>
                                        <i class="fa fa-id-card" aria-hidden="true"></i>
                                        {{ $member->getFullName() }}
                                    </td>
                                    <td>
                                        {{ Form::open(['action' => ['Backend\MailinglistController@unsubscribe', $mailinglist]]) }}
                                            @permission('backend.manage.members')
                                                <a href="{{ route('backend.member.edit', $member) }}" class="btn btn-default">
                                                    <span class="glyphicon glyphicon-link"></span>
                                                </a>
                                            @endpermission
                                            <button class="btn btn-danger">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                            {{ Form::hidden('subscribableType', 'Korona\Member') }}
                                            {{ Form::hidden('subscribableId', $member->id) }}
                                        {{ Form::close() }}
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($mailinglist->people as $person)
                                <tr>
                                    <td>{{ $person->id }}</td>
                                    <td>
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        {{ $person->getFullName() }}
                                    </td>
                                    <td>
                                        {{ Form::open(['action' => ['Backend\MailinglistController@unsubscribe', $mailinglist]]) }}
                                            @permission('backend.manage.people')
                                                <a href="{{ route('backend.person.edit', $person) }}" class="btn btn-default">
                                                    <span class="glyphicon glyphicon-link"></span>
                                                </a>
                                            @endpermission
                                            <button class="btn btn-danger">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                            {{ Form::hidden('subscribableType', 'Korona\Person') }}
                                            {{ Form::hidden('subscribableId', $person->id) }}
                                        {{ Form::close() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('components.tool.datatable', ['target' => '#k-mailinglist-subscribers-table', 'params' => 'columns: [
    null,
    null,
    {orderable: false}
]'])
@include('components.tool.select')
