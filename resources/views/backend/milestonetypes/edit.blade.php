@extends('layouts.backend')

@section('title')
    {{ trans('backend.create_milestonetype') }}
@endsection

@section('content')

    <h1>{{ trans('backend.edit_milestonetype', ['milestonetype' => $milestonetype->name]) }}</h1>

    {{ Form::model($milestonetype, ['route' => ['backend.milestonetype.update', $milestonetype], 'method' => 'put', 'class' => 'form']) }}
        <div class="well">
            <button type="submit" class="btn btn-primary">
                {{ trans('backend.save') }}
            </button>
            <a href="{{ route('backend.milestonetype.index') }}" class="btn btn-default">
                {{ trans('backend.close') }}
            </a>
        </div>
        {{ Form::bsText('name') }}
        <div class="form-group{{ $errors->has('symbol') ? ' has-error' : '' }}">
            {{ Form::label('symbol', trans('validation.attributes.symbol'), ['class' => 'control-label']) }}
            <select class="form-control selectpicker" aria-describedby="symbolHelpBlock"
                    id="symbol" name="symbol" data-live-search="true" data-size="5">
                @foreach (\Korona\Milestonetype::getIconsArray() as $icon)
                    <option data-icon="fa fa-{{ $icon }}" value="{{ $icon }}"{{ $icon == $milestonetype->symbol ? ' selected' : '' }}>{{ $icon }}</option>
                @endforeach
            </select>
            @if($errors->has('symbol'))
                <span id="symbolHelpBlock" class="help-block">
                    {{ $errors->first('symbol') }}
                </span>
            @endif
        </div>
        {{ Form::bsTextarea('template') }}
        <h3>{{ trans('backend.preview') }}</h3>
        <p id="preview"></p>
    {{ Form::close() }}
@endsection

@push('scripts')
    <script>
        templateChange = function () {
            var txt = $("#template").val();
            $("#preview").html(
                txt.replace(":member", "{{ Auth::user()->member->getShortName() }}")
                   .replace(":param", "XYZ")
            );
        }
        $("#template").bind('input propertychange', templateChange);
        templateChange();
    </script>
@endpush

@include('components.tool.select')
