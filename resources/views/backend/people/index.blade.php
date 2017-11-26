@extends('layouts.backend')

@section('title')
    {{ trans('backend.people') }}
@endsection

@section('content')
    <h1>
        {{ trans('backend.people') }}
        <a href="{{ action('Backend\PersonController@create') }}" class="btn btn-success"
            data-toggle="tooltip" title="{{ trans('backend.create_person') }}"
            id="btn-create-person">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
        <span class="pull-right">
            <a href="{{ route('backend.person.trash') }}" class="btn btn-default">
                <span class="glyphicon glyphicon-trash"></span>
                {{ trans('backend.trash') }}
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
                        <td style="text-align:right;">
                            {!! Form::open(['action' => ['Backend\PersonController@destroy', $person], 'method' => 'delete']) !!}
                                <a href="{{ action('Backend\PersonController@edit', $person) }}" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <button type="button" class="btn btn-danger"
                                        onclick="confirm('{{ trans('backend.really_delete_person', ['person' => $person->getFullName()]) }}') &amp;&amp; form.submit();">
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

@include('components.tool.datatable', ['target' => '#k-people-table', 'params' => 'columns: [
    null,
    null,
    null,
    null,
    {orderable: false}
]'])
