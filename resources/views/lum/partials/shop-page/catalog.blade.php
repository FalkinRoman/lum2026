@php
    $products = trans('lum.shop.products');

    $mobileLayout = [
        ['top' => 235],
        ['top' => 930],
    ];

    $tabletLayout = [
        ['left' => 20, 'top' => 312],
        ['left' => 490, 'top' => 992],
    ];

    $desktopLayout = [
        ['left' => 72, 'top' => 542],
        ['left' => 992, 'top' => 542],
    ];
@endphp

<section class="lum-container relative bg-lum-ivory">
    {{-- MOBILE — Figma 108:754 --}}
    <div class="relative h-[2841px] tab:hidden">
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute inset-0" data-lum-villa-intro>
            <h1 class="absolute left-1/2 top-[146px] w-[335px] -translate-x-1/2 text-center font-serif text-[42px] leading-[45px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="1">{{ __('lum.shop.page_title') }}</h1>
        </div>

        @foreach ($products as $index => $product)
            @php $layout = $mobileLayout[$index]; @endphp
            <div class="absolute left-[20px] w-[335px]" style="top: {{ $layout['top'] }}px" data-lum-villa-card>
                @include('lum.partials.shop-page.product-card', ['img' => $img, 'product' => $product, 'variant' => 'mobile'])
            </div>
        @endforeach
    </div>

    {{-- TABLET — Figma 108:576 --}}
    <div class="relative hidden h-[1812px] tab:block desk:hidden">
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])

        <div class="absolute inset-0" data-lum-villa-intro>
            <h1 class="absolute left-1/2 top-[180px] -translate-x-1/2 whitespace-nowrap text-center font-serif text-[52px] leading-[52px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="1">{{ __('lum.shop.page_title') }}</h1>
        </div>

        @foreach ($products as $index => $product)
            @php $layout = $tabletLayout[$index]; @endphp
            <div class="absolute w-[450px]" style="left: {{ $layout['left'] }}px; top: {{ $layout['top'] }}px" data-lum-villa-card>
                @include('lum.partials.shop-page.product-card', ['img' => $img, 'product' => $product, 'variant' => 'tablet'])
            </div>
        @endforeach
    </div>

    {{-- DESKTOP — Figma 108:441 --}}
    <div class="relative hidden h-[1402px] desk:block">
        @include('lum.partials.header', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="absolute inset-0" data-lum-villa-intro>
            <h1 class="absolute left-1/2 top-[328px] w-[856px] -translate-x-1/2 text-center font-serif text-[88px] leading-[94px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="1">{{ __('lum.shop.page_title') }}</h1>
        </div>

        @foreach ($products as $index => $product)
            @php $layout = $desktopLayout[$index]; @endphp
            <div class="absolute" style="left: {{ $layout['left'] }}px; top: {{ $layout['top'] }}px" data-lum-villa-card>
                @include('lum.partials.shop-page.product-card', ['img' => $img, 'product' => $product, 'variant' => 'desktop'])
            </div>
        @endforeach
    </div>
</section>
