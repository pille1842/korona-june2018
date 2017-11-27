@extends('layouts.backend')

@section('title')
    {{ trans('backend.edit_email', ['email' => $email->email, 'emailable' => $email->emailable->identifiableName()]) }}
@endsection

@section('content')
    <h1>{{ trans('backend.edit_email', ['email' => $email->email, 'emailable' => $email->emailable->identifiableName()]) }}</h1>

    <div class="row">
        {{ Form::model($email, ['action' => ['Backend\EmailController@update', $email], 'method' => 'put', 'class' => 'form', 'id' => 'k-edit-form']) }}
            <div class="col-xs-12">
                <div class="well">
                    <button type="submit" class="btn btn-primary">
                        {{ trans('backend.save') }}
                    </button>
                    <a href="{{ $email->emailable->getBackendEditUrl() }}" class="btn btn-default">
                        {{ trans('backend.close') }}
                    </a>
                </div>
            </div>
            <div class="col-xs-12">
                {{ Form::bsText('email') }}
                {{ Form::bsCheckbox('is_main', '1', $email->id == $email->emailable->email_id) }}
            </div>
        {{ Form::close() }}
    </div>
@endsection
