@extends('layouts.backend')

@section('title')
    {{ trans('backend.people_trash') }}
@endsection

@section('content')
    <h1>
        {{ trans('backend.people_trash') }}
        @if($people->count() > 0)
            {{ Form::open(['action' => 'Backend\PersonController@emptyTrash', 'method' => 'delete', 'style' => 'display:inline;']) }}
                <button type="button" class="btn btn-danger"
                        onclick="confirm('{{ trans('backend.really_empty_trash') }}') &amp;&amp; form.submit();"
                        data-toggle="tooltip" title="{{ trans('backend.empty_trash') }}">
                    <span class="glyphicon glyphicon-trash"></span>
                </button>
            {{ Form::close() }}
        @endif
        <span class="pull-right">
            <a href="{{ route('backend.person.index') }}" class="btn btn-default">
                <span class="glyphicon glyphicon-list"></span>
                {{ trans('backend.normal_view') }}
            </a>
        </span>
    </h1>

    <div class="table-responsive">
        <table class="table" id="k-people-table">
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
                @foreach ($people as $person)
                    <tr>
                        <td>{{ $person->id }}</td>
                        <td>{{ $person->firstname }}</td>
                        <td>{{ $person->lastname }}</td>
                        <td>{{ $person->nickname }}</td>
                        <td>{{ $person->deleted_at->diffForHumans() }}</td>
                        <td style="text-align:right;">
                            {{ Form::open(['action' => ['Backend\PersonController@restore', $person->id], 'style' => 'display:inline;']) }}
                                <button type="submit" class="btn btn-primary"
                                    data-toggle="tooltip" title="{{ trans('backend.restore') }}"
                                    data-placement="left">
                                    <span class="glyphicon glyphicon-list"></span>
                                </button>
                            {{ Form::close() }}
                            {{ Form::open(['action' => ['Backend\PersonController@purge', $person->id], 'method' => 'delete', 'style' => 'display:inline;']) }}
                                <button type="button" class="btn btn-danger"
                                        onclick="confirm('{{ trans('backend.really_purge_person', ['person' => $person->getFullName()]) }}') &amp;&amp; form.submit();">
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

@include('components.tool.datatable', ['target' => '#k-people-table', 'params' => 'columns: [
    null,
    null,
    null,
    null,
    null,
    {orderable: false}
]'])
