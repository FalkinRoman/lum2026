@php
    $posts = trans('lum.blog.posts');
    $tabs = trans('lum.blog.tabs');
    $tabKeys = ['all', 'food', 'ocean', 'lifestyle'];

    $mobileLayout = [
        ['top' => 341],
        ['top' => 801],
        ['top' => 1261],
    ];

    $tabletLayout = [
        ['top' => 356],
        ['top' => 696],
        ['top' => 1036],
    ];

    $desktopLayout = [
        ['left' => 225, 'top' => 595],
        ['left' => 992, 'top' => 595],
        ['left' => 225, 'top' => 1019],
    ];
@endphp

<section class="lum-container relative bg-lum-ivory">
    {{-- MOBILE — Figma 108:845 --}}
    <div class="relative h-[1781px] tab:hidden">
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute inset-0" data-lum-villa-intro>
            <h1 class="absolute left-1/2 top-[146px] w-[335px] -translate-x-1/2 text-center font-serif text-[42px] leading-[45px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="1">{{ __('lum.blog.page_title') }}</h1>

            <div class="absolute left-[20px] top-[223px] flex w-[335px] flex-wrap justify-center gap-x-[10px] gap-y-[10px]" data-lum-blog-tabs data-lum-stay-intro-item data-lum-stay-intro-order="2">
                @foreach ($tabKeys as $index => $key)
                    <button type="button" @class(['lum-tab lum-tab--s', 'lum-tab--active' => $index === 0, 'lum-tab--inactive' => $index !== 0]) data-lum-blog-tab data-category="{{ $key }}">{{ $tabs[$index] }}</button>
                @endforeach
            </div>
        </div>

        @foreach ($posts as $index => $post)
            @php $layout = $mobileLayout[$index]; @endphp
            <div class="absolute left-[20px] w-[335px]" style="top: {{ $layout['top'] }}px" data-lum-blog-post data-categories="{{ implode(' ', $post['categories']) }}" data-lum-villa-card>
                @include('lum.partials.blog-page.card', ['img' => $img, 'post' => $post, 'variant' => 'mobile'])
            </div>
        @endforeach
    </div>

    {{-- TABLET — Figma 108:667 --}}
    <div class="relative hidden h-[1476px] tab:block desk:hidden">
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])

        <div class="absolute inset-0" data-lum-villa-intro>
            <h1 class="absolute left-1/2 top-[180px] -translate-x-1/2 whitespace-nowrap text-center font-serif text-[52px] leading-[52px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="1">{{ __('lum.blog.page_title') }}</h1>

            <div class="absolute left-1/2 top-[264px] flex -translate-x-1/2 gap-[10px]" data-lum-blog-tabs data-lum-stay-intro-item data-lum-stay-intro-order="2">
                @foreach ($tabKeys as $index => $key)
                    <button type="button" @class(['lum-tab lum-tab--s', 'lum-tab--active' => $index === 0, 'lum-tab--inactive' => $index !== 0]) data-lum-blog-tab data-category="{{ $key }}">{{ $tabs[$index] }}</button>
                @endforeach
            </div>
        </div>

        @foreach ($posts as $index => $post)
            @php $layout = $tabletLayout[$index]; @endphp
            <div class="absolute left-[20px] w-[920px]" style="top: {{ $layout['top'] }}px" data-lum-blog-post data-categories="{{ implode(' ', $post['categories']) }}" data-lum-villa-card>
                @include('lum.partials.blog-page.card', ['img' => $img, 'post' => $post, 'variant' => 'tablet'])
            </div>
        @endforeach
    </div>

    {{-- DESKTOP — Figma 108:351 --}}
    <div class="relative hidden h-[1539px] desk:block">
        @include('lum.partials.header', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="absolute inset-0" data-lum-villa-intro>
            <h1 class="absolute left-1/2 top-[328px] w-[856px] -translate-x-1/2 text-center font-serif text-[88px] leading-[94px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="1">{{ __('lum.blog.page_title') }}</h1>

            <div class="absolute left-1/2 top-[466px] flex -translate-x-1/2 gap-[10px]" data-lum-blog-tabs data-lum-stay-intro-item data-lum-stay-intro-order="2">
                @foreach ($tabKeys as $index => $key)
                    <button type="button" @class(['lum-tab lum-tab--l', 'lum-tab--active' => $index === 0, 'lum-tab--inactive' => $index !== 0]) data-lum-blog-tab data-category="{{ $key }}">{{ $tabs[$index] }}</button>
                @endforeach
            </div>
        </div>

        @foreach ($posts as $index => $post)
            @php $layout = $desktopLayout[$index]; @endphp
            <div class="absolute" style="left: {{ $layout['left'] }}px; top: {{ $layout['top'] }}px" data-lum-blog-post data-categories="{{ implode(' ', $post['categories']) }}" data-lum-villa-card>
                @include('lum.partials.blog-page.card', ['img' => $img, 'post' => $post, 'variant' => 'desktop'])
            </div>
        @endforeach
    </div>
</section>
