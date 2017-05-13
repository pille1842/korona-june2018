@extends('layouts.backend')

@section('content')
    <h1>{{ trans('backend.edit_account', ['account' => $user->login]) }}</h1>

    <div class="row">
        {{ Form::model($user, ['route' => ['backend.user.update', $user], 'method' => 'put', 'class' => 'form']) }}
            <div class="col-xs-12">
                <div class="well">
                    <button type="submit" class="btn btn-primary">
                        {{ trans('backend.save') }}
                    </button>
                    <a href="{{ route('backend.user.index') }}" class="btn btn-default">
                        {{ trans('backend.close') }}
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.account') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsText('login') }}
                        {{ Form::bsEmail('email') }}
                        {{ Form::bsCheckbox('active', '1', $user->active) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {{ trans('backend.password') }}
                            <span class="pull-right">
                                <button type="button" class="btn btn-primary btn-xs" id="btnEnablePasswordChange">
                                    {{ trans('backend.enable_password_change') }}
                                </button>
                            </span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsPassword('password', ['readonly' => true]) }}
                        {{ Form::bsPassword('password_confirmation', ['readonly' => true]) }}
                        <button type="button" class="btn btn-default" id="btnGeneratePassword" disabled="disabled">
                            {{ trans('backend.generate_random_password') }}
                        </button>
                        {{ Form::bsCheckbox('send_password_email') }}
                        {{ Form::bsCheckbox('force_password_change', '1', $user->force_password_change) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.info') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsText('created_at', $user->created_at->formatLocalized('%c'), ['readonly' => true]) }}
                        {{ Form::bsText('updated_at', $user->updated_at->formatLocalized('%c'), ['readonly' => true]) }}
                        @if ($user->member !== null)
                            <a href="{{ route('backend.member.edit', $user->member) }}">
                                <span class="glyphicon glyphicon-link"></span>
                                Verknüpftes Mitglied:
                                {{ $user->member->getFullName() }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.roles_and_permissions') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsSelect('roles', $roles, $currentRoles, ['multiple' => true, 'data-live-search' => 'true']) }}
                        <div class="form-group">
                            <label for="permissions">{{ trans('validation.attributes.permissions') }}</label>
                            <select id="permissions" name="permissions[]" class="form-control selectpicker" aria-describedby="permissionsHelpBlock" data-live-search="true" multiple>
                                @foreach($permissions as $label => $group)
                                    <optgroup label="{{ $label }}">
                                        @foreach ($group as $key => $item)
                                            <option value="{{ $key }}"{{ in_array($key, $currentPermissions) ? ' selected' : '' }}>
                                                {{ $item }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#effectivePermissionsModal">
                            <span class="glyphicon glyphicon-info-sign"></span> {{ trans('backend.effective_permissions') }}
                        </button>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>

    <div class="modal fade" id="effectivePermissionsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('backend.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <span class="glyphicon glyphicon-info-sign"></span>
                        {{ trans('backend.effective_permissions') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <ul>
                        @forelse($effectivePermissions as $group => $groups)
                            <li>
                                <strong>{{ $group }}</strong>
                                <ul>
                                    @foreach($groups as $permission)
                                        <li>{{ $permission }}</li>
                                    @endforeach
                                </ul>
                            </li>
                        @empty
                            <li><em>{{ trans('backend.has_no_permissions') }}</em></li>
                        @endforelse
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('backend.close') }}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('stylesheets')
    <link href="{{ asset('bower_components/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script>
        $("#btnGeneratePassword").click(function () {
            if ($("[name='password']").attr('readonly')) {
                return;
            }
            var chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ023456789";
            var password = "";
            var length = 8;
            for (i = 0; i < length; i++) {
                x = Math.floor(Math.random() * chars.length);
                password += chars[x];
            }
            $("[name='password']").val(password);
            $("[name='password_confirmation']").val(password);
        });

        $("#btnEnablePasswordChange").click(function () {
            $("[name='password']").removeAttr('readonly');
            $("[name='password_confirmation']").removeAttr('readonly');
            $("#btnGeneratePassword").removeAttr('disabled');
            $(this).attr("disabled", true);
        })
    </script>

    <script src="{{ asset('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap-select/dist/js/i18n/defaults-de_DE.min.js') }}"></script>
@endsection
