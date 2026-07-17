<section class="lum-container relative z-[1] overflow-visible h-[680px] tab:h-[1080px] desk:h-[1080px]">
    {{-- MOBILE — Figma 190:706; oval 190:772 at gallery y=-144 → hero top 536 --}}
    <div class="relative h-full overflow-visible tab:hidden" data-lum-villa-panel>
        <div class="absolute inset-0 overflow-hidden">
            <img src="{{ $img($assetBase . '/hero.webp') }}" alt="" class="h-full w-full object-cover object-center" width="375" height="680" loading="eager">
            <div class="absolute inset-0 bg-black/48"></div>
        </div>

        @include('lum.partials.header-mobile', ['headerTone' => 'ivory'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute left-[20px] top-[208px] flex w-[335px] flex-col items-center gap-[30px]" data-lum-villa-intro>
            <img src="{{ $img('stay/logomark.svg') }}" alt="" class="size-[32px] brightness-0 invert" width="32" height="32" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <div class="flex w-full flex-col items-center gap-[24px]">
                <p class="text-center text-[14px] font-medium uppercase leading-[14px] tracking-[0.6px] text-lum-ivory" data-lum-stay-intro-item data-lum-stay-intro-order="2">{{ $activity['hero']['eyebrow'] }}</p>
                <h1 class="lum-hero-title text-center text-lum-ivory" data-lum-hero-title>
                    @if ($activity['hero']['title_normal'] !== '')
                        <span class="lum-hero-title__line block">
                            <span class="lum-hero-title__text block font-serif text-[52px] leading-[55px]" data-lum-stay-intro-item data-lum-stay-intro-order="3">{{ $activity['hero']['title_normal'] }}</span>
                        </span>
                    @endif
                    <span class="lum-hero-title__line block">
                        <span class="lum-hero-title__text block font-serif text-[52px] font-medium italic leading-[55px]" data-lum-stay-intro-item data-lum-stay-intro-order="4">{{ $activity['hero']['title_italic'] }}</span>
                    </span>
                </h1>
            </div>
        </div>

        <div class="pointer-events-none absolute z-[20] h-[188px] w-[140px] overflow-hidden rounded-[50%]" style="top: 536px; left: 118px">
            <img src="{{ $img($assetBase . '/oval.webp') }}" alt="" class="h-full w-full object-cover" width="140" height="188">
        </div>

        <img src="{{ $img('hero/torn-edge-375.svg') }}" alt="" class="pointer-events-none absolute bottom-[-28px] left-0 z-10 w-full rotate-180 scale-x-[-1]" width="375" height="54">
    </div>

    {{-- TABLET — Figma 190:555; oval 190:580 at top 796 --}}
    <div class="relative hidden h-full overflow-visible tab:block desk:hidden" data-lum-villa-panel>
        <div class="absolute inset-0 overflow-hidden">
            <img src="{{ $img($assetBase . '/hero.webp') }}" alt="" class="h-full w-full object-cover object-center" width="960" height="1080" loading="eager">
            <div class="absolute inset-0 bg-black/48"></div>
        </div>

        @include('lum.partials.header-tablet', ['headerTone' => 'ivory'])

        <div class="absolute left-[20px] top-[449px] flex w-[920px] flex-col items-center gap-[30px]" data-lum-villa-intro>
            <img src="{{ $img('stay/logomark.svg') }}" alt="" class="size-[40px] brightness-0 invert" width="40" height="40" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <div class="flex w-full flex-col items-center gap-[24px]">
                <p class="text-center text-[16px] font-medium leading-[25px] tracking-[0.16px] text-lum-ivory" data-lum-stay-intro-item data-lum-stay-intro-order="2">{{ $activity['hero']['eyebrow'] }}</p>
                <h1 class="lum-hero-title whitespace-nowrap text-center text-lum-ivory" data-lum-hero-title>
                    @if ($activity['hero']['title_normal'] !== '')
                        <span class="lum-hero-title__line lum-hero-title__line--inline">
                            <span class="lum-hero-title__text font-serif text-[64px] leading-[64px]" data-lum-stay-intro-item data-lum-stay-intro-order="3">{{ $activity['hero']['title_normal'] }}</span>
                        </span>
                    @endif
                    <span class="lum-hero-title__line lum-hero-title__line--inline">
                        <span class="lum-hero-title__text font-serif text-[64px] font-medium italic leading-[64px]" data-lum-stay-intro-item data-lum-stay-intro-order="4">{{ $activity['hero']['title_italic'] }}</span>
                    </span>
                </h1>
            </div>
        </div>

        <div class="pointer-events-none absolute z-[20] h-[240px] w-[180px] overflow-hidden rounded-[50%]" style="top: 796px; left: 390px">
            <img src="{{ $img($assetBase . '/oval.webp') }}" alt="" class="h-full w-full object-cover" width="180" height="240">
        </div>

        <img src="{{ $img('hero/torn-edge-960.svg') }}" alt="" class="pointer-events-none absolute bottom-[-44px] left-0 z-10 h-[135px] w-[960px] max-w-none rotate-180 scale-x-[-1]" width="960" height="135">
    </div>

    {{-- DESKTOP — Figma 190:378; oval 770; torn-edge overlaps photo --}}
    <div class="relative hidden h-full overflow-visible desk:block" data-lum-villa-panel>
        <div class="absolute inset-0 overflow-hidden">
            <img src="{{ $img($assetBase . '/hero.webp') }}" alt="" class="h-full w-full object-cover object-center" width="1920" height="1080" loading="eager">
            <div class="absolute inset-0 bg-black/48"></div>
        </div>

        @include('lum.partials.header', ['headerTone' => 'ivory'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="absolute left-[80px] top-[398px] flex w-[1760px] flex-col items-center gap-[44px]" data-lum-villa-intro>
            <img src="{{ $img('stay/logomark.svg') }}" alt="" class="size-[64px] brightness-0 invert" width="64" height="64" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <div class="flex w-full flex-col items-center gap-[38px]">
                <p class="lum-eyebrow text-center text-lum-ivory" data-lum-stay-intro-item data-lum-stay-intro-order="2">{{ $activity['hero']['eyebrow'] }}</p>
                <div class="flex w-full items-center justify-center gap-[32px]">
                    <img src="{{ $img('hero/deco-left.svg') }}" alt="" class="w-[108px] rotate-180 scale-y-[-1] brightness-0 invert" width="108" height="2">
                    <h1 class="lum-hero-title whitespace-nowrap text-center text-lum-ivory" data-lum-hero-title>
                        @if ($activity['hero']['title_normal'] !== '')
                            <span class="lum-hero-title__line lum-hero-title__line--inline">
                                <span class="lum-hero-title__text font-serif text-[120px] leading-[120px] tracking-[-1.16px]" data-lum-stay-intro-item data-lum-stay-intro-order="3">{{ $activity['hero']['title_normal'] }}</span>
                            </span>
                        @endif
                        <span class="lum-hero-title__line lum-hero-title__line--inline">
                            <span class="lum-hero-title__text font-serif text-[120px] font-medium italic leading-[120px] tracking-[-1.16px]" data-lum-stay-intro-item data-lum-stay-intro-order="4">{{ $activity['hero']['title_italic'] }}</span>
                        </span>
                    </h1>
                    <img src="{{ $img('hero/deco-right.svg') }}" alt="" class="w-[108px] brightness-0 invert" width="108" height="2">
                </div>
            </div>
        </div>

        <div class="pointer-events-none absolute z-[20] h-[430px] w-[320px] overflow-hidden rounded-[50%]" style="top: 770px; left: 800px">
            <img src="{{ $img($assetBase . '/oval.webp') }}" alt="" class="h-full w-full object-cover" width="320" height="430">
        </div>

        <img src="{{ $img('hero/torn-edge.svg') }}" alt="" class="pointer-events-none absolute bottom-[-109px] left-1/2 z-10 h-[269px] w-[1920px] max-w-none -translate-x-1/2 rotate-180 scale-x-[-1]" width="1920" height="269">
    </div>
</section>
