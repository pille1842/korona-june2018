@extends('layouts.backend')

@section('title')
    {{ trans('backend.mailings') }}
@endsection

@section('content')

    {{ Form::open(['action' => 'Backend\MailingController@store']) }}
        <h1>
            {{ trans('backend.mailings') }}
            <button class="btn btn-success" data-toggle="tooltip" title="{{ trans('backend.create_mailing') }}">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
        </h1>
    {{ Form::close() }}

    <div class="table-responsive">
        <table class="table" id="k-mailing-table">
            <thead>
                <tr>
                    <th>{{ trans('validation.attributes.id') }}</th>
                    <th>{{ trans('validation.attributes.sender') }}</th>
                    <th>{{ trans('validation.attributes.mailinglist') }}</th>
                    <th>{{ trans('validation.attributes.layout') }}</th>
                    <th>{{ trans('validation.attributes.subject') }}</th>
                    <th>{{ trans('validation.attributes.sent_at') }}</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mailings as $mailing)
                    <tr>
                        <td>{{ $mailing->id }}</td>
                        <td>{{ $mailing->sender != null ? $mailing->sender->getShortName() . ' <' . $mailing->sender->email->email . '>' : '' }}</td>
                        <td>{{ $mailing->mailinglist != null ? $mailing->mailinglist->name : '' }}</td>
                        <td>{{ Korona\Mailing::layouts()[$mailing->layout] }}</td>
                        <td>{{ $mailing->subject }}</td>
                        <td>
                            @if($mailing->sent_at !== null)
                                <span class="glyphicon glyphicon-ok text-success"></span>
                                {{ $mailing->sent_at->format('d.m.Y H:i') }}
                            @else
                                <span class="glyphicon glyphicon-remove text-danger"></span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            @if ($mailing->sent_at === null)
                                {!! Form::open(['action' => ['Backend\MailingController@destroy', $mailing], 'method' => 'delete']) !!}
                                    <a href="{{ action('Backend\MailingController@edit', $mailing) }}" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                    <button type="button" class="btn btn-danger"
                                            onclick="confirm('{{ trans('backend.really_delete_mailing', ['mailing' => $mailing->subject]) }}') &amp;&amp; form.submit();">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                {!! Form::close() !!}
                            @endif
                        </td>
                        <td style="text-align:right;">
                            {{ Form::open(['route' => ['backend.mailing.copy', $mailing]]) }}
                                <button class="btn btn-default" data-toggle="tooltip" data-placement="left" title="{{ trans('backend.copy_mailing') }}">
                                    <span class="glyphicon glyphicon-copy"></span>
                                </button>
                                <a href="{{ action('Backend\MailingController@show', $mailing) }}" class="btn btn-default"  data-toggle="tooltip" data-placement="left" title="{{ trans('backend.preview') }}">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@include('components.tool.datatable', ['target' => '#k-mailing-table', 'params' => 'columns: [
    null,
    null,
    null,
    null,
    null,
    null,
    {orderable: false},
    {orderable: false}
], order: [5, \'desc\'],'])

@include('components.tool.select')
