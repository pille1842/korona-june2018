@extends('layouts.backend')

@section('content')
    <h1>{{ trans('backend.edit_member', ['member' => $member->getFullName()]) }}</h1>

    <div class="row">
        {{ Form::model($member, ['route' => ['backend.member.update', $member], 'method' => 'put', 'class' => 'form']) }}
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
                        <h3 class="panel-title">{{ trans('backend.profile_picture') }}</h3>
                    </div>
                    <div class="panel-body">
                        TODO
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.personal_details') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsText('firstname') }}
                        {{ Form::bsText('lastname') }}
                        {{ Form::bsText('nickname') }}
                        {{ Form::bsText('birthname') }}
                        {{ Form::bsText('title') }}
                        {{ Form::bsText('profession') }}
                        {{ Form::bsDate('birthday') }}
                        {{ Form::bsSelect('parent_id', $members, $member->parent_id, ['data-live-search' => 'true']) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.system_details') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsSlug('slug', $member->slug, 'nickname') }}
                        {{ Form::bsCheckbox('active', '1', $member->active) }}
                        {{ Form::bsSelect('user_id', $users, $member->user_id, ['data-live-search' => 'true']) }}
                        {{ Form::bsText('created_at', $member->created_at->formatLocalized('%c'), ['readonly' => true]) }}
                        {{ Form::bsText('updated_at', $member->updated_at->formatLocalized('%c'), ['readonly' => true]) }}
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>

@endsection

@section('stylesheets')
    <link href="{{ asset('bower_components/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap-select/dist/js/i18n/defaults-de_DE.min.js') }}"></script>
@endsection
