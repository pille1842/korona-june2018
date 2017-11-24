@extends('layouts.backend')

@section('title')
    {{ trans('backend.edit_address', ['address' => $address->name, 'addressable' => $address->addressable->identifiableName()]) }}
@endsection

@section('content')
    <h1>{{ trans('backend.edit_address', ['address' => $address->name, 'addressable' => $address->addressable->identifiableName()]) }}</h1>

    <div class="row">
        {{ Form::model($address, ['action' => ['Backend\AddressController@update', $address], 'method' => 'put', 'class' => 'form', 'id' => 'k-edit-form']) }}
            <div class="col-xs-12">
                <div class="well">
                    <button type="submit" class="btn btn-primary">
                        {{ trans('backend.save') }}
                    </button>
                    <a href="{{ $address->addressable->getBackendEditUrl() }}" class="btn btn-default">
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
                {{ Form::bsSelect('country_id', $countries, $address->country_id, ['data-live-search' => 'true', 'data-size' => 5]) }}
                {{ Form::bsCheckbox('is_main', '1', $address->id == $address->addressable->address_id) }}
            </div>
        {{ Form::close() }}
    </div>
@endsection

@include('components.tool.select')
