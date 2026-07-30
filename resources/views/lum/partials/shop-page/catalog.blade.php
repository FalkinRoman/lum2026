@php
    use App\Support\Content;

    $items = $shopItems ?? Content::shopItemsKeyed();
    $products = collect($items)->values();
    $count = $products->count();

    $arrowLeft = $img('ui/carousel-arrow-left.svg');
    $arrowRight = $img('ui/carousel-arrow-right.svg');
    $paginationLabel = __('lum.shop.pagination_label');
    $paginationPrev = __('lum.shop.pagination_prev');
    $paginationNext = __('lum.shop.pagination_next');

    $cardHeight = static fn (array $product, string $bp): int => match ($bp) {
        'mobile' => (($product['type'] ?? 'tee') === 'tee') ? 635 : 538,
        'tablet' => (($product['type'] ?? 'tee') === 'tee') ? 700 : 600,
        default => (($product['type'] ?? 'tee') === 'tee') ? 700 : 604,
    };

    $layoutPages = static function (
        \Illuminate\Support\Collection $products,
        int $perPage,
        int $startTop,
        int $rowStride,
        int $bottomPad,
        string $bp,
        callable $cardHeight,
        ?array $deskLefts = null,
    ): array {
        $pages = [];
        $chunks = $products->values()->chunk($perPage);
        if ($chunks->isEmpty()) {
            return [[
                'cards' => [],
                'height' => max(900, $startTop + $bottomPad),
            ]];
        }

        foreach ($chunks as $pageProducts) {
            $cards = [];
            $top = $startTop;
            $i = 0;
            foreach ($pageProducts as $product) {
                if ($bp === 'mobile') {
                    $cards[] = [
                        'product' => $product,
                        'left' => 20,
                        'top' => $top,
                    ];
                    $h = $cardHeight($product, $bp);
                    $isLast = $i === $pageProducts->count() - 1;
                    $top += $h + ($isLast ? 0 : 60);
                    $i++;
                } elseif ($bp === 'tablet') {
                    $cards[] = [
                        'product' => $product,
                        'left' => $i % 2 === 0 ? 20 : 490,
                        'top' => $startTop + (intdiv($i, 2) * $rowStride),
                    ];
                    $i++;
                } else {
                    $lefts = $deskLefts ?? [72, 532, 992, 1452];
                    $cards[] = [
                        'product' => $product,
                        'left' => $lefts[$i % 4],
                        'top' => $startTop + (intdiv($i, 4) * $rowStride),
                    ];
                    $i++;
                }
            }

            if ($bp === 'mobile') {
                $height = max(900, $top + $bottomPad);
            } else {
                $n = $pageProducts->count();
                $cols = $bp === 'tablet' ? 2 : 4;
                $rows = max(1, (int) ceil($n / $cols));
                $height = $startTop + (($rows - 1) * $rowStride) + 820;
            }

            // Room for absolute pagination under the grid when >1 page
            if ($chunks->count() > 1) {
                $height += $bp === 'mobile' ? 72 : 96;
            }

            $pages[] = [
                'cards' => $cards,
                'height' => $height,
            ];
        }

        return $pages;
    };

    $mobilePages = $layoutPages($products, 2, 296, 0, 80, 'mobile', $cardHeight);
    $tabletPages = $layoutPages($products, 4, 349, 780, 0, 'tablet', $cardHeight);
    $desktopPages = $layoutPages($products, 4, 651, 820, 0, 'desktop', $cardHeight, [72, 532, 992, 1452]);

    $mobileHeights = collect($mobilePages)->pluck('height')->implode(',');
    $tabletHeights = collect($tabletPages)->pluck('height')->implode(',');
    $desktopHeights = collect($desktopPages)->pluck('height')->implode(',');
@endphp

<section
    class="lum-container relative bg-lum-ivory"
    data-lum-shop-catalog
    data-arrow-left="{{ $arrowLeft }}"
    data-arrow-right="{{ $arrowRight }}"
    data-pagination-prev="{{ $paginationPrev }}"
    data-pagination-next="{{ $paginationNext }}"
