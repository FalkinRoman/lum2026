@php
    $href = $href ?? '#';
    $text = $text ?? '';
@endphp

<a href="{{ $href }}" class="lum-menu-flip inline-block text-inherit" data-lum-text-flip>{{ $text }}</a>
