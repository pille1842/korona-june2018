<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    {{ Form::label($name, $label ? $label : trans("validation.attributes.$name"), ['class' => 'control-label']) }}
    <div class="input-group">
        {{ Form::text($name, $value, array_merge(['class' => 'form-control', 'aria-describedby' => $name.'HelpBlock'], $attributes)) }}
        <span class="input-group-btn">
            <button class="btn btn-default btn-korona-generate-slug"
                    data-source="{{ $source }}" data-target="{{ $name }}"
                    data-url="{{ route('slug') }}" type="button"
                    data-toggle="tooltip" title="{{ trans('backend.generate_slug') }}"
                    data-placement="bottom">
                <span class="glyphicon glyphicon-link"></span>
            </button>
        </span>
    </div>
    @if($errors->has($name))
        <span id="{{ $name }}HelpBlock" class="help-block">
            {{ $errors->first($name) }}
        </span>
    @endif
</div>
