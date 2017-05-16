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

@include('components.tool.datatable', ['target' => '#k-roles-table', 'params' => 'columns: [
    null,
    null,
    null,
    {orderable: false}
],
order: [2, "asc"],'])
