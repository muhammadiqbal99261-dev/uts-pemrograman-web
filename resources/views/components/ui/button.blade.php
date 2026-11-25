@props(['variant' => 'primary'])

@php
    $btnClass = str_starts_with($variant, 'btn-') ? $variant : 'btn-' . ($variant === 'accent' ? 'warning' : $variant);
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => "btn $btnClass"]) }}>
    {{ $slot }}
</button>
