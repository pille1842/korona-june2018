@extends('layouts.backend')

@section('title')
    {{ trans('backend.create_mailinglist') }}
@endsection

@section('content')
    <h1>{{ trans('backend.create_mailinglist') }}</h1>

    <div class="row">
        {{ Form::open(['route' => ['backend.mailinglist.store'], 'class' => 'form']) }}
            <div class="col-xs-12">
                <div class="well">
                    <button type="submit" class="btn btn-primary">
                        {{ trans('backend.save') }}
                    </button>
                    <a href="{{ route('backend.mailinglist.index') }}" class="btn btn-default">
                        {{ trans('backend.close') }}
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.mailinglist') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsText('name') }}
                        {{ Form::bsCheckbox('subscribable', '1', null) }}
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>
@endsection
