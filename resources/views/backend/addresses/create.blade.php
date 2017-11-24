@extends('layouts.backend')

@section('title')
    {{ trans('backend.create_address') }}
@endsection

@section('content')
    <h1>{{ trans('backend.create_address') }}</h1>

    <div class="row">
        {{ Form::open(['action' => 'Backend\AddressController@store', 'method' => 'post', 'class' => 'form', 'id' => 'k-create-form']) }}
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
                {{ Form::bsText('name') }}
                {{ Form::bsText('additional') }}
                {{ Form::bsText('street') }}
                {{ Form::bsText('zipcode') }}
                {{ Form::bsText('city') }}
                {{ Form::bsText('province') }}
                {{ Form::bsSelect('country_id', $countries, 43, ['data-live-search' => 'true', 'data-size' => 5]) }}
                {{ Form::bsCheckbox('is_main', '1', false) }}
                <input type="hidden" name="redirect" value="{{ $redirect }}">
                <input type="hidden" name="addressable_type" value="{{ $addressable_type }}">
                <input type="hidden" name="addressable_id" value="{{ $addressable_id }}">
            </div>
        {{ Form::close() }}
    </div>
@endsection

@include('components.tool.select')
