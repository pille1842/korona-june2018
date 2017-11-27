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
                        <h3 class="panel-title">{{ trans('backend.personal_details') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsText('firstname') }}
                        {{ Form::bsText('lastname') }}
                        {{ Form::bsCheckbox('inverse_name_order', '1', $member->inverse_name_order) }}
                        {{ Form::bsText('birthname') }}
                        @if (settings('fraternity.sex_type') == 'BOTH')
                            {{ Form::bsSelect('sex', ['MALE' => 'männlich', 'FEMALE' => 'weiblich'], $member->sex) }}
                        @else
                            <input type="hidden" name="sex" value="{{ settings('fraternity.sex_type') }}">
                        @endif
                        {{ Form::bsText('title_prefix') }}
                        {{ Form::bsText('title_suffix') }}
                        {{ Form::bsText('profession') }}
                        {{ Form::bsText('birthday') }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.fraternity_details') }}</h3>
                    </div>
                    <div class="panel-body">
                        @if (settings('fraternity.has_nicknames'))
                            {{ Form::bsText('nickname') }}
                        @else
                            <input type="hidden" name="nickname" value="">
                        @endif
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
                        @permission('backend.manage.users')
                            @if ($member->user !== null)
                                <a href="{{ route('backend.user.edit', $member->user) }}">
                                    <span class="glyphicon glyphicon-link"></span>
                                    {{ trans('backend.related_user') }}:
                                    {{ $member->user->login }}
                                </a>
                            @endif
                        @endpermission
                        {{ Form::bsText('created_at', $member->created_at->formatLocalized('%c'), ['readonly' => true]) }}
                        {{ Form::bsText('updated_at', $member->updated_at->formatLocalized('%c'), ['readonly' => true]) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ trans('backend.subscriptions') }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::bsSelect('subscriptions', $mailinglists, $subscriptions, ['multiple' => true, 'data-live-search' => 'true']) }}
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
            <li role="presentation">
                <a href="#emails" aria-controls="emails" role="tab" data-toggle="tab">
                    {{ trans('backend.emails') }}
                </a>
            </li>
            <li role="presentation">
                <a href="#phonenumbers" aria-controls="phonenumbers" role="tab" data-toggle="tab">
                    {{ trans('backend.phonenumbers') }}
                </a>
            </li>
            <li role="presentation">
                <a href="#offices" aria-controls="offices" role="tab" data-toggle="tab">
                    {{ trans('backend.offices') }}
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
                                    <td>
                                        @if ($history->userResponsible() === false)
                                            <em>SYSTEM</em>
                                        @elseif ($history->userResponsible() === null)
                                            <em>(gelöscht)</em>
                                        @else
                                            {{ $history->userResponsible()->login }}
                                        @endif
                                    </td>
                                    <td><span class="glyphicon glyphicon-plus"></span> {{ trans('backend.model_created') }}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @elseif ($history->key == 'deleted_at')
                                <tr>
                                    <td>{{ $history->id }}</td>
                                    <td>{{ $history->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        @if ($history->userResponsible() === false)
                                            <em>SYSTEM</em>
                                        @elseif ($history->userResponsible() === null)
                                            <em>(gelöscht)</em>
                                        @else
                                            {{ $history->userResponsible()->login }}
                                        @endif
                                    </td>
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
                                    <td>
                                        @if ($history->userResponsible() === false)
                                            <em>SYSTEM</em>
                                        @elseif ($history->userResponsible() === null)
                                            <em>(gelöscht)</em>
                                        @else
                                            {{ $history->userResponsible()->login }}
                                        @endif
                                    </td>
                                    <td>{{ $history->fieldName() }}</td>
                                    <td{!! $history->oldValue() != '' ? ' class="danger"' : '' !!}>{{ $history->oldValue() }}</td>
                                    <td{!! $history->newValue() != '' ? ' class="success"' : '' !!}>{{ $history->newValue() }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="addresses">
                @if (count($member->addresses) > 0 && $member->address_id == null)
                    <div class="alert alert-warning">
                        <p>
                            {{ trans('backend.member_has_no_main_address') }}
                        </p>
                    </div>
                @endif
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
                                        {{ Form::open(['action' => ['Backend\AddressController@destroy', $address], 'method' => 'delete']) }}
                                            <a class="btn btn-primary btn-sm" href="{{ action('Backend\AddressController@edit', $address) }}">
                                                <span class="glyphicon glyphicon-pencil"></span>
                                            </a>
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('{{ trans('backend.really_delete_address', ['address' => $address->name]) }}');">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                        {{ Form::close() }}
                                    </span>
                                </div>
                                <div class="panel-body">
                                    {{ $member->getCivilName(true) }}<br>
                                    {!! nl2br($address->getFormatted()) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="btn btn-success" href="{{ action('Backend\AddressController@create', ['addressable_type' => 'Korona\Member', 'addressable_id' => $member->id, 'redirect' => route('backend.member.edit', $member)]) }}">
                    <span class="glyphicon glyphicon-plus"></span>
                    {{ trans('backend.create_address') }}
                </a>
            </div>
            <div role="tabpanel" class="tab-pane" id="emails">
                @if (count($member->emails) > 0 && $member->email_id == null)
                    <div class="alert alert-warning">
                        <p>
                            {{ trans('backend.member_has_no_main_email') }}
                        </p>
                    </div>
                @endif
                <table class="table" id="k-emails-table">
                    <thead>
                        <tr>
                            <th>{{ trans('validation.attributes.email') }}</th>
                            <th>{{ trans('backend.is_main_email') }}</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member->emails as $email)
                            <tr>
                                <td>{{ $email->email }}</td>
                                <td>
                                    @if($member->email_id == $email->id)
                                        <span class="glyphicon glyphicon-ok text-success"></span>
                                    @else
                                        <span class="glyphicon glyphicon-remove text-danger"></span>
                                    @endif
                                </td>
                                <td>
                                    {{ Form::open(['action' => ['Backend\EmailController@destroy', $email], 'method' => 'delete']) }}
                                    <a href="{{ action('Backend\EmailController@edit', $email) }}" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                    <button class="btn btn-danger" onclick="return confirm('{{ trans('backend.really_delete_email', ['email' => $email->email]) }}')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </button>
                                    {{ Form::close() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a class="btn btn-success" href="{{ action('Backend\EmailController@create', ['emailable_type' => 'Korona\Member', 'emailable_id' => $member->id, 'redirect' => route('backend.member.edit', $member)]) }}">
                    <span class="glyphicon glyphicon-plus"></span>
                    {{ trans('backend.create_email') }}
                </a>
            </div>
            <div role="tabpanel" class="table-responsive tab-pane" id="phonenumbers">
                <table class="table" id="k-phonenumbers-table">
                    <thead>
                        <tr>
                            <th>{{ trans('validation.attributes.type') }}</th>
                            <th>{{ trans('validation.attributes.country_id') }}</th>
                            <th>{{ trans('validation.attributes.phonenumber') }}</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member->phonenumbers as $phonenumber)
                            <tr>
                                <td>
                                    @if ($phonenumber->type == "HOME")
                                        <i class="fa fa-home" aria-hidden="true"></i>
                                    @elseif ($phonenumber->type == "WORK")
                                        <i class="fa fa-briefcase" aria-hidden="true"></i>
                                    @elseif ($phonenumber->type == "FAX")
                                        <i class="fa fa-fax" aria-hidden="true"></i>
                                        <i class="fa fa-home" aria-hidden="true"></i>
                                    @elseif ($phonenumber->type == "FAX_WORK")
                                        <i class="fa fa-fax" aria-hidden="true"></i>
                                        <i class="fa fa-briefcase" aria-hidden="true"></i>
                                    @elseif ($phonenumber->type == "HOME_MOBILE")
                                        <i class="fa fa-mobile" aria-hidden="true"></i>
                                        <i class="fa fa-home" aria-hidden="true"></i>
                                    @elseif ($phonenumber->type == "WORK_MOBILE")
                                        <i class="fa fa-mobile" aria-hidden="true"></i>
                                        <i class="fa fa-briefcase" aria-hidden="true"></i>
                                    @elseif ($phonenumber->type == "OTHER")
                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                    @elseif ($phonenumber->type == "OTHER_MOBILE")
                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                        <i class="fa fa-mobile" aria-hidden="true"></i>
                                    @endif
                                    {{ trans('backend.phonenumbertypes.' . $phonenumber->type) }}
                                </td>
                                <td>
                                    <img src="{{ asset('images/flags/' . strtolower($phonenumber->country->short) . '.png') }}" alt="{{ $phonenumber->country->short }}">
                                    {{ $phonenumber->country->name }} (+{{ $phonenumber->country->phoneprefix }})
                                </td>
                                <td>{{ $phonenumber->getFormatted() }}</td>
                                <td>
                                    {{ Form::open(['action' => ['Backend\PhonenumberController@destroy', $phonenumber], 'method' => 'delete']) }}
                                    <button class="btn btn-danger" onclick="return confirm('{{ trans('backend.really_delete_phonenumber', ['phonenumber' => $phonenumber->phonenumber]) }}')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </button>
                                    {{ Form::close() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ Form::open(['action' => ['Backend\PhonenumberController@store']]) }}
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>

                                    {{ Form::bsSelect('type', \Korona\Phonenumber::getTypeArray(), 'HOME', ['data-container' => 'tab-pane']) }}
                                </td>
                                <td>
                                    {{ Form::bsSelect('country_id', $countries, settings('fraternity.home_country'), ['data-live-search' => 'true', 'data-size' => 5, 'data-container' => 'tab-pane']) }}
                                </td>
                                <td>
                                    {{ Form::bsText('phonenumber') }}
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label>&nbsp;</label><br>
                                        <button class="btn btn-success">{{ trans('backend.add') }}</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="phoneable_type" value="Korona\Member">
                    <input type="hidden" name="phoneable_id" value="{{ $member->id }}">
                {{ Form::close() }}
            </div>
            <div role="tabpanel" class="table-responsive tab-pane" id="offices">
                <table class="table" id="k-offices-table">
                    <thead>
                        <tr>
                            <th>{{ trans('validation.attributes.position') }}</th>
                            <th>{{ trans('validation.attributes.begin') }}</th>
                            <th>{{ trans('validation.attributes.end') }}</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member->offices()->orderBy('begin', 'desc')->get() as $office)
                            <tr>
                                <td>{{ $office->position }}</td>
                                <td>{{ $office->begin->formatLocalized('%x') }}</td>
                                <td>{{ $office->end ? $office->end->formatLocalized('%x') : '' }}</td>
                                <td>
                                    {{ Form::open(['action' => ['Backend\OfficeController@destroy', $member, $office], 'method' => 'delete']) }}
                                        <button class="btn btn-danger" onclick="return confirm('{{ trans('backend.really_delete_office', ['office' => $office->position]) }}')">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                    {{ Form::close() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ Form::open(['action' => ['Backend\OfficeController@store', $member]]) }}
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>

                                    {{ Form::bsSelect('position', \Korona\Office::getPositionArray(), null, ['data-container' => 'tab-pane']) }}
                                </td>
                                <td>
                                    {{ Form::bsText('begin') }}
                                </td>
                                <td>
                                    {{ Form::bsText('end') }}
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label>&nbsp;</label><br>
                                        <button class="btn btn-success">{{ trans('backend.add') }}</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
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
