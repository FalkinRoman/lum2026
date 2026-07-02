<section class="lum-container relative bg-lum-ivory h-[627px] tab:h-[495px] desk:h-[758px]">
    {{-- MOBILE — Figma 103:824 (frame h 627, divider top 415) --}}
    <div class="relative h-full overflow-visible tab:hidden" data-lum-villa-panel>
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute inset-0" data-lum-villa-intro>
            <h1 class="absolute left-1/2 top-[146px] w-[335px] -translate-x-1/2 text-center font-serif text-[42px] leading-[45px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="1">{{ $excursion['intro']['title'] }}</h1>

            <p class="absolute left-1/2 top-[223px] w-[295px] max-h-[168px] -translate-x-1/2 overflow-hidden text-center text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="2">{{ $excursion['intro']['body'] }}</p>

            <img src="{{ $img('dining/detail/shared/divider-mob.svg') }}" alt="" class="absolute left-[17px] top-[415px] h-[31px] w-[335px]" width="335" height="31" data-lum-stay-intro-item data-lum-stay-intro-order="3">
        </div>
    </div>

    {{-- TABLET — Figma 103:713 --}}
    <div class="relative hidden h-full overflow-visible tab:block desk:hidden" data-lum-villa-panel>
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])

        <div class="absolute inset-0" data-lum-villa-intro>
            <h1 class="absolute left-1/2 top-[180px] -translate-x-1/2 whitespace-nowrap text-center font-serif text-[52px] leading-[52px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="1">{{ $excursion['intro']['title'] }}</h1>

            <p class="absolute left-1/2 top-[276px] w-[580px] max-h-[156px] -translate-x-1/2 overflow-hidden text-center lum-text-2 text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="2">{{ $excursion['intro']['body'] }}</p>

            <img src="{{ $img('dining/detail/shared/divider-tab.svg') }}" alt="" class="absolute left-[20px] top-[456px] h-[39px] w-[920px]" width="920" height="39" data-lum-stay-intro-item data-lum-stay-intro-order="3">
        </div>
    </div>

    {{-- DESKTOP — Figma 103:580 --}}
    <div class="relative hidden h-full desk:block" data-lum-villa-panel>
        @include('lum.partials.header', ['headerTone' => 'espresso', 'headerActive' => 'discover'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="absolute inset-0" data-lum-villa-intro>
            <h1 class="absolute left-1/2 top-[292px] w-[856px] -translate-x-1/2 text-center font-serif text-[88px] leading-[94px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="1">{{ $excursion['intro']['title'] }}</h1>

            <p class="absolute left-1/2 top-[466px] w-[856px] -translate-x-1/2 text-center lum-body text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="2">{{ $excursion['intro']['body'] }}</p>

            <img src="{{ $img('dining/detail/shared/divider.svg') }}" alt="" class="absolute bottom-0 left-[72px] h-[63px] w-[1776px]" width="1776" height="63" data-lum-stay-intro-item data-lum-stay-intro-order="3">
        </div>
    </div>
</section>
