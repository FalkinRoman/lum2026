@php
    $intro = $excursion['intro'];
@endphp

<section class="lum-container relative bg-lum-ivory" data-lum-villa-panel>
    {{-- MOBILE — Figma 196:588 --}}
    <div class="relative overflow-visible tab:hidden">
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        {{-- header absolute; content y=124, body→div 60, after div 181 (oval overlap) --}}
        <div class="flex flex-col items-center px-[20px] pb-[181px] pt-[124px]" data-lum-villa-intro>
            <div class="flex w-[335px] flex-col items-center gap-[22px] text-center">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6" data-lum-stay-intro-item data-lum-stay-intro-order="0">
                <h1 class="w-full font-serif text-[42px] leading-[45px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="1">{{ $intro['title'] }}</h1>
            </div>
            <p class="mt-[32px] w-[295px] text-center text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="2">{{ $intro['body'] }}</p>
            <img src="{{ $img('dining/detail/shared/divider-mob.svg') }}" alt="" class="mt-[60px] h-[31px] w-[335px]" width="335" height="31" data-lum-stay-intro-item data-lum-stay-intro-order="3">
        </div>
    </div>

    {{-- TABLET — Figma 196:477 --}}
    <div class="relative hidden overflow-visible tab:block desk:hidden" data-lum-villa-panel>
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])

        {{-- header absolute; content y=160, body→div 80 --}}
        <div class="flex flex-col items-center px-[20px] pb-0 pt-[160px]" data-lum-villa-intro>
            <div class="flex flex-col items-center gap-[12px] text-center">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8" data-lum-stay-intro-item data-lum-stay-intro-order="0">
                <h1 class="whitespace-nowrap font-serif text-[52px] leading-[52px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="1">{{ $intro['title'] }}</h1>
            </div>
            <p class="mt-[44px] w-[580px] text-center lum-text-2 text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="2">{{ $intro['body'] }}</p>
            <img src="{{ $img('dining/detail/shared/divider-tab.svg') }}" alt="" class="mt-[80px] h-[39px] w-[920px]" width="920" height="39" data-lum-stay-intro-item data-lum-stay-intro-order="3">
        </div>
    </div>

    {{-- DESKTOP — Figma 196:344 --}}
    <div class="relative hidden desk:block" data-lum-villa-panel>
        @include('lum.partials.header', ['headerTone' => 'espresso', 'headerActive' => 'discover'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        {{-- header absolute; content y=292, body→div 151 --}}
        <div class="flex flex-col items-center pb-0 pt-[292px]" data-lum-villa-intro>
            <div class="flex w-[856px] flex-col items-center gap-[24px] text-center">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12" data-lum-stay-intro-item data-lum-stay-intro-order="0">
                <h1 class="w-full font-serif text-[88px] leading-[94px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="1">{{ $intro['title'] }}</h1>
            </div>
            <p class="mt-[44px] w-[856px] text-center lum-body text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="2">{{ $intro['body'] }}</p>
            <img src="{{ $img('dining/detail/shared/divider.svg') }}" alt="" class="mt-[151px] h-[63px] w-[1776px]" width="1776" height="63" data-lum-stay-intro-item data-lum-stay-intro-order="3">
        </div>
    </div>
</section>
