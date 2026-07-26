@php
    use App\Support\Content;

    $items = $shopItems ?? Content::shopItemsKeyed();
    $products = collect($items)->values();
    $count = $products->count();

    $mobileCards = [];
    $top = 296;
    foreach ($products as $product) {
        $mobileCards[] = ['product' => $product, 'top' => $top];
        $h = ($product['type'] ?? 'tee') === 'tee' ? 635 : 538;
        $top += $h + 60;
    }
    $mobileHeight = max(900, $top + 80);

    $tabletCards = [];
    foreach ($products as $i => $product) {
        $tabletCards[] = [
            'product' => $product,
            'left' => $i % 2 === 0 ? 20 : 490,
            'top' => 349 + (intdiv($i, 2) * 780),
        ];
    }
    $tabletHeight = $count === 0 ? 900 : (349 + (intdiv($count - 1, 2) * 780) + 820);

    $deskLefts = [72, 532, 992, 1452];
    $desktopCards = [];
    foreach ($products as $i => $product) {
        $desktopCards[] = [
            'product' => $product,
            'left' => $deskLefts[$i % 4],
            'top' => 651 + (intdiv($i, 4) * 820),
        ];
    }
    $desktopHeight = $count === 0 ? 1100 : (651 + (intdiv($count - 1, 4) * 820) + 820);
@endphp

<section class="lum-container relative bg-lum-ivory">
    {{-- MOBILE --}}
    <div class="relative tab:hidden" style="height: {{ $mobileHeight }}px">
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute left-1/2 top-[124px] flex w-[335px] -translate-x-1/2 flex-col items-center gap-[16px]" data-lum-villa-intro>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <h1 class="text-center font-serif text-[42px] leading-[45px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                <span>{{ __('lum.shop.page_title_normal') }} </span><span class="font-medium italic">{{ __('lum.shop.page_title_italic') }}</span>
            </h1>
            @include('lum.partials.shop-page.social')
        </div>

        @foreach ($mobileCards as $card)
            <div class="absolute left-[20px] w-[335px]" style="top: {{ $card['top'] }}px" data-lum-villa-card>
                @include('lum.partials.shop-page.product-card', [
                    'img' => $img,
                    'product' => $card['product'],
                    'variant' => 'mobile',
                    'cta' => $card['product']['price'] ?? $card['product']['cta_label'] ?? __('lum.shop.cta_price'),
                ])
            </div>
        @endforeach
    </div>

    {{-- TABLET --}}
    <div class="relative hidden tab:block desk:hidden" style="height: {{ $tabletHeight }}px">
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute left-1/2 top-[160px] flex -translate-x-1/2 flex-col items-center gap-[12px]" data-lum-villa-intro>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <h1 class="whitespace-nowrap text-center font-serif text-[52px] leading-[52px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                <span>{{ __('lum.shop.page_title_normal') }} </span><span class="font-medium italic">{{ __('lum.shop.page_title_italic') }}</span>
            </h1>
            @include('lum.partials.shop-page.social')
        </div>

        @foreach ($tabletCards as $card)
            <div class="absolute w-[450px]" style="left: {{ $card['left'] }}px; top: {{ $card['top'] }}px" data-lum-villa-card>
                @include('lum.partials.shop-page.product-card', [
                    'img' => $img,
                    'product' => $card['product'],
                    'variant' => 'tablet',
                    'cta' => $card['product']['price'] ?? $card['product']['cta_label'] ?? __('lum.shop.cta_price'),
                ])
            </div>
        @endforeach
    </div>

    {{-- DESKTOP --}}
    <div class="relative hidden desk:block" style="height: {{ $desktopHeight }}px">
        @include('lum.partials.header', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="absolute left-1/2 top-[292px] flex w-[856px] -translate-x-1/2 flex-col items-center gap-[24px]" data-lum-villa-intro>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <h1 class="w-full text-center font-serif text-[88px] leading-[94px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                <span>{{ __('lum.shop.page_title_normal') }} </span><span class="font-medium italic">{{ __('lum.shop.page_title_italic') }}</span>
            </h1>
            @include('lum.partials.shop-page.social')
        </div>

        @foreach ($desktopCards as $card)
            <div class="absolute" style="left: {{ $card['left'] }}px; top: {{ $card['top'] }}px" data-lum-villa-card>
                @include('lum.partials.shop-page.product-card', [
                    'img' => $img,
                    'product' => $card['product'],
                    'variant' => 'desktop',
                    'cta' => $card['product']['price'] ?? $card['product']['cta_label'] ?? __('lum.shop.cta_price'),
                ])
            </div>
        @endforeach
    </div>
</section>
