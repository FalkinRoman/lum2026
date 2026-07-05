@php
    $overlays = $place['overlays'] ?? [
        'bg-black/16',
        'bg-gradient-to-b from-[rgba(36,14,4,0.30)] from-[48%] to-transparent',
    ];
    $titleTop = $titleTop ?? 44;
    $locationTop = $locationTop ?? 571;
    $titleClass = $titleClass ?? 'text-[20px] leading-[24px] tracking-[-0.4px]';
    $regionClass = $regionClass ?? 'text-[16px] leading-[25px] tracking-[0.16px]';
    $pinSize = $pinSize ?? 64;
    $pinIconSize = $pinIconSize ?? 22;
@endphp

<img src="{{ $img('discover/' . $place['image']) }}" alt="" class="lum-dining-card__photo absolute inset-0 h-full w-full object-cover" width="{{ $width }}" height="{{ $height }}" loading="lazy">
@foreach ($overlays as $overlay)
    <span @class(['lum-dining-card__shade pointer-events-none absolute inset-0 z-[1]', $overlay]) aria-hidden="true"></span>
@endforeach

<p @class(['pointer-events-none absolute left-1/2 z-[2] -translate-x-1/2 text-center font-serif font-medium text-lum-ivory', $titleClass]) style="top: {{ $titleTop }}px">{{ $place['title'] }}</p>

<div class="pointer-events-none absolute left-1/2 z-[2] flex -translate-x-1/2 flex-col items-center gap-[16px]" style="top: {{ $locationTop }}px">
    <span class="flex items-center justify-center rounded-full border-2 border-lum-ivory bg-lum-ivory/16" style="width: {{ $pinSize }}px; height: {{ $pinSize }}px">
        <img src="{{ $img('discover/pin.svg') }}" alt="" style="width: {{ $pinIconSize }}px; height: {{ $pinIconSize }}px" width="{{ $pinIconSize }}" height="{{ $pinIconSize }}">
    </span>
    <p @class(['text-center text-lum-ivory', $regionClass])>{{ $place['region'] }}</p>
</div>
