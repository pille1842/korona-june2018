@extends('layouts.backend')

@section('title')
    {{ trans('backend.settings') }}
@endsection

@section('content')
    <h1>{{ trans('backend.settings') }}</h1>

    {{ Form::open(['route' => 'backend.settings.save']) }}
        <div class="well">
            <button type="submit" class="btn btn-primary">
                {{ trans('backend.save') }}
            </button>
        </div>
        <ul class="nav nav-tabs" role="tablist">
            @foreach($settings['system'] as $group)
                <li role="presentation">
                    <a href="#group_{{ $group['name'] }}" aria-controls="group_{{ $group['name'] }}" role="tab" data-toggle="tab">
                        {{ trans($group['trans']) }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content">
            @foreach($settings['system'] as $group)
                <div role="tabpanel" class="tab-pane" id="group_{{ $group['name'] }}">
                    @foreach($group['settings'] as $setting)
                        @if ($setting['type'] == 'string')
                            {{ Form::bsText('settings_'.$group['name'].'_'.$setting['name'], settings($group['name'].'.'.$setting['name']), [], trans($setting['trans'])) }}
                        @elseif ($setting['type'] == 'csv')
                            {{ Form::bsText('settings_'.$group['name'].'_'.$setting['name'], implode(',', settings($group['name'].'.'.$setting['name'])), ['data-type' => 'tokenfield'], trans($setting['trans'])) }}
                        @elseif ($setting['type'] == 'country')
                            {{ Form::bsSelect('settings_'.$group['name'].'_'.$setting['name'], $countries, settings($group['name'].'.'.$setting['name']), ['data-live-search' => 'true', 'data-size' => 5], trans($setting['trans'])) }}
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    {{ Form::close() }}
@endsection

@push('scripts')
    <script>
        $("[data-type='tokenfield']").tokenfield();

        $(function() {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                localStorage.setItem('lastBackendSettingsTab', $(this).attr('href'));
            });

            // go to the latest tab, if it exists. Otherwise, show the first tab.
            var lastTab = localStorage.getItem('lastBackendSettingsTab');
            if (lastTab) {
                $('[href="' + lastTab + '"]').tab('show');
            } else {
                $("[data-toggle='tab']").first().tab('show');
            }
        });
    </script>
@endpush

@include('components.tool.tokenfield')
@include('components.tool.select')
