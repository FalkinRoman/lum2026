<section class="lum-container relative h-[680px] tab:h-[1080px] desk:h-[1080px]">
    {{-- MOBILE --}}
    <div class="relative h-full tab:hidden" data-lum-villa-panel>
        <div class="absolute inset-0 overflow-hidden">
            <img src="{{ $img('villa/hero.webp') }}" alt="" class="h-full w-full object-cover object-center" width="375" height="680" loading="eager">
            <div class="absolute inset-0 bg-black/24"></div>
        </div>

        @include('lum.partials.header-mobile', ['headerTone' => 'ivory'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute left-[20px] top-[256px] flex w-[335px] flex-col items-center gap-[30px]" data-lum-villa-intro>
            <img src="{{ $img('stay/logomark.svg') }}" alt="" class="size-[32px] brightness-0 invert" width="32" height="32" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <div class="flex w-full flex-col items-center gap-[24px]">
                <p class="text-center text-[14px] font-medium uppercase leading-[14px] tracking-[0.6px] text-lum-ivory" data-lum-stay-intro-item data-lum-stay-intro-order="2">{{ $villa['hero']['eyebrow'] }}</p>
                <h1 class="lum-hero-title text-center text-lum-ivory" data-lum-hero-title>
                    <span class="lum-hero-title__line block">
                        <span class="lum-hero-title__text block font-serif text-[52px] leading-[55px]" data-lum-stay-intro-item data-lum-stay-intro-order="3">{{ $villa['hero']['title_normal'] }}</span>
                    </span>
                    <span class="lum-hero-title__line block">
                        <span class="lum-hero-title__text block font-serif text-[52px] font-medium italic leading-[55px]" data-lum-stay-intro-item data-lum-stay-intro-order="4">{{ $villa['hero']['title_italic'] }}</span>
                    </span>
                </h1>
            </div>
        </div>

        <img src="{{ $img('hero/torn-edge-375.svg') }}" alt="" class="pointer-events-none absolute bottom-[-28px] left-0 w-full rotate-180 scale-x-[-1]" width="375" height="54">
    </div>

    {{-- TABLET --}}
    <div class="relative hidden h-full tab:block desk:hidden" data-lum-villa-panel>
        <div class="absolute inset-0 overflow-hidden">
            <img src="{{ $img('villa/hero.webp') }}" alt="" class="h-full w-full object-cover object-center" width="960" height="1080" loading="eager">
            <div class="absolute inset-0 bg-black/24"></div>
        </div>

        @include('lum.partials.header-tablet', ['headerTone' => 'ivory'])

        <div class="absolute left-[20px] top-[449px] flex w-[920px] flex-col items-center gap-[30px]" data-lum-villa-intro>
            <img src="{{ $img('stay/logomark.svg') }}" alt="" class="size-[40px] brightness-0 invert" width="40" height="40" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <div class="flex w-full flex-col items-center gap-[24px]">
                <p class="text-center text-[16px] font-medium leading-[25px] tracking-[0.16px] text-lum-ivory" data-lum-stay-intro-item data-lum-stay-intro-order="2">{{ $villa['hero']['eyebrow'] }}</p>
                <h1 class="lum-hero-title whitespace-nowrap text-center text-lum-ivory" data-lum-hero-title>
                    <span class="lum-hero-title__line lum-hero-title__line--inline">
                        <span class="lum-hero-title__text font-serif text-[64px] leading-[64px]" data-lum-stay-intro-item data-lum-stay-intro-order="3">{{ $villa['hero']['title_normal'] }}</span>
                    </span>
                    <span class="lum-hero-title__line lum-hero-title__line--inline">
                        <span class="lum-hero-title__text font-serif text-[64px] font-medium italic leading-[64px]" data-lum-stay-intro-item data-lum-stay-intro-order="4">{{ $villa['hero']['title_italic'] }}</span>
                    </span>
                </h1>
            </div>
        </div>

        <img src="{{ $img('hero/torn-edge-960.svg') }}" alt="" class="pointer-events-none absolute bottom-[-44px] left-0 z-10 h-[135px] w-[960px] max-w-none rotate-180 scale-x-[-1]" width="960" height="135">
    </div>

    {{-- DESKTOP --}}
    <div class="relative hidden h-full desk:block" data-lum-villa-panel>
        <div class="absolute inset-0 overflow-hidden">
            <img src="{{ $img('villa/hero.webp') }}" alt="" class="h-full w-full object-cover object-center" width="1920" height="1080" loading="eager">
            <div class="absolute inset-0 bg-black/24"></div>
        </div>

        @include('lum.partials.header', ['headerTone' => 'ivory', 'headerActive' => 'stay'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="absolute left-[80px] top-[398px] flex w-[1760px] flex-col items-center gap-[44px]" data-lum-villa-intro>
            <img src="{{ $img('stay/logomark.svg') }}" alt="" class="size-[64px] brightness-0 invert" width="64" height="64" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <div class="flex w-full flex-col items-center gap-[38px]">
                <p class="lum-eyebrow text-center text-lum-ivory" data-lum-stay-intro-item data-lum-stay-intro-order="2">{{ $villa['hero']['eyebrow'] }}</p>
                <div class="flex w-full items-center justify-center gap-[32px]">
                    <img src="{{ $img('hero/deco-left.svg') }}" alt="" class="w-[108px] rotate-180 scale-y-[-1] brightness-0 invert" width="108" height="2">
                    <h1 class="lum-hero-title whitespace-nowrap text-center text-lum-ivory" data-lum-hero-title>
                        <span class="lum-hero-title__line lum-hero-title__line--inline">
                            <span class="lum-hero-title__text font-serif text-[120px] leading-[120px] tracking-[-1.16px]" data-lum-stay-intro-item data-lum-stay-intro-order="3">{{ $villa['hero']['title_normal'] }}</span>
                        </span>
                        <span class="lum-hero-title__line lum-hero-title__line--inline">
                            <span class="lum-hero-title__text font-serif text-[120px] font-medium italic leading-[120px] tracking-[-1.16px]" data-lum-stay-intro-item data-lum-stay-intro-order="4">{{ $villa['hero']['title_italic'] }}</span>
                        </span>
                    </h1>
                    <img src="{{ $img('hero/deco-right.svg') }}" alt="" class="w-[108px] brightness-0 invert" width="108" height="2">
                </div>
            </div>
        </div>

        <img src="{{ $img('hero/torn-edge-960.svg') }}" alt="" class="pointer-events-none absolute bottom-[-44px] left-1/2 z-10 h-[135px] w-[1920px] max-w-none -translate-x-1/2 rotate-180 scale-x-[-1]" width="960" height="135">
    </div>
</section>
