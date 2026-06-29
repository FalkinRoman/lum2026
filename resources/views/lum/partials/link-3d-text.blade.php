@php
    $href = $href ?? '#';
    $text = $text ?? '';
@endphp

<a href="{{ $href }}" class="lum-3d-text inline-block text-inherit" data-lum-3d-text>
    <span class="lum-3d-text__inner">
        <span class="lum-3d-text__word">{{ $text }}</span>
    </span>
</a>
