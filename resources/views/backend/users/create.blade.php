@extends('layouts.backend')

@section('title')
    {{ trans('backend.create_account') }}
@endsection

@section('content')

    <h1>{{ trans('backend.create_account') }}</h1>

    <div class="row">
        {{ Form::open(['route' => ['backend.user.store'], 'class' => 'form']) }}
            <div class="col-xs-12">
                <div class="well">
                    <button type="submit" class="btn btn-primary">
                        {{ trans('backend.save') }}
                    </button>
                    <a href="{{ route('backend.user.index') }}" class="btn btn-default">
                        {{ trans('backend.close') }}
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.account') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsText('login') }}
                        {{ Form::bsEmail('email') }}
                        {{ Form::bsSelect('member_id', $members, null, ['data-live-search' => 'true', 'data-size' => 5]) }}
                        {{ Form::bsCheckbox('active', '1', true) }}
                        {{ Form::bsCheckbox('send_newaccount_email', '1', true) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.password') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsPassword('password') }}
                        {{ Form::bsPassword('password_confirmation') }}
                        <button type="button" class="btn btn-default" id="btnGeneratePassword">
                            {{ trans('backend.generate_random_password') }}
                        </button>
                        {{ Form::bsCheckbox('force_password_change', '1', true) }}
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>

@endsection

@push('scripts')
    <script>
        $("#btnGeneratePassword").click(function () {
            var chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789";
            var password = "";
            var length = 8;
            for (i = 0; i < length; i++) {
                x = Math.floor(Math.random() * chars.length);
                password += chars[x];
            }
            $("[name='password']").val(password);
            $("[name='password_confirmation']").val(password);
        });
    </script>
@endpush

@include('components.tool.select')
