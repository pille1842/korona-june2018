@extends('layouts.authentication')

@section('title')
    {{ trans('auth.reset_password') }}
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('auth.reset_password') }}</div>
        <div class="panel-body">
            {{ Form::open(['url' => '/password/reset']) }}

            {{ Form::bsEmail('email') }}
            {{ Form::bsPassword('password') }}
            {{ Form::bsPassword('password_confirmation') }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-refresh"></i> {{ trans('auth.change_password') }}
                    </button>
                </div>
            </div>

            {{ Form::close() }}
        </div>
    </div>
@endsection
