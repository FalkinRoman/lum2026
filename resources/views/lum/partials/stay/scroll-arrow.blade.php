@php
    $sizes = match ($variant) {
        'mob' => ['box' => 64, 'arrow' => 64, 'file' => 'stay/scroll-arrow-mob.svg', 'width' => 65],
        'tab' => ['box' => 86, 'arrow' => 86, 'file' => 'stay/scroll-arrow-tab.svg', 'width' => 87],
        default => ['box' => 86, 'arrow' => 86, 'file' => 'stay/scroll-arrow-desk.svg', 'width' => 87],
    };
@endphp

<div
    class="lum-hero-scroll-hint pointer-events-none absolute left-1/2 z-20 flex -translate-x-1/2 items-center justify-center"
    style="top: {{ $top }}px; width: {{ $sizes['box'] }}px; height: {{ $sizes['box'] }}px"
>
    <img
        src="{{ $img($sizes['file']) }}"
        alt=""
        class="rotate-90"
        style="width: {{ $sizes['arrow'] }}px; height: auto"
        width="{{ $sizes['width'] }}"
        height="7"
    >
</div>
