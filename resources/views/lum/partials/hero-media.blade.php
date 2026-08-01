@php
    /** @var callable $img */
    $heroObjectPosition = $heroObjectPosition ?? 'object-center';
    $heroVideo = $heroVideo ?? null;
    $heroPoster = $heroPoster ?? null;
    $heroVideoType = $heroVideoType ?? 'video/mp4';
    $bp = $bp ?? 'mobile';
    $heroVideoUrl = $heroVideo ? $img($heroVideo) : null;
    $heroPosterUrl = $heroPoster ? $img($heroPoster) : null;
@endphp
@if ($heroVideoUrl)
    {{-- Poster first; video src injected by JS for active breakpoint only --}}
    <div class="lum-hero-media absolute inset-0 overflow-hidden" data-lum-hero-media data-lum-bp="{{ $bp }}">
        @if ($heroPosterUrl)
            <img
                src="{{ $heroPosterUrl }}"
                alt=""
                class="lum-hero-media__poster absolute inset-0 h-full w-full object-cover {{ $heroObjectPosition }}"
                width="1920"
                height="1080"
                decoding="async"
                fetchpriority="{{ $bp === 'mobile' ? 'high' : 'auto' }}"
                aria-hidden="true"
            >
        @else
            <div class="absolute inset-0 bg-lum-espresso" aria-hidden="true"></div>
        @endif
        <video
            class="lum-hero-media__video absolute inset-0 h-full w-full object-cover {{ $heroObjectPosition }}"
            @if ($heroPosterUrl) poster="{{ $heroPosterUrl }}" @endif
            muted
            loop
            playsinline
            webkit-playsinline
            disablepictureinpicture
            disableremoteplayback
            preload="none"
            data-lum-hero-video
            data-lum-bp="{{ $bp }}"
            data-src="{{ $heroVideoUrl }}"
            data-type="{{ $heroVideoType }}"
        ></video>
    </div>
@elseif ($heroPosterUrl)
    <img
        src="{{ $heroPosterUrl }}"
        alt=""
        class="h-full w-full object-cover {{ $heroObjectPosition }}"
        width="1920"
        height="1080"
        decoding="async"
    >
@else
    <div class="h-full w-full bg-lum-espresso" aria-hidden="true"></div>
@endif
