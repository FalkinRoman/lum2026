<section class="lum-container relative h-[680px] tab:h-[1080px] desk:h-[1242px] bg-lum-cream">
    {{-- MOBILE --}}
    <div class="relative h-[680px] tab:hidden">
        <div class="absolute inset-0 overflow-hidden">
            <video class="h-full w-full object-cover object-center" autoplay muted loop playsinline preload="none" poster="{{ $img('hero/video-poster.png') }}" data-lum-hero-video data-lum-bp="mobile">
                <source data-src="{{ $img('hero/video.mp4') }}" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-black/24"></div>
        </div>

        @include('lum.partials.header-mobile')

        <div class="absolute bottom-[80px] left-[20px] flex w-[335px] flex-col items-center gap-[36px]">
            <div class="flex w-full flex-col items-center gap-[30px]">
                <img src="{{ $img('hero/logomark.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                <div class="flex w-full flex-col items-center gap-[24px]">
                    <p class="w-full text-center text-[14px] font-medium uppercase leading-[14px] tracking-[0.6px] text-lum-ivory">THE LUM – SRI LANKA</p>
                    <h1 class="lum-hero-title text-center text-lum-ivory" data-lum-hero-title>
                        <span class="lum-hero-title__line block">
                            <span class="lum-hero-title__text block font-serif text-[52px] leading-[55px]">Find the spirit of</span>
                        </span>
                        <span class="lum-hero-title__line block">
                            <span class="lum-hero-title__text block font-serif text-[52px] font-medium italic leading-[55px]">Sri Lanka</span>
                        </span>
                    </h1>
                </div>
            </div>
            <div class="flex h-[48px] w-[48px] shrink-0 items-center justify-center">
                <img src="{{ $img('hero/scroll-arrow-375.svg') }}" alt="" class="w-[48px] rotate-90" width="49" height="7">
            </div>
            <a href="#villas" class="lum-btn-green px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]" data-lum-sticky-trigger>explore our villas</a>
        </div>

        <img src="{{ $img('hero/torn-edge-375.svg') }}" alt="" class="pointer-events-none absolute bottom-[-28px] left-0 w-full rotate-180 scale-x-[-1]" width="375" height="54">
    </div>

    {{-- TABLET --}}
    <div class="relative hidden h-[1080px] tab:block desk:hidden">
        <div class="absolute inset-0 overflow-hidden">
            <video class="h-full w-full object-cover object-center" autoplay muted loop playsinline preload="none" poster="{{ $img('hero/video-poster.png') }}" data-lum-hero-video data-lum-bp="tablet">
                <source data-src="{{ $img('hero/video.mp4') }}" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-black/24"></div>
        </div>

        @include('lum.partials.header-tablet')

        <div class="absolute bottom-[231px] left-1/2 flex w-[920px] -translate-x-1/2 flex-col items-center gap-[36px]">
            <div class="flex w-full flex-col items-center gap-[30px]">
                <img src="{{ $img('hero/logomark.svg') }}" alt="" class="size-[40px]" width="40" height="40">
                <div class="flex w-full flex-col items-center gap-[24px]">
                    <p class="w-full text-center text-[16px] font-medium leading-[25px] tracking-[0.16px] text-lum-ivory">THE LUM – SRI LANKA</p>
                    <h1 class="lum-hero-title whitespace-nowrap text-center text-lum-ivory" data-lum-hero-title>
                        <span class="lum-hero-title__line lum-hero-title__line--inline">
                            <span class="lum-hero-title__text font-serif text-[64px] leading-[64px]">Find the spirit of&nbsp;</span>
                        </span>
                        <span class="lum-hero-title__line lum-hero-title__line--inline">
                            <span class="lum-hero-title__text font-serif text-[64px] font-medium italic leading-[64px]">Sri Lanka</span>
                        </span>
                    </h1>
                </div>
            </div>
            <div class="flex h-[48px] w-[48px] shrink-0 items-center justify-center">
                <img src="{{ $img('hero/scroll-arrow-960.svg') }}" alt="" class="w-[48px] rotate-90" width="49" height="7">
            </div>
            <a href="#villas" class="lum-btn-green px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]" data-lum-sticky-trigger>explore our villas</a>
        </div>

        <img src="{{ $img('hero/torn-edge-960.svg') }}" alt="" class="pointer-events-none absolute bottom-[-44px] left-0 z-10 h-[135px] w-[960px] max-w-none rotate-180 scale-x-[-1]" width="960" height="135">
    </div>

    {{-- DESKTOP (не трогаем) --}}
    <div class="relative hidden h-[1242px] desk:block">
        <div class="absolute inset-0 h-[1242px] overflow-hidden">
            <video class="h-full w-full object-cover object-center" autoplay muted loop playsinline preload="none" poster="{{ $img('hero/video-poster.png') }}" data-lum-hero-video data-lum-bp="desktop">
                <source data-src="{{ $img('hero/video.mp4') }}" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-black/24"></div>
        </div>

        @include('lum.partials.header')

        <div class="absolute left-[80px] top-[520px] flex w-[1760px] flex-col items-center gap-[44px]">
            <img src="{{ $img('hero/logomark.svg') }}" alt="" class="size-[64px]" width="64" height="64">
            <div class="flex w-full flex-col items-center gap-[38px]">
                <p class="lum-eyebrow text-center text-lum-ivory">The lum – sri lanka</p>
                <div class="flex w-full items-center justify-center gap-[32px]">
                    <img src="{{ $img('hero/deco-left.svg') }}" alt="" class="w-[108px] rotate-180 scale-y-[-1]" width="108" height="2">
                    <h1 class="lum-hero-title whitespace-nowrap text-center text-lum-ivory" data-lum-hero-title>
                        <span class="lum-hero-title__line lum-hero-title__line--inline">
                            <span class="lum-hero-title__text font-serif text-[120px] leading-[120px] tracking-[-1.16px]">Find the spirit of&nbsp;</span>
                        </span>
                        <span class="lum-hero-title__line lum-hero-title__line--inline">
                            <span class="lum-hero-title__text font-serif text-[120px] font-medium italic leading-[120px] tracking-[-1.16px]">Sri Lanka</span>
                        </span>
                    </h1>
                    <img src="{{ $img('hero/deco-right.svg') }}" alt="" class="w-[108px]" width="108" height="2">
                </div>
            </div>
        </div>

        <div class="absolute left-1/2 top-[868px] z-20 flex h-[86px] w-[86px] -translate-x-1/2 items-center justify-center">
            <img src="{{ $img('hero/scroll-arrow.svg') }}" alt="" class="w-[86px] rotate-90" width="87" height="7">
        </div>

        <a href="#villas" class="lum-btn-green absolute left-1/2 top-[1018px] z-20 -translate-x-1/2" data-lum-sticky-trigger>explore our villas</a>

        <img src="{{ $img('hero/torn-edge.svg') }}" alt="" class="pointer-events-none absolute bottom-[-109px] left-0 z-10 h-[269px] w-[1920px] max-w-none rotate-180 scale-x-[-1]" width="1920" height="269">
    </div>
</section>
