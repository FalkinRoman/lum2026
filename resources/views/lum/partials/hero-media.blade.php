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
    <div class="absolute inset-0 overflow-hidden" data-lum-hero-media data-lum-bp="{{ $bp }}">
        @if ($heroPosterUrl)
            <img
                src="{{ $heroPosterUrl }}"
                alt=""
                class="absolute inset-0 h-full w-full object-cover {{ $heroObjectPosition }}"
                aria-hidden="true"
            >
        @endif
        {{--
            src in HTML (not data-src): iOS/Telegram need muted+autoplay before JS.
            Hidden until `playing` so native play chrome never flashes.
        --}}
        <video
            class="absolute inset-0 h-full w-full object-cover {{ $heroObjectPosition }} opacity-0"
            src="{{ $heroVideoUrl }}"
            @if ($heroPosterUrl) poster="{{ $heroPosterUrl }}" @endif
            autoplay
            muted
            loop
            playsinline
            webkit-playsinline
            disablepictureinpicture
            disableremoteplayback
            preload="auto"
            data-lum-hero-video
            data-lum-bp="{{ $bp }}"
        ></video>
    </div>
@elseif ($heroPosterUrl)
    <img
        src="{{ $heroPosterUrl }}"
        alt=""
        class="h-full w-full object-cover {{ $heroObjectPosition }}"
    >
@else
    <div class="h-full w-full bg-lum-espresso" aria-hidden="true"></div>
@endif
