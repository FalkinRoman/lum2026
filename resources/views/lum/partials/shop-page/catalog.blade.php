@php
    $items = trans('lum.shop.items');

    $mobileCards = [
        ['slug' => 'ocean-tee', 'top' => 235, 'cta' => __('lum.shop.cta_price')],
        ['slug' => 'lum-cup', 'top' => 930],
        ['slug' => 'ocean-tee', 'top' => 1528, 'cta' => __('lum.shop.cta_price')],
        ['slug' => 'lum-cup', 'top' => 2223],
    ];

    $tabletCards = [
        ['slug' => 'ocean-tee', 'left' => 20, 'top' => 312, 'cta' => __('lum.shop.cta_price')],
        ['slug' => 'lum-cup', 'left' => 490, 'top' => 312],
        ['slug' => 'ocean-tee', 'left' => 490, 'top' => 992, 'cta' => __('lum.shop.cta_reservation')],
        ['slug' => 'lum-cup', 'left' => 20, 'top' => 1092],
    ];

    $desktopCards = [
        ['slug' => 'ocean-tee', 'left' => 72, 'top' => 542, 'cta' => __('lum.shop.cta_price')],
        ['slug' => 'lum-cup', 'left' => 532, 'top' => 542],
        ['slug' => 'ocean-tee', 'left' => 992, 'top' => 542, 'cta' => __('lum.shop.cta_reservation')],
        ['slug' => 'lum-cup', 'left' => 1452, 'top' => 542],
    ];
@endphp

<section class="lum-container relative bg-lum-ivory">
    {{-- MOBILE — Figma 108:754 --}}
    <div class="relative h-[2841px] tab:hidden">
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute left-1/2 top-[124px] flex w-[335px] -translate-x-1/2 flex-col items-center gap-[16px]" data-lum-villa-intro>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <h1 class="text-center font-serif text-[42px] leading-[45px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                <span>{{ __('lum.shop.page_title_normal') }} </span><span class="font-medium italic">{{ __('lum.shop.page_title_italic') }}</span>
            </h1>
        </div>

        @foreach ($mobileCards as $card)
            @php
                $product = $items[$card['slug']];
                $cta = $card['cta'] ?? __('lum.shop.cta_reservation');
            @endphp
            <div class="absolute left-[20px] w-[335px]" style="top: {{ $card['top'] }}px" data-lum-villa-card>
                @include('lum.partials.shop-page.product-card', [
                    'img' => $img,
                    'product' => $product,
                    'variant' => 'mobile',
                    'cta' => $cta,
                ])
            </div>
        @endforeach
    </div>

    {{-- TABLET — Figma 108:576 --}}
    <div class="relative hidden h-[1812px] tab:block desk:hidden">
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute left-1/2 top-[160px] flex -translate-x-1/2 flex-col items-center gap-[12px]" data-lum-villa-intro>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <h1 class="whitespace-nowrap text-center font-serif text-[52px] leading-[52px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                <span>{{ __('lum.shop.page_title_normal') }} </span><span class="font-medium italic">{{ __('lum.shop.page_title_italic') }}</span>
            </h1>
        </div>

        @foreach ($tabletCards as $card)
            @php
                $product = $items[$card['slug']];
                $cta = $card['cta'] ?? __('lum.shop.cta_reservation');
            @endphp
            <div class="absolute w-[450px]" style="left: {{ $card['left'] }}px; top: {{ $card['top'] }}px" data-lum-villa-card>
                @include('lum.partials.shop-page.product-card', [
                    'img' => $img,
                    'product' => $product,
                    'variant' => 'tablet',
                    'cta' => $cta,
                ])
            </div>
        @endforeach
    </div>

    {{-- DESKTOP — Figma 108:441 --}}
    <div class="relative hidden h-[1402px] desk:block">
        @include('lum.partials.header', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="absolute left-1/2 top-[292px] flex w-[856px] -translate-x-1/2 flex-col items-center gap-[24px]" data-lum-villa-intro>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <h1 class="w-full text-center font-serif text-[88px] leading-[94px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                <span>{{ __('lum.shop.page_title_normal') }} </span><span class="font-medium italic">{{ __('lum.shop.page_title_italic') }}</span>
            </h1>
        </div>

        @foreach ($desktopCards as $card)
            @php
                $product = $items[$card['slug']];
                $cta = $card['cta'] ?? __('lum.shop.cta_reservation');
            @endphp
            <div class="absolute" style="left: {{ $card['left'] }}px; top: {{ $card['top'] }}px" data-lum-villa-card>
                @include('lum.partials.shop-page.product-card', [
                    'img' => $img,
                    'product' => $product,
                    'variant' => 'desktop',
                    'cta' => $cta,
                ])
            </div>
        @endforeach
    </div>
</section>
