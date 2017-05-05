@extends('layouts.backend')

@section('content')
    <h1>{{ trans('backend.edit_account', ['account' => $user->login]) }}</h1>

    <div class="row">
        {{ Form::model($user, ['route' => ['backend.user.update', $user], 'method' => 'put', 'class' => 'form']) }}
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
                        {{ Form::bsCheckbox('active', '1', $user->active) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {{ trans('backend.password') }}
                            <span class="pull-right">
                                <button type="button" class="btn btn-primary btn-xs" id="btnEnablePasswordChange">
                                    {{ trans('backend.enable_password_change') }}
                                </button>
                            </span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsPassword('password', ['readonly' => true]) }}
                        {{ Form::bsPassword('password_confirmation', ['readonly' => true]) }}
                        <button type="button" class="btn btn-default" id="btnGeneratePassword" disabled="disabled">
                            {{ trans('backend.generate_random_password') }}
                        </button>
                        {{ Form::bsCheckbox('send_password_email') }}
                        {{ Form::bsCheckbox('force_password_change', '1', $user->force_password_change) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.info') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsText('created_at', $user->created_at->formatLocalized('%c'), ['readonly' => true]) }}
                        {{ Form::bsText('updated_at', $user->updated_at->formatLocalized('%c'), ['readonly' => true]) }}
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>

@endsection

@section('scripts')
    <script>
        $("#btnGeneratePassword").click(function () {
            if ($("[name='password']").attr('readonly')) {
                return;
            }
            var chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ023456789";
            var password = "";
            var length = 8;
            for (i = 0; i < length; i++) {
                x = Math.floor(Math.random() * chars.length);
                password += chars[x];
            }
            $("[name='password']").val(password);
            $("[name='password_confirmation']").val(password);
        });

        $("#btnEnablePasswordChange").click(function () {
            $("[name='password']").removeAttr('readonly');
            $("[name='password_confirmation']").removeAttr('readonly');
            $("#btnGeneratePassword").removeAttr('disabled');
            $(this).attr("disabled", true);
        })
    </script>
@endsection
