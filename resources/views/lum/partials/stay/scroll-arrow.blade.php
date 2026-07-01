@php
    $sizes = match ($variant) {
        'mob' => ['box' => 64, 'arrow' => 64, 'file' => 'stay/scroll-arrow-mob.svg', 'width' => 65],
        'tab' => ['box' => 86, 'arrow' => 86, 'file' => 'stay/scroll-arrow-tab.svg', 'width' => 87],
        default => ['box' => 86, 'arrow' => 86, 'file' => 'stay/scroll-arrow-desk.svg', 'width' => 87],
    };
    $marginClass = $marginClass ?? 'mt-[44px]';
@endphp

<div
    class="lum-hero-scroll-hint lum-stay-arrow {{ $marginClass }} flex items-center justify-center opacity-0"
    style="width: {{ $sizes['box'] }}px; height: {{ $sizes['box'] }}px"
    data-lum-stay-intro-item="arrow"
    aria-hidden="true"
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
