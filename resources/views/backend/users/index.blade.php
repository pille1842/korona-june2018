@extends('layouts.backend')

@section('title')
    {{ trans('backend.accounts') }}
@endsection

@section('content')
    <h1>
        {{ trans('backend.accounts') }}
        <a href="{{ action('Backend\UserController@create') }}" class="btn btn-success"
            data-toggle="tooltip" title="{{ trans('backend.create_account') }}"
            id="btn-create-user">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
        <span class="pull-right">
            <a href="{{ route('backend.user.trash') }}" class="btn btn-default">
                <span class="glyphicon glyphicon-trash"></span>
                {{ trans('backend.trash') }}
            </a>
        </span>
    </h1>

    <div class="table-responsive">
        <table class="table" id="k-users-table">
            <thead>
                <tr>
                    <th>{{ trans('validation.attributes.id') }}</th>
                    <th>{{ trans('validation.attributes.login') }}</th>
                    <th>{{ trans('validation.attributes.active') }}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->login }}</td>
                        <td>
                            @if($user->active)
                                <span class="glyphicon glyphicon-ok text-success"></span>
                            @else
                                <span class="glyphicon glyphicon-remove text-danger"></span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            {!! Form::open(['action' => ['Backend\UserController@destroy', $user], 'method' => 'delete']) !!}
                                <a href="{{ action('Backend\UserController@edit', $user) }}" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <button type="button" class="btn btn-danger"
                                        onclick="confirm('{{ trans('backend.really_delete_user', ['account' => $user->login]) }}') &amp;&amp; form.submit();">
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

@include('components.tool.datatable', ['target' => '#k-users-table', 'params' => 'columns: [
    null,
    null,
    {orderable: false},
    {orderable: false}
]'])
