@php
    $venues = trans('lum.dining.venues');

    $mobileLayout = [
        ['top' => 495],
        ['top' => 925],
        ['top' => 1355],
        ['top' => 1785],
    ];

    $tabletLayout = [
        ['left' => 20, 'top' => 615],
        ['left' => 490, 'top' => 615],
        ['left' => 20, 'top' => 1180],
        ['left' => 490, 'top' => 1180],
    ];

    $desktopLayout = [
        ['left' => 72, 'top' => 894],
        ['left' => 686, 'top' => 894],
        ['left' => 1299, 'top' => 894],
        ['left' => 72, 'top' => 1698],
    ];
@endphp

<section id="dining" class="lum-container relative bg-lum-ivory" data-lum-dining-page>
    {{-- MOBILE — Figma 91:496 --}}
    <div class="relative h-[2295px] tab:hidden" data-lum-stay-intro data-lum-intro-first-row="1">
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute left-1/2 top-[124px] flex w-[335px] -translate-x-1/2 flex-col items-center text-center" data-lum-stay-hero>
            <div class="flex w-full flex-col items-center gap-[16px]">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6" data-lum-stay-intro-item="dot">
                <h1 class="font-serif text-[42px] leading-[45px] text-lum-espresso" data-lum-stay-intro-item="title">
                    {{ __('lum.dining.title_line1') }}<br>
                    {{ __('lum.dining.title_line2') }}<br>
                    <span class="font-medium italic">{{ __('lum.dining.title_italic') }}</span>
                </h1>
            </div>

            <p class="mt-[16px] lum-text-3 font-medium uppercase text-lum-espresso" data-lum-stay-intro-item="eyebrow">{{ __('lum.dining.eyebrow') }}</p>

            @include('lum.partials.stay.scroll-arrow', ['img' => $img, 'variant' => 'mob', 'marginClass' => 'mt-[44px]'])
        </div>

        @foreach ($venues as $index => $venue)
            @php $layout = $mobileLayout[$index]; @endphp

            <div class="lum-dining-card absolute left-1/2 h-[390px] w-[335px] -translate-x-1/2 overflow-hidden" style="top: {{ $layout['top'] }}px" data-lum-stay-property-image data-lum-stay-property="{{ $index }}">
                @include('lum.partials.dining.card', [
                    'img' => $img,
                    'venue' => $venue,
                    'width' => 335,
                    'height' => 390,
                    'eyebrowTop' => 24,
                    'eyebrowClass' => 'lum-text-3 leading-[14px] tracking-[0.6px]',
                    'subtitleClass' => 'text-[14px] leading-[22px] tracking-[0.1px]',
                    'titleClass' => 'font-serif text-[22px] leading-[24px] tracking-[0.19px]',
                    'titleTop' => 177,
                    'ctaTop' => 326,
                ])
            </div>
        @endforeach
    </div>

    {{-- TABLET — Figma 91:438 --}}
    <div class="relative hidden h-[1825px] tab:block desk:hidden" data-lum-stay-intro data-lum-intro-first-row="2">
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute left-1/2 top-[160px] flex w-[464px] -translate-x-1/2 flex-col items-center text-center" data-lum-stay-hero>
            <div class="flex flex-col items-center gap-[12px]">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8" data-lum-stay-intro-item="dot">
                <h1 class="font-serif text-[52px] leading-[52px] text-lum-espresso" data-lum-stay-intro-item="title">
                    {{ __('lum.dining.title_line1') }}<br>
                    {{ __('lum.dining.title_line2') }}<br>
                    <span class="font-medium italic">{{ __('lum.dining.title_italic') }}</span>
                </h1>
            </div>

            <p class="mt-[12px] lum-text-2 font-medium uppercase text-lum-espresso" data-lum-stay-intro-item="eyebrow">{{ __('lum.dining.eyebrow') }}</p>

            @include('lum.partials.stay.scroll-arrow', ['img' => $img, 'variant' => 'tab', 'marginClass' => 'mt-[56px]'])
        </div>

        @foreach ($venues as $index => $venue)
            @php $layout = $tabletLayout[$index]; @endphp

            <div class="lum-dining-card absolute h-[525px] w-[450px] overflow-hidden" style="left: {{ $layout['left'] }}px; top: {{ $layout['top'] }}px" data-lum-stay-property-image data-lum-stay-property="{{ $index }}">
                @include('lum.partials.dining.card', [
                    'img' => $img,
                    'venue' => $venue,
                    'width' => 450,
                    'height' => 525,
                    'eyebrowTop' => 32,
                    'eyebrowClass' => 'text-[14px] leading-[14px] tracking-[0.6px]',
                    'subtitleClass' => 'text-[14px] leading-[22px] tracking-[0.1px]',
                    'titleClass' => 'font-serif text-[28px] leading-[34px] tracking-[0.36px]',
                    'titleTop' => 245,
                    'ctaTop' => 461,
                ])
            </div>
        @endforeach
    </div>

    {{-- DESKTOP — Figma 91:373 --}}
    <div class="relative hidden h-[2598px] desk:block" data-lum-stay-intro data-lum-intro-first-row="3">
        @include('lum.partials.header', ['headerTone' => 'espresso', 'headerActive' => 'dining'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="absolute left-1/2 top-[292px] flex w-[856px] -translate-x-1/2 flex-col items-center text-center" data-lum-stay-hero>
            <div class="flex w-full flex-col items-center gap-[24px]">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12" data-lum-stay-intro-item="dot">
                <h1 class="font-serif text-[88px] leading-[94px] text-lum-espresso" data-lum-stay-intro-item="title">
                    {{ __('lum.dining.title_line1') }}<br>
                    {{ __('lum.dining.title_line2') }}<br>
                    <span class="font-medium italic">{{ __('lum.dining.title_italic') }}</span>
                </h1>
            </div>

            <p class="mt-[28px] lum-eyebrow uppercase text-lum-espresso" data-lum-stay-intro-item="eyebrow">{{ __('lum.dining.eyebrow') }}</p>

            @include('lum.partials.stay.scroll-arrow', ['img' => $img, 'variant' => 'desk', 'marginClass' => 'mt-[64px]'])
        </div>

        @foreach ($venues as $index => $venue)
            @php $layout = $desktopLayout[$index]; @endphp

            <div class="lum-dining-card absolute h-[740px] w-[549px] overflow-hidden" style="left: {{ $layout['left'] }}px; top: {{ $layout['top'] }}px" data-lum-stay-property-image data-lum-stay-property="{{ $index }}">
                @include('lum.partials.dining.card', [
                    'img' => $img,
                    'venue' => $venue,
                    'width' => 549,
                    'height' => 740,
                    'eyebrowTop' => 44,
                    'eyebrowClass' => 'lum-text-2 tracking-[0.16px]',
                    'subtitleClass' => 'lum-text-2 tracking-[0.16px]',
                    'titleClass' => 'font-serif text-[32px] leading-[36px] tracking-[0.32px]',
                    'titleTop' => 348,
                    'ctaTop' => 660,
                ])
            </div>
        @endforeach
    </div>
</section>
