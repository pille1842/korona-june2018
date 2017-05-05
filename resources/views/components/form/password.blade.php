<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    {{ Form::label($name, trans("validation.attributes.$name"), ['class' => 'control-label']) }}
    {{ Form::password($name, array_merge(['class' => 'form-control', 'aria-describedby' => $name.'HelpBlock'], $attributes)) }}
    @if($errors->has($name))
        <span id="{{ $name }}HelpBlock" class="help-block">
            {{ $errors->first($name) }}
        </span>
    @endif
</div>
