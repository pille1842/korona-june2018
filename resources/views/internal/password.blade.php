@extends('layouts.internal')

@section('title')
    {{ trans('auth.change_password') }}
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('auth.change_password') }}</div>
        <div class="panel-body">
            {{ Form::open(['action' => 'Internal\PasswordController@changePassword']) }}

            {{ Form::bsPassword('password') }}
            {{ Form::bsPassword('password_confirmation') }}

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
