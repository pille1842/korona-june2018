@extends('layouts.backend')

@section('title')
    {{ trans('backend.create_address', ['member' => $member->getShortName()]) }}
@endsection

@section('content')
    <h1>{{ trans('backend.create_address', ['member' => $member->getShortName()]) }}</h1>

    <div class="row">
        {{ Form::open(['action' => ['Backend\AddressController@store', $member], 'method' => 'post', 'class' => 'form', 'id' => 'k-create-form']) }}
            <div class="col-xs-12">
                <div class="well">
                    <button type="submit" class="btn btn-primary">
                        {{ trans('backend.save') }}
                    </button>
                    <a href="{{ route('backend.member.edit', $member) }}" class="btn btn-default">
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
                {{ Form::bsSelect('country_id', $countries, 43, ['data-live-search' => 'true', 'data-size' => 5]) }}
                {{ Form::bsCheckbox('is_main', '1', false) }}
            </div>
        {{ Form::close() }}
    </div>
@endsection

@include('components.tool.select')
