@php
    $hero = \App\Support\Content::homeLocale('hero') ?? [];
    $heroPoster = filled($hero['video_poster'] ?? null) ? $hero['video_poster'] : null;
    $heroVideo = filled($hero['video'] ?? null) ? $hero['video'] : null;
    $heroPosition = $hero['video_position'] ?? 'center';
    $heroObjectPosition = match ($heroPosition) {
        'top' => 'object-top',
        'bottom' => 'object-bottom',
        default => 'object-center',
    };
    $heroVideoType = $heroVideo && str_ends_with(strtolower((string) $heroVideo), '.webm')
        ? 'video/webm'
        : 'video/mp4';
    $heroCtaHref = \App\Support\Content::link($hero['cta_url'] ?? null);
@endphp
<section class="lum-container relative h-[680px] tab:h-[1080px] desk:h-[1242px] bg-lum-cream">
    {{-- MOBILE --}}
    <div class="relative h-[680px] tab:hidden">
        <div class="absolute inset-0 overflow-hidden">
            @include('lum.partials.hero-media', ['bp' => 'mobile', 'img' => $img, 'heroVideo' => $heroVideo, 'heroPoster' => $heroPoster, 'heroObjectPosition' => $heroObjectPosition, 'heroVideoType' => $heroVideoType])
            <div class="absolute inset-0 bg-black/24"></div>
        </div>

        @include('lum.partials.header-mobile', ['homeHero' => true])

        <div class="absolute bottom-[80px] left-[20px] flex w-[335px] flex-col items-center gap-[36px]">
            <div class="flex w-full flex-col items-center gap-[30px]">
                <img src="{{ $img('hero/logomark.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                <div class="flex w-full flex-col items-center gap-[24px]">
                    <p class="w-full text-center text-[14px] font-medium uppercase leading-[14px] tracking-[0.6px] text-lum-ivory">{{ $hero['eyebrow_upper'] ?? __('lum.hero.eyebrow_upper') }}</p>
                    <h1 class="lum-hero-title text-center text-lum-ivory" data-lum-hero-title>
                        <span class="lum-hero-title__line block">
                            <span class="lum-hero-title__text block font-serif text-[52px] leading-[55px]">{{ $hero['title_normal'] ?? __('lum.hero.title_normal') }}</span>
                        </span>
                        <span class="lum-hero-title__line block">
                            <span class="lum-hero-title__text block font-serif text-[52px] font-medium italic leading-[55px]">{{ $hero['title_italic'] ?? __('lum.hero.title_italic') }}</span>
                        </span>
                    </h1>
                </div>
            </div>
            <div class="lum-hero-scroll-hint flex h-[48px] w-[48px] shrink-0 items-center justify-center">
                <img src="{{ $img('hero/scroll-arrow-375.svg') }}" alt="" class="w-[48px] rotate-90" width="49" height="7">
            </div>
            <a href="{{ $heroCtaHref }}" class="lum-btn-outline-ivory px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]" data-lum-sticky-trigger>{{ $hero['cta'] ?? __('lum.hero.cta') }}</a>
        </div>
    </div>

    {{-- TABLET --}}
    <div class="relative hidden h-[1080px] tab:block desk:hidden">
        <div class="absolute inset-0 overflow-hidden">
            @include('lum.partials.hero-media', ['bp' => 'tablet', 'img' => $img, 'heroVideo' => $heroVideo, 'heroPoster' => $heroPoster, 'heroObjectPosition' => $heroObjectPosition, 'heroVideoType' => $heroVideoType])
            <div class="absolute inset-0 bg-black/24"></div>
        </div>

        @include('lum.partials.header-tablet', ['homeHero' => true])

        <div class="absolute bottom-[231px] left-1/2 flex w-[920px] -translate-x-1/2 flex-col items-center gap-[36px]">
            <div class="flex w-full flex-col items-center gap-[30px]">
                <img src="{{ $img('hero/logomark.svg') }}" alt="" class="size-[40px]" width="40" height="40">
                <div class="flex w-full flex-col items-center gap-[24px]">
                    <p class="w-full text-center text-[16px] font-medium leading-[25px] tracking-[0.16px] text-lum-ivory">{{ $hero['eyebrow_upper'] ?? __('lum.hero.eyebrow_upper') }}</p>
                    <h1 class="lum-hero-title whitespace-nowrap text-center text-lum-ivory" data-lum-hero-title>
                        <span class="lum-hero-title__line lum-hero-title__line--inline">
                            <span class="lum-hero-title__text font-serif text-[64px] leading-[64px]">{{ $hero['title_normal'] ?? __('lum.hero.title_normal') }}&nbsp;</span>
                        </span>
                        <span class="lum-hero-title__line lum-hero-title__line--inline">
                            <span class="lum-hero-title__text font-serif text-[64px] font-medium italic leading-[64px]">{{ $hero['title_italic'] ?? __('lum.hero.title_italic') }}</span>
                        </span>
                    </h1>
                </div>
            </div>
            <div class="lum-hero-scroll-hint flex h-[48px] w-[48px] shrink-0 items-center justify-center">
                <img src="{{ $img('hero/scroll-arrow-960.svg') }}" alt="" class="w-[48px] rotate-90" width="49" height="7">
            </div>
            <a href="{{ $heroCtaHref }}" class="lum-btn-outline-ivory px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]" data-lum-sticky-trigger>{{ $hero['cta'] ?? __('lum.hero.cta') }}</a>
        </div>
    </div>

    {{-- DESKTOP --}}
    <div class="relative hidden h-[1242px] desk:block">
        <div class="absolute inset-0 h-[1242px] overflow-hidden">
            @include('lum.partials.hero-media', ['bp' => 'desktop', 'img' => $img, 'heroVideo' => $heroVideo, 'heroPoster' => $heroPoster, 'heroObjectPosition' => $heroObjectPosition, 'heroVideoType' => $heroVideoType])
            <div class="absolute inset-0 bg-black/24"></div>
        </div>

        @include('lum.partials.header', ['homeHero' => true])

        <div class="absolute left-[80px] top-[520px] flex w-[1760px] flex-col items-center gap-[44px]">
            <img src="{{ $img('hero/logomark.svg') }}" alt="" class="size-[64px]" width="64" height="64">
            <div class="flex w-full flex-col items-center gap-[38px]">
                <p class="lum-eyebrow text-center text-lum-ivory">{{ $hero['eyebrow_lower'] ?? __('lum.hero.eyebrow_lower') }}</p>
                <div class="flex w-full items-center justify-center gap-[32px]">
                    <img src="{{ $img('hero/deco-left.svg') }}" alt="" class="w-[108px] rotate-180 scale-y-[-1]" width="108" height="2">
                    <h1 class="lum-hero-title whitespace-nowrap text-center text-lum-ivory" data-lum-hero-title>
                        <span class="lum-hero-title__line lum-hero-title__line--inline">
                            <span class="lum-hero-title__text font-serif text-[120px] leading-[120px] tracking-[-1.16px]">{{ $hero['title_normal'] ?? __('lum.hero.title_normal') }}&nbsp;</span>
                        </span>
                        <span class="lum-hero-title__line lum-hero-title__line--inline">
                            <span class="lum-hero-title__text font-serif text-[120px] font-medium italic leading-[120px] tracking-[-1.16px]">{{ $hero['title_italic'] ?? __('lum.hero.title_italic') }}</span>
                        </span>
                    </h1>
                    <img src="{{ $img('hero/deco-right.svg') }}" alt="" class="w-[108px]" width="108" height="2">
                </div>
            </div>
        </div>

        <div class="lum-hero-scroll-hint absolute left-1/2 top-[868px] z-20 flex h-[86px] w-[86px] -translate-x-1/2 items-center justify-center">
            <img src="{{ $img('hero/scroll-arrow.svg') }}" alt="" class="w-[86px] rotate-90" width="87" height="7">
        </div>

        <a href="{{ $heroCtaHref }}" class="lum-btn-outline-ivory absolute left-1/2 top-[1018px] z-20 -translate-x-1/2" data-lum-sticky-trigger>{{ $hero['cta'] ?? __('lum.hero.cta') }}</a>
    </div>
</section>
