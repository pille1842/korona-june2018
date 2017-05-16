@extends('layouts.backend')

@section('content')
    <h1>{{ trans('backend.create_role') }}</h1>

    <div class="row">
        {{ Form::open(['route' => ['backend.role.store'], 'class' => 'form']) }}
            <div class="col-xs-12">
                <div class="well">
                    <button type="submit" class="btn btn-primary">
                        {{ trans('backend.save') }}
                    </button>
                    <a href="{{ route('backend.role.index') }}" class="btn btn-default">
                        {{ trans('backend.close') }}
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.role') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsText('name') }}
                        {{ Form::bsText('slug') }}
                        {{ Form::bsText('level') }}
                        {{ Form::bsTextarea('description', null, ['rows' => 3]) }}
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>
@endsection
