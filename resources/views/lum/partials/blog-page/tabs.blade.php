@props([
    'tabs',
    'tabKeys',
    'variant' => 'mobile',
])

@php
    $wrapperClass = match ($variant) {
        'mobile' => 'absolute left-1/2 top-[223px] flex w-[335px] -translate-x-1/2 flex-wrap justify-center gap-[10px]',
        'tablet' => 'absolute left-1/2 top-[264px] flex -translate-x-1/2 flex-nowrap justify-center gap-[10px]',
        'desktop' => 'absolute left-1/2 top-[466px] flex -translate-x-1/2 flex-nowrap justify-center gap-[10px]',
        default => 'flex flex-wrap justify-center gap-[10px]',
    };
    $sizeClass = $variant === 'desktop' ? 'lum-tab--l' : 'lum-tab--s';
@endphp

<div class="{{ $wrapperClass }}" data-lum-blog-tabs data-lum-stay-intro-item data-lum-stay-intro-order="2">
    @foreach ($tabKeys as $index => $key)
        @if ($variant === 'mobile' && $key === 'kitchen')
            <div class="flex w-full basis-full justify-center gap-[10px]">
        @endif
        <button
            type="button"
            @class([$sizeClass, 'lum-tab', 'lum-tab--active' => $index === 0, 'lum-tab--inactive' => $index !== 0])
            data-lum-blog-tab
            data-category="{{ $key }}"
        >@if ($index === 0)✓@endif{{ $tabs[$index] }}</button>
        @if ($variant === 'mobile' && $key === 'sri-lanka')
            </div>
        @endif
    @endforeach
</div>
