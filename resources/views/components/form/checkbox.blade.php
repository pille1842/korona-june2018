<div class="checkbox">
    <label>
        {{ Form::checkbox($name, $value, $checked) }} {{ $label ? $label : trans("validation.attributes.$name") }}
    </label>
</div>
