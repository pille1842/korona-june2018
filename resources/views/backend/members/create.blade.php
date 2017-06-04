@extends('layouts.backend')

@section('title')
    {{ trans('backend.create_member') }}
@endsection

@section('content')

    <h1>{{ trans('backend.create_member') }}</h1>

    <div class="row">
        {{ Form::open(['route' => ['backend.member.store'], 'class' => 'form']) }}
            <div class="col-xs-12">
                <div class="well">
                    <button type="submit" class="btn btn-primary">
                        {{ trans('backend.save') }}
                    </button>
                    <a href="{{ route('backend.member.index') }}" class="btn btn-default">
                        {{ trans('backend.close') }}
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.member') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsText('firstname') }}
                        {{ Form::bsText('lastname') }}
                        {{ Form::bsText('nickname') }}
                        {{ Form::bsSlug('slug', null, 'nickname') }}
                        {{ Form::bsCheckbox('active', '1', true) }}
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>

@endsection
