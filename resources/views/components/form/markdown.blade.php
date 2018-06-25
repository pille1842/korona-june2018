<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    {{ Form::label($name, $label ? $label : trans("validation.attributes.$name"), ['class' => 'control-label']) }}
    {{ Form::textarea($name, $value, array_merge(['class' => 'form-control simplemde', 'aria-describedby' => $name.'HelpBlock'], $attributes)) }}
    @if($errors->has($name))
        <span id="{{ $name }}HelpBlock" class="help-block">
            {{ $errors->first($name) }}
        </span>
    @endif
</div>
