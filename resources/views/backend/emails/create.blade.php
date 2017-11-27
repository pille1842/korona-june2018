@extends('layouts.backend')

@section('title')
    {{ trans('backend.create_email') }}
@endsection

@section('content')
    <h1>{{ trans('backend.create_email') }}</h1>

    <div class="row">
        {{ Form::open(['action' => 'Backend\EmailController@store', 'method' => 'post', 'class' => 'form', 'id' => 'k-create-form']) }}
            <div class="col-xs-12">
                <div class="well">
                    <button type="submit" class="btn btn-primary">
                        {{ trans('backend.save') }}
                    </button>
                    <a href="{{ $redirect }}" class="btn btn-default">
                        {{ trans('backend.close') }}
                    </a>
                </div>
            </div>
            <div class="col-xs-12">
                {{ Form::bsText('email') }}
                {{ Form::bsCheckbox('is_main', '1', false) }}
                <input type="hidden" name="emailable_type" value="{{ $emailable_type }}">
                <input type="hidden" name="emailable_id" value="{{ $emailable_id }}">
            </div>
        {{ Form::close() }}
    </div>
@endsection
