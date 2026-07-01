@php
    $isOpeningSoon = ($venue['cta'] ?? 'more_info') === 'opening_soon';
    $btnClass = $isOpeningSoon ? 'lum-btn-ivory' : 'lum-btn-dark';
    $ctaLabel = $isOpeningSoon ? __('lum.dining.opening_soon') : __('lum.location.more_info');
    $overlays = $venue['overlays'] ?? ['bg-black/32'];
@endphp

<img src="{{ $img('dining/' . $venue['image']) }}" alt="" class="lum-dining-card__photo absolute inset-0 h-full w-full object-cover" width="{{ $width }}" height="{{ $height }}" loading="lazy">
@foreach ($overlays as $overlay)
    <span @class(['lum-dining-card__shade pointer-events-none absolute inset-0 z-[1]', $overlay]) aria-hidden="true"></span>
@endforeach

<div class="pointer-events-none absolute inset-x-0 z-[2] flex flex-col items-center gap-[4px] px-[24px]" style="top: {{ $eyebrowTop }}px">
    <div class="flex w-full max-w-[351px] items-center justify-center gap-[4px]">
        <img src="{{ $img('dining/line-left.svg') }}" alt="" class="h-px w-[38px] shrink-0 object-cover" width="38" height="1">
        <p @class(['shrink-0 text-center font-medium uppercase text-lum-ivory', $eyebrowClass])>{{ $venue['eyebrow'] }}</p>
        <img src="{{ $img('dining/line-right.svg') }}" alt="" class="h-px w-[38px] shrink-0 object-cover" width="38" height="1">
    </div>
    <p @class(['w-full max-w-[351px] text-center text-lum-ivory', $subtitleClass])>{{ $venue['subtitle'] }}</p>
</div>

<h2 @class(['pointer-events-none absolute left-1/2 z-[2] -translate-x-1/2 text-center font-medium text-lum-ivory', $titleClass]) style="top: {{ $titleTop }}px">
    @if ($venue['title_normal'] !== '')
        <span class="font-medium not-italic">{{ $venue['title_normal'] }}</span>
    @endif
    <span class="italic">{{ $venue['title_italic'] }}</span>
</h2>

@if ($isOpeningSoon)
    <span @class([$btnClass, 'pointer-events-none absolute left-1/2 z-[2] -translate-x-1/2 whitespace-nowrap px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]']) style="top: {{ $ctaTop }}px">{{ $ctaLabel }}</span>
@else
    <a href="{{ route('restaurant.show', $venue['slug']) }}" @class([$btnClass, 'absolute left-1/2 z-[2] -translate-x-1/2 whitespace-nowrap px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]']) style="top: {{ $ctaTop }}px">{{ $ctaLabel }}</a>
@endif
