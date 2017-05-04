<div class="form-group">
    {{ Form::label($name, trans("validation.attributes.$name"), ['class' => 'control-label']) }}
    {{ Form::email($name, $value, array_merge(['class' => 'form-control'], $attributes)) }}
</div>
