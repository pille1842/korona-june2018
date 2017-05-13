@extends('layouts.backend')

@section('content')
    <h1>{{ trans('backend.settings') }}</h1>

    {{ Form::open(['route' => 'backend.settings.save']) }}
        <div class="well">
            <button type="submit" class="btn btn-primary">
                {{ trans('backend.save') }}
            </button>
        </div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#fraternity" aria-controls="fraternity" role="tab" data-toggle="tab">
                    {{ trans('backend.settings_fraternity') }}
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="fraternity">
                <p>
                    {{ Form::bsText('fraternity_name', settings('fraternity.name'), [], trans('backend.setting.fraternity.name')) }}
                    {{ Form::bsText('fraternity_member_status_enum', implode(',', settings('fraternity.member_status_enum')), [], trans('backend.setting.fraternity.member_status_enum')) }}
                </p>
            </div>
        </div>
    {{ Form::close() }}
@endsection

@section('stylesheets')
    <link href="{{ asset('bower_components/bootstrap-tokenfield/dist/css/bootstrap-tokenfield.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('bower_components/bootstrap-tokenfield/dist/bootstrap-tokenfield.min.js') }}"></script>
    <script>
        $('#fraternity_member_status_enum').tokenfield();
    </script>
@endsection
