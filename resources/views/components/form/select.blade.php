<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    {{ Form::label($name, $label ? $label : trans("validation.attributes.$name"), ['class' => 'control-label']) }}
    @if (isset($attributes['multiple']) && $attributes['multiple'] == true)
        {{ Form::select($name.'[]', $options, $value, array_merge(['class' => 'form-control selectpicker', 'aria-describedby' => $name.'HelpBlock', 'id' => $name], $attributes)) }}
    @else
        {{ Form::select($name, $options, $value, array_merge(['class' => 'form-control selectpicker', 'aria-describedby' => $name.'HelpBlock'], $attributes)) }}
    @endif
    @if($errors->has($name))
        <span id="{{ $name }}HelpBlock" class="help-block">
            {{ $errors->first($name) }}
        </span>
    @endif
</div>
