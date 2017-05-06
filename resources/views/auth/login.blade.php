@extends('layouts.authentication')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('auth.login') }}</div>
        <div class="panel-body">
            {{ Form::open(['url' => 'login', 'class' => 'form']) }}
                {{ Form::bsText('login') }}
                {{ Form::bsPassword('password') }}
                {{ Form::bsCheckbox('remember', '1') }}
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-sign-in"></i> {{ trans('auth.login') }}
                </button>
                <a class="btn btn-link" href="{{ url('/password/reset') }}">{{ trans('auth.password_forgotten') }}</a>
            {{ Form::close() }}
        </div>
    </div>
@endsection
