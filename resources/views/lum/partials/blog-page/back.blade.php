@props([
    'href',
    'img',
    'size' => 's',
])

@php
    $label = __('lum.blog.back');
    $btnClass = $size === 'l'
        ? 'lum-btn-outline px-[24px] py-[5px] lum-text-2'
        : 'lum-btn-outline px-[20px] py-[5px] text-[14px] leading-[23px] tracking-[2.84px]';
    $iconClass = $size === 'l' ? 'size-[36px]' : 'size-[32px]';
    $arrowClass = $size === 'l' ? 'size-[28px]' : 'size-[24px]';
    $arrowSize = $size === 'l' ? 28 : 24;
@endphp

<div class="lum-blog-back flex items-center gap-[10px]">
    <a
        href="{{ $href }}"
        class="lum-icon-btn lum-icon-btn--espresso-outline {{ $iconClass }} items-center justify-center p-[4px]"
        aria-label="{{ $label }}"
    >
        <img src="{{ $img('ui/carousel-arrow-left.svg') }}" alt="" class="{{ $arrowClass }}" width="{{ $arrowSize }}" height="{{ $arrowSize }}">
    </a>
    <a href="{{ $href }}" class="{{ $btnClass }}">{{ $label }}</a>
</div>
