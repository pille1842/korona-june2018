@extends('layouts.backend')

@section('title')
    {{ trans('backend.mailinglists') }}
@endsection

@section('content')
    <h1>
        {{ trans('backend.mailinglists') }}
        <a href="{{ action('Backend\MailinglistController@create') }}" class="btn btn-success"
            data-toggle="tooltip" title="{{ trans('backend.create_mailinglist') }}"
            id="btn-create-role">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </h1>

    <div class="table-responsive">
        <table class="table" id="k-mailinglist-table">
            <thead>
                <tr>
                    <th>{{ trans('validation.attributes.id') }}</th>
                    <th>{{ trans('validation.attributes.name') }}</th>
                    <th>{{ trans('backend.subscribers') }}</th>
                    <th>{{ trans('validation.attributes.subscribable') }}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mailinglists as $mailinglist)
                    <tr>
                        <td>{{ $mailinglist->id }}</td>
                        <td>{{ $mailinglist->name }}</td>
                        <td>{{ $mailinglist->members->count() + $mailinglist->people->count() }}</td>
                        <td>
                            @if($mailinglist->subscribable)
                                <span class="glyphicon glyphicon-ok text-success"></span>
                            @else
                                <span class="glyphicon glyphicon-remove text-danger"></span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            {!! Form::open(['action' => ['Backend\MailinglistController@destroy', $mailinglist], 'method' => 'delete']) !!}
                                <a href="{{ action('Backend\MailinglistController@edit', $mailinglist) }}" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <button type="button" class="btn btn-danger"
                                        onclick="confirm('{{ trans('backend.really_delete_mailinglist', ['mailinglist' => $mailinglist->name]) }}') &amp;&amp; form.submit();">
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

@include('components.tool.datatable', ['target' => '#k-mailinglist-table', 'params' => 'columns: [
    null,
    null,
    null,
    {orderable: false},
    {orderable: false}
],
order: [2, "asc"],'])
