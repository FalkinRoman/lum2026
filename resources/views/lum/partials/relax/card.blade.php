@php
    $labelTop = $labelTop ?? 44;
    $nameTop = $nameTop ?? 687;
    $lineClass = $lineClass ?? 'w-[38px]';
    $nameClass = $nameClass ?? 'text-[18px] leading-[18px] tracking-[1.8px]';
    $labelPadX = $labelPadX ?? 'px-[48px]';
    $labelPadY = $labelPadY ?? 'py-[4px]';
@endphp

<img src="{{ $img('relax/' . $activity['image']) }}" alt="" class="lum-dining-card__photo absolute inset-0 h-full w-full object-cover" width="{{ $width }}" height="{{ $height }}" loading="lazy">
<span
    class="lum-dining-card__shade pointer-events-none absolute inset-0 z-[1]"
    style="background-image: linear-gradient(90deg, rgba(0, 0, 0, 0.16) 0%, rgba(0, 0, 0, 0.16) 100%), linear-gradient(180.48deg, rgba(36, 14, 4, 0.30) 48.425%, rgba(255, 255, 255, 0) 99.688%)"
    aria-hidden="true"
></span>

<div class="pointer-events-none absolute left-1/2 z-[2] flex -translate-x-1/2 rotate-1 items-center justify-center bg-[#bee7fd] {{ $labelPadX }} {{ $labelPadY }}" style="top: {{ $labelTop }}px">
    <p @class(['whitespace-nowrap text-center font-serif font-medium text-lum-espresso', $labelClass ?? 'text-[20px] leading-[24px] tracking-[-0.4px]'])>
        @if (! empty($activity['label_before']))
            <span class="not-italic">{{ $activity['label_before'] }}</span>
        @endif
        @if (! empty($activity['label_italic']))
            <span class="italic">{{ $activity['label_italic'] }}</span>
        @endif
        @if (! empty($activity['label_after']))
            <span class="not-italic">{{ $activity['label_after'] }}</span>
        @endif
        @if (! empty($activity['label_all_italic']))
            <span class="italic">{{ $activity['label_all_italic'] }}</span>
        @endif
    </p>
</div>

<div class="pointer-events-none absolute inset-x-0 z-[2] flex items-center justify-center gap-[12px]" style="top: {{ $nameTop }}px">
    <img src="{{ $img('dining/line-left.svg') }}" alt="" @class(['h-px shrink-0 object-cover', $lineClass]) width="38" height="1">
    <p @class(['shrink-0 text-center font-medium uppercase text-lum-ivory', $nameClass])>{{ $activity['name'] }}</p>
    <img src="{{ $img('dining/line-right.svg') }}" alt="" @class(['h-px shrink-0 object-cover', $lineClass]) width="38" height="1">
</div>
