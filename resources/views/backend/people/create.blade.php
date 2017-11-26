@extends('layouts.backend')

@section('title')
    {{ trans('backend.create_person') }}
@endsection

@section('content')

    <h1>{{ trans('backend.create_person') }}</h1>

    <div class="row">
        {{ Form::open(['route' => ['backend.person.store'], 'class' => 'form']) }}
            <div class="col-xs-12">
                <div class="well">
                    <button type="submit" class="btn btn-primary">
                        {{ trans('backend.save') }}
                    </button>
                    <a href="{{ route('backend.person.index') }}" class="btn btn-default">
                        {{ trans('backend.close') }}
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.person') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsText('firstname') }}
                        {{ Form::bsText('lastname') }}
                        {{ Form::bsText('nickname') }}
                        {{ Form::bsSelect('sex', ['MALE' => 'männlich', 'FEMALE' => 'weiblich'], 'MALE') }}
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>

@endsection

@include('components.tool.select')
