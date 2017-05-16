@extends('layouts.backend')

@section('content')
    <h1>{{ trans('backend.settings') }}</h1>

    {{ Form::open(['route' => 'backend.settings.save']) }}
        <div class="well">
            <button type="submit" class="btn btn-primary">
                {{ trans('backend.save') }}
            </button>
        </div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#fraternity" aria-controls="fraternity" role="tab" data-toggle="tab">
                    {{ trans('backend.settings_fraternity') }}
                </a>
            </li>
            <li role="presentation">
                <a href="#mail" aria-controls="mail" role="tab" data-toggle="tab">
                    {{ trans('backend.settings_mail') }}
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="fraternity">
                <p>
                    {{ Form::bsText('fraternity_name', settings('fraternity.name'), [], trans('backend.setting.fraternity.name')) }}
                    {{ Form::bsText('fraternity_vulgo', settings('fraternity.vulgo'), [], trans('backend.setting.fraternity.vulgo')) }}
                    {{ Form::bsText('fraternity_sine_nomine', settings('fraternity.sine_nomine'), [], trans('backend.setting.fraternity.sine_nomine')) }}
                    {{ Form::bsText('fraternity_member_status_enum', implode(',', settings('fraternity.member_status_enum')), [], trans('backend.setting.fraternity.member_status_enum')) }}
                </p>
            </div>
            <div role="tabpanel" class="tab-pane" id="mail">
                <p>
                    {{ Form::bsText('mail_member_changed_receivers', implode(',', settings('mail.member_changed_receivers')), [], trans('backend.setting.mail.member_changed_receivers')) }}
                </p>
            </div>
        </div>
    {{ Form::close() }}
@endsection

@push('scripts')
    <script>
        $('#fraternity_member_status_enum').tokenfield();

        $('#mail_member_changed_receivers').tokenfield()
        .on('tokenfield:createdtoken', function (e) {
            // Simple email validation
            var re = /\S+@\S+\.\S+/
            var valid = re.test(e.attrs.value)
            if (!valid) {
              $(e.relatedTarget).addClass('invalid')
            }
        });

        $(function() {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                localStorage.setItem('lastBackendSettingsTab', $(this).attr('href'));
            });

            // go to the latest tab, if it exists:
            var lastTab = localStorage.getItem('lastBackendSettingsTab');
            if (lastTab) {
                $('[href="' + lastTab + '"]').tab('show');
            }
        });
    </script>
@endpush

@include('components.tool.tokenfield')
