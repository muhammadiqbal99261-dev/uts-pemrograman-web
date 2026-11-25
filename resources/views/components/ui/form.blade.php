@props(['type' => 'text', 'name' => '', 'value' => '', 'checked' => false])

<input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" {{ $checked ? 'checked' : '' }} {{ $attributes->merge(['class' => in_array($type, ['radio', 'checkbox']) ? 'form-check-input' : 'form-control']) }}>
