@php
    $places = trans('lum.discover.places');

    $mobileLayout = [
        ['top' => 495],
        ['top' => 925],
        ['top' => 1355],
        ['top' => 1785],
    ];

    $tabletLayout = [
        ['left' => 20, 'top' => 588],
        ['left' => 490, 'top' => 588],
        ['left' => 20, 'top' => 1153],
        ['left' => 490, 'top' => 1153],
    ];

    $desktopLayout = [
        ['left' => 72, 'top' => 848],
        ['left' => 686, 'top' => 848],
        ['left' => 1299, 'top' => 848],
        ['left' => 72, 'top' => 1652],
    ];
@endphp

<section id="discover" class="lum-container relative bg-lum-ivory" data-lum-discover-page>
    {{-- MOBILE — Figma 101:617 --}}
    <div class="relative h-[2255px] tab:hidden" data-lum-stay-intro data-lum-intro-first-row="1">
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute left-1/2 top-[124px] flex w-[335px] -translate-x-1/2 flex-col items-center text-center" data-lum-stay-hero>
            <div class="flex w-full flex-col items-center gap-[16px]">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6" data-lum-stay-intro-item="dot">
                <h1 class="font-serif text-[42px] leading-[45px] text-lum-espresso" data-lum-stay-intro-item="title">
                    {{ __('lum.discover.title_normal') }}<br>
                    <span class="font-medium italic">{{ __('lum.discover.title_italic') }}</span>
                </h1>
            </div>

            <p class="mt-[16px] lum-text-3 font-medium uppercase text-lum-espresso" data-lum-stay-intro-item="eyebrow">{{ __('lum.discover.eyebrow') }}</p>

            @include('lum.partials.stay.scroll-arrow', ['img' => $img, 'variant' => 'mob', 'marginClass' => 'mt-[44px]'])
        </div>

        @foreach ($places as $index => $place)
            @php $layout = $mobileLayout[$index]; @endphp

            <div class="lum-dining-card absolute left-1/2 h-[390px] w-[335px] -translate-x-1/2 overflow-hidden" style="top: {{ $layout['top'] }}px" data-lum-stay-property-image data-lum-stay-property="{{ $index }}">
                @include('lum.partials.discover.card', [
                    'img' => $img,
                    'place' => $place,
                    'width' => 335,
                    'height' => 390,
                    'titleTop' => 24,
                    'titleClass' => 'text-[16px] leading-[20px] tracking-[-0.32px]',
                    'locationTop' => 300,
                    'regionClass' => 'text-[14px] leading-[22px] tracking-[0.1px]',
                    'pinSize' => 48,
                    'pinIconSize' => 16,
                ])
            </div>
        @endforeach
    </div>

    {{-- TABLET — Figma 101:580 --}}
    <div class="relative hidden h-[1798px] tab:block desk:hidden" data-lum-stay-intro data-lum-intro-first-row="2">
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute left-1/2 top-[160px] flex w-[423px] -translate-x-1/2 flex-col items-center text-center" data-lum-stay-hero>
            <div class="flex flex-col items-center gap-[12px]">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8" data-lum-stay-intro-item="dot">
                <h1 class="font-serif text-[52px] leading-[52px] text-lum-espresso" data-lum-stay-intro-item="title">
                    {{ __('lum.discover.title_normal') }}<br>
                    <span class="font-medium italic">{{ __('lum.discover.title_italic') }}</span>
                </h1>
            </div>

            <p class="mt-[12px] lum-text-2 font-medium uppercase text-lum-espresso" data-lum-stay-intro-item="eyebrow">{{ __('lum.discover.eyebrow') }}</p>

            @include('lum.partials.stay.scroll-arrow', ['img' => $img, 'variant' => 'tab', 'marginClass' => 'mt-[56px]'])
        </div>

        @foreach ($places as $index => $place)
            @php $layout = $tabletLayout[$index]; @endphp

            <div class="lum-dining-card absolute h-[525px] w-[450px] overflow-hidden" style="left: {{ $layout['left'] }}px; top: {{ $layout['top'] }}px" data-lum-stay-property-image data-lum-stay-property="{{ $index }}">
                @include('lum.partials.discover.card', [
                    'img' => $img,
                    'place' => $place,
                    'width' => 450,
                    'height' => 525,
                    'titleTop' => 32,
                    'titleClass' => 'text-[18px] leading-[22px] tracking-[-0.36px]',
                    'locationTop' => 405,
                    'pinSize' => 56,
                    'pinIconSize' => 20,
                ])
            </div>
        @endforeach
    </div>

    {{-- DESKTOP — Figma 101:441 --}}
    <div class="relative hidden h-[2552px] desk:block" data-lum-stay-intro data-lum-intro-first-row="3">
        @include('lum.partials.header', ['headerTone' => 'espresso', 'headerActive' => 'discover'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="absolute left-1/2 top-[292px] flex w-[856px] -translate-x-1/2 flex-col items-center text-center" data-lum-stay-hero>
            <div class="flex w-full flex-col items-center gap-[24px]">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12" data-lum-stay-intro-item="dot">
                <h1 class="font-serif text-[88px] leading-[94px] text-lum-espresso" data-lum-stay-intro-item="title">
                    {{ __('lum.discover.title_normal') }}<br>
                    <span class="font-medium italic">{{ __('lum.discover.title_italic') }}</span>
                </h1>
            </div>

            <p class="mt-[28px] lum-eyebrow uppercase text-lum-espresso" data-lum-stay-intro-item="eyebrow">{{ __('lum.discover.eyebrow') }}</p>

            @include('lum.partials.stay.scroll-arrow', ['img' => $img, 'variant' => 'desk', 'marginClass' => 'mt-[64px]'])
        </div>

        @foreach ($places as $index => $place)
            @php $layout = $desktopLayout[$index]; @endphp

            <div class="lum-dining-card absolute h-[740px] w-[549px] overflow-hidden" style="left: {{ $layout['left'] }}px; top: {{ $layout['top'] }}px" data-lum-stay-property-image data-lum-stay-property="{{ $index }}">
                @include('lum.partials.discover.card', [
                    'img' => $img,
                    'place' => $place,
                    'width' => 549,
                    'height' => 740,
                ])
            </div>
        @endforeach
    </div>
</section>
