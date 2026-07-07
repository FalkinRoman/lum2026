<section class="lum-container relative bg-lum-ivory">
    {{-- MOBILE — Figma 108:922 --}}
    <div class="relative tab:hidden">
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="px-[20px] pb-[80px] pt-[120px]" data-lum-villa-intro>
            <div data-lum-stay-intro-item data-lum-stay-intro-order="1">
                @include('lum.partials.blog-page.back', ['href' => $backHref, 'img' => $img])
            </div>

            <div class="mx-auto mt-[44px] flex w-[335px] max-w-full flex-col items-center text-center">
                <div class="flex items-center gap-[9px] text-[12px] font-medium uppercase leading-[12px] tracking-[0.6px] text-lum-ground" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                    <span>{{ $post['tags'][0] }}</span>
                    <span class="size-[3px] rounded-full bg-lum-ground"></span>
                    <span>{{ $post['tags'][1] }}</span>
                </div>

                <h1 class="mt-[44px] font-serif text-[28px] leading-[28px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="3">{{ $post['title'] }}</h1>

                <div class="mt-[32px] flex w-full flex-col gap-[32px]">
                    <p class="text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="4">{{ $post['excerpt'] }}</p>

                    <img src="{{ $img('blog/' . $post['hero']) }}" alt="" class="h-[335px] w-full object-cover" width="335" height="335" loading="lazy" data-lum-villa-card>

                    <div class="flex w-full flex-col gap-[32px]" data-lum-scroll-stagger>
                        @foreach ($post['body'] as $index => $paragraph)
                            <p class="text-left text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply" data-lum-scroll-item>{{ $paragraph }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLET — Figma 108:907 --}}
    <div class="relative hidden min-h-[780px] tab:block desk:hidden">
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])

        <div class="absolute inset-0" data-lum-villa-intro>
            <div class="absolute left-[20px] top-[120px]" data-lum-stay-intro-item data-lum-stay-intro-order="1">
                @include('lum.partials.blog-page.back', ['href' => $backHref, 'img' => $img])
            </div>

            <div class="absolute left-[71px] top-[196px] flex w-[328px] flex-col">
                <div class="flex items-center gap-[9px] text-[14px] font-medium uppercase leading-[14px] tracking-[0.6px] text-lum-ground" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                    <span>{{ $post['tags'][0] }}</span>
                    <span class="size-[3px] rounded-full bg-lum-ground"></span>
                    <span>{{ $post['tags'][1] }}</span>
                </div>

                <h1 class="mt-[44px] font-serif text-[36px] leading-[36px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="3">{{ $post['title'] }}</h1>

                <p class="lum-text-2 mt-[32px] text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="4">{{ $post['excerpt'] }}</p>
            </div>
        </div>

        <div class="absolute left-[470px] top-[120px] h-[540px] w-px bg-lum-espresso/16"></div>
        <img src="{{ $img('blog/' . $post['hero']) }}" alt="" class="absolute left-[490px] top-[120px] h-[451px] w-[450px] object-cover" width="450" height="451" loading="lazy" data-lum-villa-card>
    </div>

    {{-- DESKTOP — Figma 108:890 --}}
    <div class="relative hidden min-h-[1300px] desk:block">
        @include('lum.partials.header', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="absolute inset-0" data-lum-villa-intro>
            <div class="absolute left-[72px] top-[204px]" data-lum-stay-intro-item data-lum-stay-intro-order="1">
                @include('lum.partials.blog-page.back', ['href' => $backHref, 'img' => $img, 'size' => 'l'])
            </div>

            <div class="absolute left-[164px] top-[284px] flex w-[512px] flex-col">
                <div class="flex items-center gap-[9px] text-[14px] font-medium uppercase leading-[14px] tracking-[0.6px] text-lum-ground" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                    <span>{{ $post['tags'][0] }}</span>
                    <span class="size-[3px] rounded-full bg-lum-ground"></span>
                    <span>{{ $post['tags'][1] }}</span>
                </div>

                <h1 class="mt-[64px] font-serif text-[64px] leading-[68px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="3">{{ $post['title'] }}</h1>

                <div class="mt-[32px] flex flex-col gap-[40px]">
                    <p class="lum-body text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="4">{{ $post['excerpt'] }}</p>

                    @foreach ($post['body'] as $index => $paragraph)
                        <p class="lum-body text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="{{ 5 + $index }}">{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="absolute left-[839px] top-[204px] h-[926px] w-px bg-lum-espresso/16"></div>
        <img src="{{ $img('blog/' . $post['hero']) }}" alt="" class="absolute left-[912px] top-[204px] h-[936px] w-[936px] object-cover" width="936" height="936" loading="lazy" data-lum-villa-card>
    </div>
</section>
