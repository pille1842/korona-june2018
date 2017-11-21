@extends('layouts.backend')

@section('title')
    {{ trans('backend.members_trash') }}
@endsection

@section('content')
    <h1>
        {{ trans('backend.members_trash') }}
        @if($members->count() > 0)
            {{ Form::open(['action' => 'Backend\MemberController@emptyTrash', 'method' => 'delete', 'style' => 'display:inline;']) }}
                <button type="button" class="btn btn-danger"
                        onclick="confirm('{{ trans('backend.really_empty_trash') }}') &amp;&amp; form.submit();"
                        data-toggle="tooltip" title="{{ trans('backend.empty_trash') }}">
                    <span class="glyphicon glyphicon-trash"></span>
                </button>
            {{ Form::close() }}
        @endif
        <span class="pull-right">
            <a href="{{ route('backend.member.index') }}" class="btn btn-default">
                <span class="glyphicon glyphicon-list"></span>
                {{ trans('backend.normal_view') }}
            </a>
        </span>
    </h1>

    <div class="table-responsive">
        <table class="table" id="k-members-table">
            <thead>
                <tr>
                    <th>{{ trans('validation.attributes.id') }}</th>
                    <th>{{ trans('validation.attributes.firstname') }}</th>
                    <th>{{ trans('validation.attributes.lastname') }}</th>
                    @if (settings('fraternity.has_nicknames'))
                        <th>{{ trans('validation.attributes.nickname') }}</th>
                    @endif
                    <th>{{ trans('validation.attributes.deleted_at') }}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td>{{ $member->firstname }}</td>
                        <td>{{ $member->lastname }}</td>
                        @if (settings('fraternity.has_nicknames'))
                            <td>{{ $member->nickname }}</td>
                        @endif
                        <td>{{ $member->deleted_at->diffForHumans() }}</td>
                        <td style="text-align:right;">
                            {{ Form::open(['action' => ['Backend\MemberController@restore', $member->id], 'style' => 'display:inline;']) }}
                                <button type="submit" class="btn btn-primary"
                                    data-toggle="tooltip" title="{{ trans('backend.restore') }}"
                                    data-placement="left">
                                    <span class="glyphicon glyphicon-list"></span>
                                </button>
                            {{ Form::close() }}
                            {{ Form::open(['action' => ['Backend\MemberController@purge', $member->id], 'method' => 'delete', 'style' => 'display:inline;']) }}
                                <button type="button" class="btn btn-danger"
                                        onclick="confirm('{{ trans('backend.really_purge_member', ['member' => $member->getFullName()]) }}') &amp;&amp; form.submit();">
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

@if (settings('fraternity.has_nicknames'))
    @include('components.tool.datatable', ['target' => '#k-members-table', 'params' => 'columns: [
        null,
        null,
        null,
        null,
        null,
        {orderable: false}
    ]'])
@else
    @include('components.tool.datatable', ['target' => '#k-members-table', 'params' => 'columns: [
        null,
        null,
        null,
        null,
        {orderable: false}
    ]'])
@endif
