<?php
    $value = isset($value) ? $value : '';
    $label = isset($label) ? $label : $name;
    $hideLabel = isset($hideLabel) ? $hideLabel : false;
    $class = isset($class) ? $class : '';
    $isSmall = isset($isSmall) ? $isSmall : '';
    $errorKey = isset($errorKey) ? $errorKey : $name;
    $hideErrorMessage = isset($hideErrorMessage) ? $hideErrorMessage : false;
    $placeholder = isset($placeholder) ? $placeholder : '';
    $class = join(' ', array_filter(['form-control', $class, $isSmall ? 'input-sm' : '']));
?>

<div class="form-group {{ $errors->has($errorKey) ? 'has-error' : '' }}">
    @if(!$hideLabel)
        <label class="control-label" for="{{ $name }}">{{ $label }}</label>
    @endif

    <input type="datetime-local" class="{{ $class }}" value="{{ old($errorKey, $value) }}" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}">
    @if($errors->has($errorKey) && !$hideErrorMessage)
        <span class="help-block">{{ $errors->first($errorKey) }}</span>
    @endif
</div>
