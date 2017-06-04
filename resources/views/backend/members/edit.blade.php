@extends('layouts.backend')

@section('title')
    {{ trans('backend.edit_member', ['member' => $member->getFullName()]) }}
@endsection

@section('content')
    <h1>{{ trans('backend.edit_member', ['member' => $member->getFullName()]) }}</h1>

    <div class="row">
        {{ Form::model($member, ['route' => ['backend.member.update', $member], 'method' => 'put', 'class' => 'form', 'id' => 'k-edit-form']) }}
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
                        @if ($errors->has('picture'))
                            <div class="alert alert-danger">
                                {{ $errors->first('picture') }}
                            </div>
                        @endif
                        @if ($errors->has('profile_picture'))
                            <div class="alert alert-danger">
                                {{ $errors->first('profile_picture') }}
                            </div>
                        @endif
                        <div class="text-center">
                            @if ($member->picture !== null)
                                <img src="{{ route('image', $member->picture) }}" class="img-responsive img-rounded" id="picture-img">
                            @else
                                <img src="" class="img-responsive" style="display:none;" id="picture-img">
                            @endif
                        </div>
                        <div id="image-cropper" style="display:none;">
                            <div class="cropit-preview"></div>
                            <input type="range" class="cropit-image-zoom-input" />
                            <input type="file" class="cropit-image-input" />
                            <input type="hidden" name="picture" id="picture" value="" />
                            <input type="hidden" name="profile_picture" id="profile_picture" value="" />
                        </div>
                        <div class="form-group">
                            <br/>
                            <button type="button" class="btn btn-default btn-block" id="btn-upload-picture">
                                <span class="glyphicon glyphicon-upload"></span> {{ trans('backend.upload_picture') }}
                            </button>
                            <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#choosePictureModal" id="btn-choose-picture">
                                <span class="glyphicon glyphicon-th"></span> {{ trans('backend.choose_picture') }}
                            </button>
                        </div>
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
                        {{ Form::bsText('birthname') }}
                        {{ Form::bsText('title') }}
                        {{ Form::bsText('profession') }}
                        {{ Form::bsDate('birthday') }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.fraternity_details') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsText('nickname') }}
                        {{ Form::bsSelect('parent_id', $members, $member->parent_id, ['data-live-search' => 'true', 'data-size' => 5]) }}
                        {{ Form::bsSelect('status', array_combine(settings('fraternity.member_status_enum'), settings('fraternity.member_status_enum')), $member->status) }}
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
                        {{ Form::bsToggle('active', '1', $member->active, ['data-on' => trans('backend.active'), 'data-off' => trans('backend.inactive'), 'data-onstyle' => 'success']) }}
                        {{ Form::bsSelect('user_id', $users, $member->user_id, ['data-live-search' => 'true']) }}
                        {{ Form::bsText('created_at', $member->created_at->formatLocalized('%c'), ['readonly' => true]) }}
                        {{ Form::bsText('updated_at', $member->updated_at->formatLocalized('%c'), ['readonly' => true]) }}
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>

    <div class="row">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#history" aria-controls="history" role="tab" data-toggle="tab">
                    {{ trans('backend.history') }}
                </a>
            </li>
            <li role="presentation">
                <a href="#addresses" aria-controls="addresses" role="tab" data-toggle="tab">
                    {{ trans('backend.addresses') }}
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="table-responsive tab-pane active" id="history">
                <table class="table" id="k-history-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('backend.date') }}</th>
                            <th>{{ trans('backend.user') }}</th>
                            <th>{{ trans('backend.field_name') }}</th>
                            <th>{{ trans('backend.old_value') }}</th>
                            <th>{{ trans('backend.new_value') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($member->revisionHistory as $history)
                            @if ($history->key == 'created_at')
                                <tr>
                                    <td>{{ $history->id }}</td>
                                    <td>{{ $history->created_at->format('d.m.Y H:i') }}</td>
                                    <td>{{ $history->userResponsible() !== false ? $history->userResponsible()->login : 'SYSTEM' }}</td>
                                    <td><span class="glyphicon glyphicon-plus"></span> {{ trans('backend.model_created') }}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @elseif ($history->key == 'deleted_at')
                                <tr>
                                    <td>{{ $history->id }}</td>
                                    <td>{{ $history->created_at->format('d.m.Y H:i') }}</td>
                                    <td>{{ $history->userResponsible() !== false ? $history->userResponsible()->login : 'SYSTEM' }}</td>
                                    <td>
                                        @if ($history->newValue() === null)
                                            <span class="glyphicon glyphicon-asterisk"></span>
                                            {{ trans('backend.model_restored') }}
                                        @else
                                            <span class="glyphicon glyphicon-trash"></span>
                                            {{ trans('backend.model_deleted') }}
                                        @endif
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $history->id }}</td>
                                    <td>{{ $history->created_at->format('d.m.Y H:i') }}</td>
                                    <td>{{ $history->userResponsible() !== false ? $history->userResponsible()->login : '' }}</td>
                                    <td>{{ $history->fieldName() }}</td>
                                    <td><span class="text-danger">{{ $history->oldValue() }}</span></td>
                                    <td><span class="text-success">{{ $history->newValue() }}</span></td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="addresses">
                <div class="row">
                    @foreach ($member->addresses as $address)
                        <div class="col-md-3">
                            <div class="panel {{ $member->address_id == $address->id ? 'panel-success' : 'panel-default' }}">
                                <div class="panel-heading clearfix">
                                    <h3 class="panel-title pull-left" style="padding-top:7.5px;">
                                        {{ $address->name }}
                                        @if ($member->address_id == $address->id)
                                            <a href="#" data-toggle="tooltip" title="{{ trans('backend.is_main_address') }}">
                                                <span class="glyphicon glyphicon-ok"></span>
                                            </a>
                                        @endif
                                    </h3>
                                    <span class="btn-group pull-right">
                                        {{ Form::open(['action' => ['Backend\AddressController@destroy', $member, $address], 'method' => 'delete']) }}
                                            <a class="btn btn-primary btn-sm" href="{{ action('Backend\AddressController@edit', [$member, $address]) }}">
                                                <span class="glyphicon glyphicon-pencil"></span>
                                            </a>
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('{{ trans('backend.really_delete_address', ['address' => $address->name]) }}');">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                        {{ Form::close() }}
                                    </span>
                                </div>
                                <div class="panel-body">
                                    {!! nl2br($address->getFormatted()) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="btn btn-success" href="{{ action('Backend\AddressController@create', $member) }}">
                    <span class="glyphicon glyphicon-plus"></span>
                    {{ trans('backend.create_address', ['member' => $member->getShortName()]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="modal fade" id="choosePictureModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('backend.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        {{ trans('backend.choose_picture') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach ($member->images as $image)
                            <div class="col-xs-4">
                                <a href="#" class="btn-choose-this-picture" data-id="{{ $image->id }}" data-url="{{ route('image', $image) }}">
                                    <img class="img-responsive img-rounded" src="{{ route('image', $image) }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="" id="chosen-picture">
                    <input type="hidden" value="" id="chosen-picture-url">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('backend.close') }}</button>
                    <button type="button" class="btn btn-primary" id="btn-set-chosen-picture">{{ trans('backend.adopt') }}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('stylesheets')
    <style>
        .cropit-preview {
            width: 350px;
            height: 350px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $("#btn-upload-picture").click(function () {
            $("#image-cropper").toggle(true);
            $(this).toggle(false);
            $("#btn-choose-picture").toggle(false);
            $("#picture-img").toggle(false);
            $('#image-cropper').cropit();
            $("#k-edit-form").submit(function () {
                $("#picture").val($("#image-cropper").cropit('export', {
                    type: 'image/jpeg',
                    quality: .9,
                }));
            });
        });
        $(".btn-choose-this-picture").click(function () {
            $(".chosen-picture").removeClass('chosen-picture');
            $(this).find('img').addClass('chosen-picture');
            $("#chosen-picture").val($(this).data('id'));
            $("#chosen-picture-url").val($(this).data('url'));
        });
        $("#btn-set-chosen-picture").click(function () {
            $("#profile_picture").val($("#chosen-picture").val());
            $('#choosePictureModal').modal('hide');
            $("#btn-choose-picture").toggle(false);
            $("#btn-upload-picture").toggle(false);
            $("#picture-img").attr('src', $("#chosen-picture-url").val());
        });

        $(function() {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                localStorage.setItem('lastBackendMembersTab', $(this).attr('href'));
            });

            // go to the latest tab, if it exists:
            var lastTab = localStorage.getItem('lastBackendMembersTab');
            if (lastTab) {
                $('[href="' + lastTab + '"]').tab('show');
            }
        });
    </script>
@endpush

@include('components.tool.datatable', ['target' => '#k-history-table', 'params' => "order: [[1, 'desc'], [0, 'desc']]"])
@include('components.tool.select')
@include('components.tool.toggle')
@include('components.tool.cropit')
