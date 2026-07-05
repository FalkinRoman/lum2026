@php
    $posts = trans('lum.blog.posts');
    $tabs = trans('lum.blog.tabs');
    $tabKeys = ['all', 'food', 'beach', 'kitchen', 'sri-lanka'];
@endphp

<section class="lum-container relative bg-lum-ivory">
    {{-- MOBILE — Figma 108:845 --}}
    <div class="relative tab:hidden" data-lum-blog-section>
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute inset-x-0 top-0" data-lum-blog-intro>
            <div class="absolute left-1/2 top-[124px] flex w-[335px] -translate-x-1/2 flex-col items-center gap-[16px]" data-lum-stay-intro-item data-lum-stay-intro-order="1">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                <h1 class="text-center font-serif text-[42px] leading-[45px] text-lum-espresso">{{ __('lum.blog.page_title') }}</h1>
            </div>

            @include('lum.partials.blog-page.tabs', ['tabs' => $tabs, 'tabKeys' => $tabKeys, 'variant' => 'mobile'])
        </div>

        <div class="flex flex-col gap-[20px] px-[20px] pt-[383px] pb-[80px]" data-lum-blog-grid>
            @foreach ($posts as $post)
                <div data-lum-blog-post data-categories="{{ implode(' ', $post['categories']) }}">
                    <div data-lum-blog-card>
                        @include('lum.partials.blog-page.card', ['img' => $img, 'post' => $post, 'variant' => 'mobile'])
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- TABLET — Figma 108:667 --}}
    <div class="relative hidden tab:block desk:hidden" data-lum-blog-section>
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])

        <div class="absolute inset-x-0 top-0" data-lum-blog-intro>
            <div class="absolute left-1/2 top-[180px] flex -translate-x-1/2 flex-col items-center gap-[12px]" data-lum-stay-intro-item data-lum-stay-intro-order="1">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8">
                <h1 class="whitespace-nowrap text-center font-serif text-[52px] leading-[52px] text-lum-espresso">{{ __('lum.blog.page_title') }}</h1>
            </div>

            @include('lum.partials.blog-page.tabs', ['tabs' => $tabs, 'tabKeys' => $tabKeys, 'variant' => 'tablet'])
        </div>

        <div class="flex flex-col gap-[20px] px-[20px] pt-[356px] pb-[120px]" data-lum-blog-grid>
            @foreach ($posts as $post)
                <div data-lum-blog-post data-categories="{{ implode(' ', $post['categories']) }}">
                    <div data-lum-blog-card>
                        @include('lum.partials.blog-page.card', ['img' => $img, 'post' => $post, 'variant' => 'tablet'])
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- DESKTOP — Figma 108:351 --}}
    <div class="relative hidden desk:block" data-lum-blog-section>
        @include('lum.partials.header', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="absolute inset-x-0 top-0" data-lum-blog-intro>
            <div class="absolute left-1/2 top-[292px] flex w-[856px] -translate-x-1/2 flex-col items-center gap-[24px]" data-lum-stay-intro-item data-lum-stay-intro-order="1">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12">
                <h1 class="w-full text-center font-serif text-[88px] leading-[94px] text-lum-espresso">{{ __('lum.blog.page_title') }}</h1>
            </div>

            @include('lum.partials.blog-page.tabs', ['tabs' => $tabs, 'tabKeys' => $tabKeys, 'variant' => 'desktop'])
        </div>

        <div class="grid grid-cols-2 gap-x-[64px] gap-y-[64px] px-[225px] pt-[595px] pb-[160px]" data-lum-blog-grid>
            @foreach ($posts as $post)
                <div data-lum-blog-post data-categories="{{ implode(' ', $post['categories']) }}">
                    <div class="w-[703px]" data-lum-blog-card>
                        @include('lum.partials.blog-page.card', ['img' => $img, 'post' => $post, 'variant' => 'desktop'])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
