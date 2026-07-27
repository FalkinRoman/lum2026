@props([
    'tabs',
    'tabKeys',
    'variant' => 'mobile',
    'activeCategory' => 'all',
])

@php
    $wrapperClass = match ($variant) {
        'mobile' => 'absolute left-1/2 top-[223px] flex w-[335px] -translate-x-1/2 flex-wrap justify-center gap-[10px]',
        'tablet' => 'absolute left-1/2 top-[264px] flex max-w-[920px] -translate-x-1/2 flex-wrap justify-center gap-[10px]',
        'desktop' => 'absolute left-1/2 top-[466px] flex max-w-[1100px] -translate-x-1/2 flex-wrap justify-center gap-[10px]',
        default => 'flex flex-wrap justify-center gap-[10px]',
    };
    $sizeClass = $variant === 'desktop' ? 'lum-tab--l' : 'lum-tab--s';
@endphp

<div class="{{ $wrapperClass }}" data-lum-blog-tabs data-lum-stay-intro-item data-lum-stay-intro-order="2">
    @foreach ($tabKeys as $index => $key)
        @php
            $isActive = $key === $activeCategory;
            $href = $key === 'all'
                ? route('blog')
                : route('blog', ['category' => $key]);
        @endphp
        <a
            href="{{ $href }}"
            @class([$sizeClass, 'lum-tab', 'lum-tab--active' => $isActive, 'lum-tab--inactive' => ! $isActive])
            data-lum-blog-tab
            data-category="{{ $key }}"
            @if ($isActive) aria-current="page" @endif
        >@if ($isActive)✓@endif{{ $tabs[$index] }}</a>
    @endforeach
</div>
