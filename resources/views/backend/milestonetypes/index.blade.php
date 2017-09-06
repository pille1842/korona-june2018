@extends('layouts.backend')

@section('title')
    {{ trans('backend.milestonetypes') }}
@endsection

@section('content')
    <h1>
        {{ trans('backend.milestonetypes') }}
        <a href="{{ action('Backend\MilestonetypeController@create') }}" class="btn btn-success"
            data-toggle="tooltip" title="{{ trans('backend.create_milestonetype') }}"
            id="btn-create-user">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </h1>

    <table class="table" id="k-milestonetypes-table">
        <thead>
            <tr>
                <th>{{ trans('validation.attributes.id') }}</th>
                <th>{{ trans('validation.attributes.name') }}</th>
                <th>{{ trans('validation.attributes.template') }}</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($milestonetypes as $milestonetype)
                <tr>
                    <td>{{ $milestonetype->id }}</td>
                    <td>
                        <i class="fa fa-{{ $milestonetype->symbol }}"></i>
                        {{ $milestonetype->name }}
                    </td>
                    <td>{{ $milestonetype->format(Auth::user()->member, 'XYZ') }}</td>
                    <td>
                        {!! Form::open(['action' => ['Backend\MilestonetypeController@destroy', $milestonetype], 'method' => 'delete']) !!}
                            <a href="{{ action('Backend\MilestonetypeController@edit', $milestonetype) }}" class="btn btn-primary">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <button type="button" class="btn btn-danger"
                                    onclick="confirm('{{ trans('backend.really_delete_milestonetype', ['milestonetype' => $milestonetype->name]) }}') &amp;&amp; form.submit();">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@include('components.tool.datatable', ['target' => '#k-milestonetypes-table', 'params' => 'columns: [
    null,
    null,
    null,
    {orderable: false}
]'])
