@php
    $menu = $restaurant['menu'] ?? [
        'eyebrow' => __('lum.restaurant.menu_eyebrow'),
        'title_normal' => __('lum.restaurant.menu_title_normal'),
        'title_italic' => __('lum.restaurant.menu_title_italic'),
        'categories' => trans('lum.restaurant.menu_categories'),
        'items' => trans('lum.restaurant.menu_items'),
    ];
    $categories = $menu['categories'];
    $items = $menu['items'];
@endphp

<section class="lum-container relative bg-lum-ivory" data-lum-restaurant-menu>
    {{-- MOBILE --}}
    <div class="relative h-[1415px] tab:hidden">
        <p class="lum-script absolute left-1/2 top-[44px] -translate-x-1/2 whitespace-nowrap text-center text-[24px] leading-none tracking-[1.2px] text-lum-espresso">{{ $menu['eyebrow'] }}</p>
        <h2 class="absolute left-1/2 top-[104px] w-[335px] -translate-x-1/2 text-center font-serif text-[42px] leading-[45px] text-lum-espresso">
            {{ $menu['title_normal'] }}<span class="font-medium italic">{{ $menu['title_italic'] }}</span>
        </h2>

        <div class="absolute left-[20px] top-[181px] flex w-[335px] flex-wrap items-center justify-center gap-[8px]" data-lum-menu-tabs>
            @foreach ($categories as $index => $category)
                <button type="button" @class(['lum-tab lum-tab--s', 'lum-tab--active' => $index === 0, 'lum-tab--inactive' => $index !== 0]) data-lum-menu-tab data-category="{{ $category['key'] }}">@if ($index === 0)✓@endif{{ $category['label'] }}</button>
            @endforeach
        </div>

        <div class="absolute left-[20px] top-[287px] flex w-[335px] flex-col gap-[40px]">
            @foreach ($categories as $index => $category)
                @foreach ($items[$category['key']] ?? [] as $item)
                    <div @class(['hidden' => $index !== 0]) data-lum-menu-panel data-category="{{ $category['key'] }}">
                        @include('lum.partials.restaurant.menu-card', ['img' => $img, 'item' => $item, 'variant' => 'mob'])
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    {{-- TABLET --}}
    <div class="relative hidden h-[1652px] tab:block desk:hidden">
        <p class="lum-script absolute left-1/2 top-[80px] -translate-x-1/2 whitespace-nowrap text-center text-[28px] leading-none tracking-[1.4px] text-lum-espresso">{{ $menu['eyebrow'] }}</p>
        <h2 class="absolute left-1/2 top-[152px] -translate-x-1/2 whitespace-nowrap text-center font-serif text-[52px] leading-[52px] text-lum-espresso">
            {{ $menu['title_normal'] }}<span class="font-medium italic">{{ $menu['title_italic'] }}</span>
        </h2>

        <div class="absolute left-1/2 top-[236px] flex -translate-x-1/2 flex-wrap items-center justify-center gap-[10px]" data-lum-menu-tabs>
            @foreach ($categories as $index => $category)
                <button type="button" @class(['lum-tab lum-tab--s', 'lum-tab--active' => $index === 0, 'lum-tab--inactive' => $index !== 0]) data-lum-menu-tab data-category="{{ $category['key'] }}">@if ($index === 0)✓@endif{{ $category['label'] }}</button>
            @endforeach
        </div>

        <div class="absolute left-[19px] top-[332px] grid w-[922px] grid-cols-2 gap-x-[18px] gap-y-[40px]">
            @foreach ($categories as $index => $category)
                @foreach ($items[$category['key']] ?? [] as $item)
                    <div @class(['hidden' => $index !== 0]) data-lum-menu-panel data-category="{{ $category['key'] }}">
                        @include('lum.partials.restaurant.menu-card', ['img' => $img, 'item' => $item, 'variant' => 'tab'])
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    {{-- DESKTOP --}}
    <div class="relative hidden h-[1174px] desk:block">
        <p class="lum-script absolute left-1/2 top-[120px] -translate-x-1/2 whitespace-nowrap text-center text-[28px] leading-none tracking-[1.4px] text-lum-espresso">{{ $menu['eyebrow'] }}</p>
        <h2 class="absolute left-1/2 top-[192px] w-[856px] -translate-x-1/2 text-center font-serif text-[88px] leading-[94px] text-lum-espresso">
            {{ $menu['title_normal'] }}<span class="font-medium italic">{{ $menu['title_italic'] }}</span>
        </h2>

        <div class="absolute left-1/2 top-[330px] flex -translate-x-1/2 items-center gap-[10px]" data-lum-menu-tabs>
            @foreach ($categories as $index => $category)
                <button type="button" @class(['lum-tab lum-tab--l', 'lum-tab--active' => $index === 0, 'lum-tab--inactive' => $index !== 0]) data-lum-menu-tab data-category="{{ $category['key'] }}">@if ($index === 0)✓@endif{{ $category['label'] }}</button>
            @endforeach
        </div>

        <div class="absolute left-[72px] top-[450px] grid w-[1776px] grid-cols-2 gap-x-[64px] gap-y-[44px]">
            @foreach ($categories as $index => $category)
                @foreach ($items[$category['key']] ?? [] as $item)
                    <div @class(['hidden' => $index !== 0]) data-lum-menu-panel data-category="{{ $category['key'] }}">
                        @include('lum.partials.restaurant.menu-card', ['img' => $img, 'item' => $item, 'variant' => 'desk'])
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</section>
