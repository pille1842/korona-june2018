@extends('layouts.backend')

@section('content')
    <h1>
        {{ trans('backend.accounts_trash') }}
        @if($users->count() > 0)
            {{ Form::open(['action' => 'Backend\UserController@emptyTrash', 'method' => 'delete', 'style' => 'display:inline;']) }}
                <button type="button" class="btn btn-danger"
                        onclick="confirm('{{ trans('backend.really_empty_trash') }}') &amp;&amp; form.submit();"
                        data-toggle="tooltip" title="{{ trans('backend.empty_trash') }}">
                    <span class="glyphicon glyphicon-trash"></span>
                </button>
            {{ Form::close() }}
        @endif
        <span class="pull-right">
            <a href="{{ route('backend.user.index') }}" class="btn btn-default">
                <span class="glyphicon glyphicon-list"></span>
                {{ trans('backend.normal_view') }}
            </a>
        </span>
    </h1>

    <div class="table-responsive">
        <table class="table" id="k-users-table">
            <thead>
                <tr>
                    <th>{{ trans('validation.attributes.id') }}</th>
                    <th>{{ trans('validation.attributes.login') }}</th>
                    <th>{{ trans('validation.attributes.deleted_at') }}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->login }}</td>
                        <td>{{ $user->deleted_at->diffForHumans() }}</td>
                        <td style="text-align:right;">
                            {{ Form::open(['action' => ['Backend\UserController@restore', $user->id], 'style' => 'display:inline;']) }}
                                <button type="submit" class="btn btn-primary"
                                    data-toggle="tooltip" title="{{ trans('backend.restore') }}"
                                    data-placement="left">
                                    <span class="glyphicon glyphicon-list"></span>
                                </button>
                            {{ Form::close() }}
                            {{ Form::open(['action' => ['Backend\UserController@purge', $user->id], 'method' => 'delete', 'style' => 'display:inline;']) }}
                                <button type="button" class="btn btn-danger"
                                        onclick="confirm('{{ trans('backend.really_purge_user', ['account' => $user->login]) }}') &amp;&amp; form.submit();">
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

@include('components.tool.datatable', ['target' => '#k-users-table', 'params' => 'columns: [
    null,
    null,
    null,
    {orderable: false}
]'])
