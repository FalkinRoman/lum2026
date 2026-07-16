@php
    $href = $href ?? '#';
    $text = $text ?? '';
@endphp

{{-- Same mask-slide as header nav links: whole line up on hover, reverse on leave --}}
<a href="{{ $href }}" class="lum-text-slide inline-block text-inherit">
    <span class="lum-text-slide__mask">
        <span class="lum-text-slide__track">
            <span class="lum-text-slide__line">{{ $text }}</span>
            <span class="lum-text-slide__line" aria-hidden="true">{{ $text }}</span>
        </span>
    </span>
</a>
