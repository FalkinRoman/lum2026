@php
    $menuCategories = collect($menuCategories ?? []);
    $categories = $menuCategories->map(fn ($c) => [
        'key' => $c['key'],
        'label' => $c['label'],
    ])->values()->all();
    $items = $menuCategories->mapWithKeys(fn ($c) => [$c['key'] => $c['items']])->all();

    $menuCopy = $restaurant['menu'] ?? [];
    $menu = [
        'eyebrow' => $menuCopy['eyebrow'] ?? __('lum.restaurant.menu_eyebrow'),
        'title_normal' => $menuCopy['title_normal'] ?? __('lum.restaurant.menu_title_normal'),
        'title_italic' => $menuCopy['title_italic'] ?? __('lum.restaurant.menu_title_italic'),
        'categories' => $categories,
        'items' => $items,
    ];

    $arrowLeft = $img('ui/carousel-arrow-left.svg');
    $arrowRight = $img('ui/carousel-arrow-right.svg');
    $paginationLabel = __('lum.restaurant.menu_pagination_label');
    $paginationPrev = __('lum.restaurant.menu_pagination_prev');
    $paginationNext = __('lum.restaurant.menu_pagination_next');
@endphp

<section
    class="lum-container relative bg-lum-ivory"
    data-lum-restaurant-menu
    data-arrow-left="{{ $arrowLeft }}"
    data-arrow-right="{{ $arrowRight }}"
    data-pagination-label="{{ $paginationLabel }}"
    data-pagination-prev="{{ $paginationPrev }}"
    data-pagination-next="{{ $paginationNext }}"
