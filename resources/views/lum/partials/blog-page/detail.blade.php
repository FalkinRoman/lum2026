@php
    $tags = array_values(array_filter($post['tags'] ?? []));
    $body = is_array($post['body'] ?? null) ? $post['body'] : [];
    $heroSrc = $img('blog/' . $post['hero']);
@endphp

<section class="lum-container relative bg-lum-ivory">
    {{-- MOBILE --}}
    <div class="relative tab:hidden">
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="px-[20px] pb-[80px] pt-[120px]" data-lum-villa-intro>
            <div data-lum-stay-intro-item data-lum-stay-intro-order="1">
                @include('lum.partials.blog-page.back', ['href' => $backHref, 'img' => $img])
            </div>

            <article class="mx-auto mt-[44px] flex w-[328px] max-w-full flex-col items-center text-center">
                @if (count($tags))
                    <div class="flex flex-wrap items-center justify-center gap-[9px] text-[12px] font-medium uppercase leading-[12px] tracking-[0.6px] text-lum-espresso/40" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                        @foreach ($tags as $i => $tag)
                            @if ($i > 0)
                                <span class="size-[3px] rounded-full bg-lum-espresso/40"></span>
                            @endif
                            <span>{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif

                <h1 class="mt-[44px] w-full text-balance font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="3">{{ $post['title'] }}</h1>

                @if ($post['excerpt'])
                    <p class="mt-[32px] w-full text-pretty text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="4">{{ $post['excerpt'] }}</p>
                @endif
            </article>

            <img src="{{ $heroSrc }}" alt="{{ $post['title'] }}" class="mx-auto mt-[44px] aspect-square h-auto w-full max-w-[335px] object-cover" width="335" height="335" loading="eager" data-lum-villa-card>

            @if (count($body))
                <div class="mx-auto mt-[32px] flex w-[328px] max-w-full flex-col gap-[28px] text-center" data-lum-scroll-stagger>
                    @foreach ($body as $paragraph)
                        <p class="text-pretty text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply" data-lum-scroll-item>{{ $paragraph }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- TABLET: flow grid, sticky hero --}}
    <div class="relative hidden tab:block desk:hidden">
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])

        <div class="grid grid-cols-[minmax(0,1fr)_minmax(280px,450px)] gap-x-[40px] px-[20px] pb-[120px] pt-[120px]" data-lum-villa-intro>
            <div class="min-w-0">
                <div data-lum-stay-intro-item data-lum-stay-intro-order="1">
                    @include('lum.partials.blog-page.back', ['href' => $backHref, 'img' => $img])
                </div>

                <article class="mx-auto mt-[56px] flex w-full max-w-[420px] flex-col items-center text-center">
                    @if (count($tags))
                        <div class="flex flex-wrap items-center justify-center gap-[9px] text-[14px] font-medium uppercase leading-[14px] tracking-[0.6px] text-lum-espresso/40" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                            @foreach ($tags as $i => $tag)
                                @if ($i > 0)
                                    <span class="size-[3px] rounded-full bg-lum-espresso/40"></span>
                                @endif
                                <span>{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif

                    <h1 class="mt-[44px] w-full text-balance font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="3">{{ $post['title'] }}</h1>

                    <div class="mt-[32px] flex w-full flex-col gap-[24px]">
                        @if ($post['excerpt'])
                            <p class="text-pretty text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="4">{{ $post['excerpt'] }}</p>
                        @endif

                        @foreach ($body as $index => $paragraph)
                            <p class="text-pretty text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="{{ 5 + $index }}">{{ $paragraph }}</p>
                        @endforeach
                    </div>
                </article>
            </div>

            <div class="relative border-l border-lum-espresso/16 pl-[40px]">
                <img
                    src="{{ $heroSrc }}"
                    alt="{{ $post['title'] }}"
                    class="sticky top-[120px] aspect-square w-full object-cover"
                    width="450"
                    height="450"
                    loading="eager"
                    data-lum-villa-card
                >
            </div>
        </div>
    </div>

    {{-- DESKTOP: flow grid, sticky hero --}}
    <div class="relative hidden desk:block">
        @include('lum.partials.header', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="grid grid-cols-[minmax(0,1fr)_minmax(420px,936px)] gap-x-[72px] px-[72px] pb-[160px] pt-[204px]" data-lum-villa-intro>
            <div class="min-w-0">
                <div data-lum-stay-intro-item data-lum-stay-intro-order="1">
                    @include('lum.partials.blog-page.back', ['href' => $backHref, 'img' => $img, 'size' => 'l'])
                </div>

                <article class="mx-auto mt-[64px] flex w-full max-w-[512px] flex-col items-center text-center">
                    @if (count($tags))
                        <div class="flex flex-wrap items-center justify-center gap-[9px] text-[14px] font-medium uppercase leading-[14px] tracking-[0.6px] text-lum-espresso/40" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                            @foreach ($tags as $i => $tag)
                                @if ($i > 0)
                                    <span class="size-[3px] rounded-full bg-lum-espresso/40"></span>
                                @endif
                                <span>{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif

                    <h1 class="mt-[64px] w-full text-balance font-serif text-[56px] leading-[68px] tracking-[-0.25px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="3">{{ $post['title'] }}</h1>

                    <div class="mt-[44px] flex w-full flex-col gap-[40px]">
                        @if ($post['excerpt'])
                            <p class="lum-text-2 text-pretty text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="4">{{ $post['excerpt'] }}</p>
                        @endif

                        @foreach ($body as $index => $paragraph)
                            <p class="lum-text-2 text-pretty text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="{{ 5 + $index }}">{{ $paragraph }}</p>
                        @endforeach
                    </div>
                </article>
            </div>

            <div class="relative border-l border-lum-espresso/16 pl-[72px]">
                <img
                    src="{{ $heroSrc }}"
                    alt="{{ $post['title'] }}"
                    class="sticky top-[132px] aspect-square w-full max-h-[calc(100vh-160px)] object-cover"
                    width="936"
                    height="936"
                    loading="eager"
                    data-lum-villa-card
                >
            </div>
        </div>
    </div>
</section>