>
    {{-- MOBILE — Figma absolute; 2 / page --}}
    <div
        class="relative tab:hidden"
        style="height: {{ $mobilePages[0]['height'] }}px"
        data-lum-shop-layout
        data-per-page="2"
        data-page-heights="{{ $mobileHeights }}"
    >
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute left-1/2 top-[124px] z-[1] flex w-[335px] -translate-x-1/2 flex-col items-center gap-[16px]" data-lum-villa-intro>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <h1 class="text-center font-serif text-[42px] leading-[45px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                <span>{{ __('lum.shop.page_title_normal') }} </span><span class="font-medium italic">{{ __('lum.shop.page_title_italic') }}</span>
            </h1>
            @include('lum.partials.shop-page.social')
        </div>

        @foreach ($mobilePages as $pageIndex => $page)
            @foreach ($page['cards'] as $slot => $card)
                @php $globalIndex = ($pageIndex * 2) + $slot; @endphp
                <div
                    class="absolute left-[20px] w-[335px] {{ $pageIndex === 0 ? '' : 'hidden' }}"
                    style="top: {{ $card['top'] }}px"
                    data-lum-shop-panel
                    data-index="{{ $globalIndex }}"
                    data-page="{{ $pageIndex }}"
                    data-lum-villa-card
                >
                    @include('lum.partials.shop-page.product-card', [
                        'img' => $img,
                        'product' => $card['product'],
                        'variant' => 'mobile',
                        'cta' => $card['product']['cta_label'] ?? $card['product']['price'] ?? __('lum.shop.cta_price'),
                    ])
                </div>
            @endforeach
        @endforeach

        <nav
            class="lum-blog-pagination lum-shop-pagination absolute bottom-[24px] left-1/2 z-[2] -translate-x-1/2"
            data-lum-shop-pagination
            aria-label="{{ $paginationLabel }}"
            @if ($count <= 2) hidden aria-hidden="true" @endif
        ></nav>
    </div>

    {{-- TABLET — 2×2 / page --}}
    <div
        class="relative hidden tab:block desk:hidden"
        style="height: {{ $tabletPages[0]['height'] }}px"
        data-lum-shop-layout
        data-per-page="4"
        data-page-heights="{{ $tabletHeights }}"
    >
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute left-1/2 top-[160px] z-[1] flex -translate-x-1/2 flex-col items-center gap-[12px]" data-lum-villa-intro>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <h1 class="whitespace-nowrap text-center font-serif text-[52px] leading-[52px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                <span>{{ __('lum.shop.page_title_normal') }} </span><span class="font-medium italic">{{ __('lum.shop.page_title_italic') }}</span>
            </h1>
            @include('lum.partials.shop-page.social')
        </div>

        @foreach ($tabletPages as $pageIndex => $page)
            @foreach ($page['cards'] as $slot => $card)
                @php $globalIndex = ($pageIndex * 4) + $slot; @endphp
                <div
                    class="absolute w-[450px] {{ $pageIndex === 0 ? '' : 'hidden' }}"
                    style="left: {{ $card['left'] }}px; top: {{ $card['top'] }}px"
                    data-lum-shop-panel
                    data-index="{{ $globalIndex }}"
                    data-page="{{ $pageIndex }}"
                    data-lum-villa-card
                >
                    @include('lum.partials.shop-page.product-card', [
                        'img' => $img,
                        'product' => $card['product'],
                        'variant' => 'tablet',
                        'cta' => $card['product']['cta_label'] ?? $card['product']['price'] ?? __('lum.shop.cta_price'),
                    ])
                </div>
            @endforeach
        @endforeach

        <nav
            class="lum-blog-pagination lum-shop-pagination absolute bottom-[32px] left-1/2 z-[2] -translate-x-1/2"
            data-lum-shop-pagination
            aria-label="{{ $paginationLabel }}"
            @if ($count <= 4) hidden aria-hidden="true" @endif
        ></nav>
    </div>

    {{-- DESKTOP — 4 / page --}}
    <div
        class="relative hidden desk:block"
        style="height: {{ $desktopPages[0]['height'] }}px"
        data-lum-shop-layout
        data-per-page="4"
        data-page-heights="{{ $desktopHeights }}"
    >
        @include('lum.partials.header', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="absolute left-1/2 top-[292px] z-[1] flex w-[856px] -translate-x-1/2 flex-col items-center gap-[24px]" data-lum-villa-intro>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <h1 class="w-full text-center font-serif text-[88px] leading-[94px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                <span>{{ __('lum.shop.page_title_normal') }} </span><span class="font-medium italic">{{ __('lum.shop.page_title_italic') }}</span>
            </h1>
            @include('lum.partials.shop-page.social')
        </div>

        @foreach ($desktopPages as $pageIndex => $page)
            @foreach ($page['cards'] as $slot => $card)
                @php $globalIndex = ($pageIndex * 4) + $slot; @endphp
                <div
                    class="absolute {{ $pageIndex === 0 ? '' : 'hidden' }}"
                    style="left: {{ $card['left'] }}px; top: {{ $card['top'] }}px"
                    data-lum-shop-panel
                    data-index="{{ $globalIndex }}"
                    data-page="{{ $pageIndex }}"
                    data-lum-villa-card
                >
                    @include('lum.partials.shop-page.product-card', [
                        'img' => $img,
                        'product' => $card['product'],
                        'variant' => 'desktop',
                        'cta' => $card['product']['cta_label'] ?? $card['product']['price'] ?? __('lum.shop.cta_price'),
                    ])
                </div>
            @endforeach
        @endforeach

        <nav
            class="lum-blog-pagination lum-shop-pagination absolute bottom-[40px] left-1/2 z-[2] -translate-x-1/2"
            data-lum-shop-pagination
            aria-label="{{ $paginationLabel }}"
            @if ($count <= 4) hidden aria-hidden="true" @endif
        ></nav>
    </div>
</section>
