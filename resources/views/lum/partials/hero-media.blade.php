@php
    /** @var callable $img */
    $heroObjectPosition = $heroObjectPosition ?? 'object-center';
    $heroVideo = $heroVideo ?? null;
    $heroPoster = $heroPoster ?? null;
    $heroVideoType = $heroVideoType ?? 'video/mp4';
    $bp = $bp ?? 'mobile';
@endphp
@if ($heroVideo)
    <video
        class="h-full w-full object-cover {{ $heroObjectPosition }}"
        autoplay
        muted
        loop
        playsinline
        preload="none"
        @if ($heroPoster) poster="{{ $img($heroPoster) }}" @endif
        data-lum-hero-video
        data-lum-bp="{{ $bp }}"
    >
        <source data-src="{{ $img($heroVideo) }}" type="{{ $heroVideoType }}">
    </video>
@elseif ($heroPoster)
    <img
        src="{{ $img($heroPoster) }}"
        alt=""
        class="h-full w-full object-cover {{ $heroObjectPosition }}"
    >
@else
    {{-- Empty CMS media → visible stub, not seed video --}}
    <div class="h-full w-full bg-lum-espresso" aria-hidden="true"></div>
@endif
