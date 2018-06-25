@extends('layouts.backend')

@section('title')
    {{ trans('backend.preview_mailing', ['mailing' => $mailing->subject]) }}
@endsection

@section('content')
    <h1>{{ trans('backend.preview_mailing', ['mailing' => $mailing->subject]) }}</h1>

    <div class="well">
        <a class="btn btn-default" href="{{ $mailing->sent_at == null ? route('backend.mailing.edit', ['mailing' => $mailing]) : route('backend.mailing.index') }}">
            {{ trans('backend.close') }}
        </a>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ trans('backend.mailing_header') }}</h3>
        </div>
        <table class="table">
            <tbody>
                <tr>
                    <td style="font-weight:bold;">{{ trans('backend.mailing_from') }}</td>
                    <td>{{ $mailing->sender != null ? $mailing->sender->getFullName() . ' <' . $mailing->sender->email->email . '>' : '' }}</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">{{ trans('backend.mailing_to') }}</td>
                    <td>
                        {{ Form::bsSelect('receiver', $receivers, null, ['data-live-search' => 'true', 'data-size' => 5]) }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">{{ trans('backend.mailing_subject') }}</td>
                    <td>{{ $mailing->subject }}</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">{{ trans('backend.mailing_date') }}</td>
                    <td>{{ $mailing->sent_at != null ? $mailing->sent_at->format('d.m.Y H:i') : '' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ trans('backend.mailing_body') }}</h3>
        </div>
        <div class="panel-body" id="mailing-preview"></div>
    </div>
@endsection

@push('scripts')
    <script>
        function updatePreview() {
            var receiver = $("#receiver").val();
            $.get("{{ route('backend.mailing.preview', ['mailing' => $mailing]) }}", {
                receiver: receiver
            },
            function (data) {
                $("#mailing-preview").html(data);
            });
        }
        updatePreview();
        $("#receiver").on("changed.bs.select", updatePreview);
    </script>
@endpush

@include('components.tool.select')
