@extends('layouts.authentication')

@section('title')
    {{ trans('auth.reset_password') }}
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('auth.reset_password') }}</div>
        <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            {{ Form::open(['url' => '/password/email']) }}

            {{ Form::bsEmail('email') }}

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-envelope"></i> {{ trans('auth.reset_password') }}
                    </button>
                </div>
            </div>

            {{ Form::close() }}
        </div>
    </div>
@endsection
