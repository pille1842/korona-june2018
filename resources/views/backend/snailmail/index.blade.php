@extends('layouts.backend')

@section('title')
    {{ trans('backend.snailmail') }}
@endsection

@section('content')
    <h1>{{ trans('backend.snailmail') }}</h1>

    <div class="row">
        <div class="col-xs-12">
            <div class="well">
                <div class="form-inline">
                    {{ Form::bsSelect('mailinglist', $mailinglists, null) }}
                </div>
                <div id="receiversinfo">&nbsp;</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ trans('backend.labels') }}
                    </h3>
                </div>
                <div class="panel-body">
                    {{ Form::open(['route' => 'backend.snailmail.labels', 'method' => 'get']) }}
                        <button class="btn btn-default btn-block">
                            <span class="glyphicon glyphicon-download"></span>
                            {{ trans('backend.getlabels') }}
                        </button>
                        <input type="hidden" name="mailinglist" class="mailinglist" value="">
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ trans('backend.internetmarke') }}
                    </h3>
                </div>
                <div class="panel-body">
                    {{ Form::open(['route' => 'backend.snailmail.internetmarke', 'method' => 'get']) }}
                        {{ Form::bsCheckbox('foreign', "1", null) }}
                        <button class="btn btn-default btn-block">
                            <span class="glyphicon glyphicon-download"></span>
                            {{ trans('backend.getinternetmarke') }}
                        </button>
                        <input type="hidden" name="mailinglist" class="mailinglist" value="">
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $("#mailinglist").val('');
        $("#mailinglist").on("changed.bs.select", function (e) {
            var list = $("#mailinglist").val();
            $(".mailinglist").val(list);
            if (list != "") {
                $.get("{{ route('backend.snailmail.receiversinfo') }}", {
                    mailinglist: list
                },
                function (data) {
                    $("#receiversinfo").html(data);
                });
            } else {
                $("#receiversinfo").html("&nbsp;");
            }
        });
    </script>
@endpush

@include('components.tool.select')