>
    {{-- MOBILE: flow-layout — высота = контент (1 или 2 карточки) + пагинация --}}
    <div class="relative px-[20px] pb-[56px] pt-[44px] tab:hidden" data-lum-menu-layout data-per-page="2" data-lum-menu-flow>
        <p class="lum-script whitespace-nowrap text-center text-[24px] leading-none tracking-[1.2px] text-lum-espresso">{{ $menu['eyebrow'] }}</p>
        <h2 class="mx-auto mt-[36px] w-full max-w-[335px] text-center font-serif text-[42px] leading-[45px] text-lum-espresso">
            {{ $menu['title_normal'] }}<span class="font-medium italic">{{ $menu['title_italic'] }}</span>
        </h2>

        <div class="mt-[32px] flex w-full flex-wrap items-center justify-center gap-[8px]" data-lum-menu-tabs>
            @foreach ($categories as $index => $category)
                <button type="button" @class(['lum-tab lum-tab--s', 'lum-tab--active' => $index === 0, 'lum-tab--inactive' => $index !== 0]) data-lum-menu-tab data-category="{{ $category['key'] }}">@if ($index === 0)✓@endif{{ $category['label'] }}</button>
            @endforeach
        </div>

        <div class="mx-auto mt-[40px] flex w-full max-w-[335px] flex-col gap-[40px]" data-lum-menu-grid>
            @foreach ($categories as $index => $category)
                @foreach ($items[$category['key']] ?? [] as $itemIndex => $item)
                    <div
                        @class(['hidden' => $index !== 0 || $itemIndex >= 2])
                        data-lum-menu-panel
                        data-category="{{ $category['key'] }}"
                        data-index="{{ $itemIndex }}"
                    >
                        @include('lum.partials.restaurant.menu-card', ['img' => $img, 'item' => $item, 'variant' => 'mob'])
                    </div>
                @endforeach
            @endforeach
        </div>

        <nav
            class="lum-blog-pagination lum-menu-pagination mx-auto mt-[40px]"
            data-lum-menu-pagination
            aria-label="{{ $paginationLabel }}"
            hidden
        ></nav>
    </div>

    {{-- TABLET: 2×2 + flow-пагинация под сеткой (без гигантской пустоты) --}}
    <div class="relative hidden px-[19px] pb-[72px] pt-[80px] tab:block desk:hidden" data-lum-menu-layout data-per-page="4" data-lum-menu-flow>
        <p class="lum-script whitespace-nowrap text-center text-[28px] leading-none tracking-[1.4px] text-lum-espresso">{{ $menu['eyebrow'] }}</p>
        <h2 class="mt-[44px] whitespace-nowrap text-center font-serif text-[52px] leading-[52px] text-lum-espresso">
            {{ $menu['title_normal'] }}<span class="font-medium italic">{{ $menu['title_italic'] }}</span>
        </h2>

        <div class="mt-[32px] flex flex-wrap items-center justify-center gap-[10px]" data-lum-menu-tabs>
            @foreach ($categories as $index => $category)
                <button type="button" @class(['lum-tab lum-tab--s', 'lum-tab--active' => $index === 0, 'lum-tab--inactive' => $index !== 0]) data-lum-menu-tab data-category="{{ $category['key'] }}">@if ($index === 0)✓@endif{{ $category['label'] }}</button>
            @endforeach
        </div>

        <div class="mx-auto mt-[40px] grid w-full max-w-[922px] grid-cols-2 gap-x-[18px] gap-y-[40px]" data-lum-menu-grid>
            @foreach ($categories as $index => $category)
                @foreach ($items[$category['key']] ?? [] as $itemIndex => $item)
                    <div
                        @class(['hidden' => $index !== 0 || $itemIndex >= 4])
                        data-lum-menu-panel
                        data-category="{{ $category['key'] }}"
                        data-index="{{ $itemIndex }}"
                    >
                        @include('lum.partials.restaurant.menu-card', ['img' => $img, 'item' => $item, 'variant' => 'tab'])
                    </div>
                @endforeach
            @endforeach
        </div>

        <nav
            class="lum-blog-pagination lum-menu-pagination mx-auto mt-[48px]"
            data-lum-menu-pagination
            aria-label="{{ $paginationLabel }}"
            hidden
        ></nav>
    </div>

    {{-- DESKTOP: 2×2 flow --}}
    <div class="relative hidden px-[72px] pb-[72px] pt-[120px] desk:block" data-lum-menu-layout data-per-page="4" data-lum-menu-flow>
        <p class="lum-script whitespace-nowrap text-center text-[28px] leading-none tracking-[1.4px] text-lum-espresso">{{ $menu['eyebrow'] }}</p>
        <h2 class="mx-auto mt-[44px] w-full max-w-[856px] text-center font-serif text-[88px] leading-[94px] text-lum-espresso">
            {{ $menu['title_normal'] }}<span class="font-medium italic">{{ $menu['title_italic'] }}</span>
        </h2>

        <div class="mt-[44px] flex items-center justify-center gap-[10px]" data-lum-menu-tabs>
            @foreach ($categories as $index => $category)
                <button type="button" @class(['lum-tab lum-tab--l', 'lum-tab--active' => $index === 0, 'lum-tab--inactive' => $index !== 0]) data-lum-menu-tab data-category="{{ $category['key'] }}">@if ($index === 0)✓@endif{{ $category['label'] }}</button>
            @endforeach
        </div>

        <div class="mx-auto mt-[76px] grid w-full max-w-[1776px] grid-cols-2 gap-x-[64px] gap-y-[44px]" data-lum-menu-grid>
            @foreach ($categories as $index => $category)
                @foreach ($items[$category['key']] ?? [] as $itemIndex => $item)
                    <div
                        @class(['hidden' => $index !== 0 || $itemIndex >= 4])
                        data-lum-menu-panel
                        data-category="{{ $category['key'] }}"
                        data-index="{{ $itemIndex }}"
                    >
                        @include('lum.partials.restaurant.menu-card', ['img' => $img, 'item' => $item, 'variant' => 'desk'])
                    </div>
                @endforeach
            @endforeach
        </div>

        <nav
            class="lum-blog-pagination lum-menu-pagination mx-auto mt-[48px]"
            data-lum-menu-pagination
            aria-label="{{ $paginationLabel }}"
            hidden
        ></nav>
    </div>
</section>
