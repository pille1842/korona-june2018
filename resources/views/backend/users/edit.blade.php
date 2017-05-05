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
                        {{ Form::bsSlug('slug', $user->slug, 'login') }}
                        {{ Form::bsEmail('email') }}
                        {{ Form::bsCheckbox('active', '1', $user->active) }}
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
                        {{ Form::bsCheckbox('send_password_email') }}
                        {{ Form::bsCheckbox('force_password_change', '1', $user->force_password_change) }}
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>

@endsection

@section('scripts')
    <script>
        $("#btnGeneratePassword").click(function () {
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
    </script>
@endsection
