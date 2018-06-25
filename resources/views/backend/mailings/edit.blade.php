@extends('layouts.backend')

@section('title')
    {{ trans('backend.edit_mailing') }}
@endsection

@section('content')
    @permission('backend.mailings.send')
        {{ Form::open(['action' => ['Backend\MailingController@send', $mailing]]) }}
            <h1>
                {{ trans('backend.edit_mailing') }}
                <button type="button" class="btn btn-primary"
                    onclick="confirm('{{ trans('backend.really_send_mailing', ['mailing' => $mailing->subject]) }}') &amp;&amp; form.submit();">
                    <span class="glyphicon glyphicon-envelope"></span>
                    {{ trans('backend.send_mailing') }}
                </button>
            </h1>
        {{ Form::close() }}
    @else
        <h1>{{ trans('backend.edit_mailing') }}</h1>
    @endpermission

    <div class="row">
        {{ Form::model($mailing, ['route' => ['backend.mailing.update', $mailing], 'method' => 'put', 'class' => 'form']) }}
            <div class="col-xs-12">
                <div class="well">
                    <button class="btn btn-primary">
                        {{ trans('backend.save') }}
                    </button>
                    <a class="btn btn-default" href="{{ route('backend.mailing.index') }}">
                        {{ trans('backend.close') }}
                    </a>
                    <a class="btn btn-default" href="{{ route('backend.mailing.show', ['mailing' => $mailing]) }}">
                        <span class="glyphicon glyphicon-eye-open"></span>
                        {{ trans('backend.preview') }}
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                @permission('backend.mailings.setsender')
                    {{ Form::bsSelect('sender', $members, $mailing->sender->id, ['data-live-search' => 'true', 'data-size' => 5]) }}
                @else
                    {{ Form::hidden('sender', Auth::user()->member->id) }}
                @endpermission
                {{ Form::bsSelect('mailinglist', $mailinglists, $mailing->mailinglist_id) }}
                {{ Form::bsSelect('layout', Korona\Mailing::layouts(), $mailing->layout) }}
                {{ Form::bsText('subject') }}
            </div>
            <div class="col-md-6" id="receiversinfo"></div>
            <div class="col-xs-12">
                {{ Form::bsMarkdown('text') }}
            </div>
        {{ Form::close() }}
    </div>
@endsection

@push('scripts')
    <script>
        function updateReceiversInfo() {
            var list = $("#mailinglist").val();
            $(".mailinglist").val(list);
            $.get("{{ route('backend.mailing.receiversinfo') }}", {
                mailinglist: list
            },
            function (data) {
                $("#receiversinfo").html(data);
            });
        }
        updateReceiversInfo();
        $("#mailinglist").on("changed.bs.select", updateReceiversInfo);
    </script>
@endpush

@include('components.tool.select')
@include('components.tool.markdown')
