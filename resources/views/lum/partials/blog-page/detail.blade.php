@php
    $mobileBodyHeight = 869 + (count($post['body']) * 88) + 40;
@endphp
<section class="lum-container relative bg-lum-ivory">
    {{-- MOBILE — Figma 108:922 --}}
    <div class="relative tab:hidden" style="height: {{ max(909, $mobileBodyHeight) }}px">
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute inset-0" data-lum-villa-intro>
            <div class="absolute left-[20px] top-[120px] flex items-center gap-[10px]" data-lum-stay-intro-item data-lum-stay-intro-order="1">
                <a href="{{ route('blog') }}" class="flex size-[32px] rotate-90 items-center justify-center rounded-[28px] border border-lum-espresso bg-lum-ivory p-[4px]" aria-label="{{ __('lum.blog.back') }}">
                    <img src="{{ $img('villas/arrow.svg') }}" alt="" class="size-[24px]" width="24" height="24">
                </a>
                <a href="{{ route('blog') }}" class="lum-btn-outline px-[20px] py-[5px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.blog.back') }}</a>
            </div>

            <div class="absolute left-1/2 top-[196px] flex -translate-x-1/2 items-center gap-[9px] text-[12px] font-medium uppercase leading-[12px] tracking-[0.6px] text-lum-ground" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                <span>{{ $post['tags'][0] }}</span>
                <span class="size-[3px] rounded-full bg-lum-ground"></span>
                <span>{{ $post['tags'][1] }}</span>
            </div>

            <h1 class="absolute left-1/2 top-[252px] w-[254px] -translate-x-1/2 text-center font-serif text-[28px] leading-[28px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="3">{{ $post['title'] }}</h1>

            <p class="absolute left-1/2 top-[340px] w-[328px] -translate-x-1/2 text-center text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="4">{{ $post['excerpt'] }}</p>
        </div>

        <img src="{{ $img('blog/' . $post['hero']) }}" alt="" class="absolute left-[20px] top-[494px] h-[335px] w-[335px] object-cover" width="335" height="335" loading="lazy" data-lum-villa-card>

        @foreach ($post['body'] as $index => $paragraph)
            <p class="absolute left-[20px] w-[335px] text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply" style="top: {{ 869 + ($index * 88) }}px" data-lum-scroll-reveal data-lum-scroll-reveal-delay="{{ 0.08 + ($index * 0.04) }}">{{ $paragraph }}</p>
        @endforeach
    </div>

    {{-- TABLET — Figma 108:907 --}}
    <div class="relative hidden h-[780px] tab:block desk:hidden">
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])

        <div class="absolute inset-0" data-lum-villa-intro>
            <div class="absolute left-[20px] top-[120px] flex items-center gap-[10px]" data-lum-stay-intro-item data-lum-stay-intro-order="1">
                <a href="{{ route('blog') }}" class="flex size-[32px] rotate-90 items-center justify-center rounded-[28px] border border-lum-espresso bg-lum-ivory p-[4px]" aria-label="{{ __('lum.blog.back') }}">
                    <img src="{{ $img('villas/arrow.svg') }}" alt="" class="size-[24px]" width="24" height="24">
                </a>
                <a href="{{ route('blog') }}" class="lum-btn-outline px-[20px] py-[5px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.blog.back') }}</a>
            </div>

            <div class="absolute left-[186px] top-[196px] flex items-center gap-[9px] text-[14px] font-medium uppercase leading-[14px] tracking-[0.6px] text-lum-ground" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                <span>{{ $post['tags'][0] }}</span>
                <span class="size-[3px] rounded-full bg-lum-ground"></span>
                <span>{{ $post['tags'][1] }}</span>
            </div>

            <h1 class="absolute left-[71px] top-[254px] w-[328px] font-serif text-[36px] leading-[36px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="3">{{ $post['title'] }}</h1>

            <p class="absolute left-[71px] top-[358px] w-[328px] lum-text-2 text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="4">{{ $post['excerpt'] }}</p>
        </div>

        <div class="absolute left-[470px] top-[120px] h-[540px] w-px bg-lum-espresso/16"></div>
        <img src="{{ $img('blog/' . $post['hero']) }}" alt="" class="absolute left-[490px] top-[120px] h-[451px] w-[450px] object-cover" width="450" height="451" loading="lazy" data-lum-villa-card>
    </div>

    {{-- DESKTOP — Figma 108:890 --}}
    <div class="relative hidden h-[1300px] desk:block">
        @include('lum.partials.header', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="absolute inset-0" data-lum-villa-intro>
            <div class="absolute left-[72px] top-[204px] flex items-center gap-[10px]" data-lum-stay-intro-item data-lum-stay-intro-order="1">
                <a href="{{ route('blog') }}" class="flex size-[36px] rotate-90 items-center justify-center rounded-[28px] border border-lum-espresso bg-lum-ivory p-[4px]" aria-label="{{ __('lum.blog.back') }}">
                    <img src="{{ $img('villas/arrow.svg') }}" alt="" class="size-[28px]" width="28" height="28">
                </a>
                <a href="{{ route('blog') }}" class="lum-btn-outline px-[24px] py-[5px] lum-text-2">{{ __('lum.blog.back') }}</a>
            </div>

            <div class="absolute left-[371px] top-[284px] flex items-center gap-[9px] text-[14px] font-medium uppercase leading-[14px] tracking-[0.6px] text-lum-ground" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                <span>{{ $post['tags'][0] }}</span>
                <span class="size-[3px] rounded-full bg-lum-ground"></span>
                <span>{{ $post['tags'][1] }}</span>
            </div>

            <h1 class="absolute left-[164px] top-[362px] w-[512px] font-serif text-[64px] leading-[68px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="3">{{ $post['title'] }}</h1>

            <p class="absolute left-[164px] top-[542px] w-[512px] lum-body text-lum-espresso mix-blend-multiply" data-lum-stay-intro-item data-lum-stay-intro-order="4">{{ $post['excerpt'] }}</p>

            @foreach ($post['body'] as $index => $paragraph)
                <p class="absolute left-[164px] w-[512px] lum-body text-lum-espresso mix-blend-multiply" style="top: {{ 672 + ($index * 120) }}px" data-lum-scroll-reveal data-lum-scroll-reveal-delay="{{ 0.08 + ($index * 0.04) }}">{{ $paragraph }}</p>
            @endforeach
        </div>

        <div class="absolute left-[839px] top-[204px] h-[926px] w-px bg-lum-espresso/16"></div>
        <img src="{{ $img('blog/' . $post['hero']) }}" alt="" class="absolute left-[912px] top-[204px] h-[936px] w-[936px] object-cover" width="936" height="936" loading="lazy" data-lum-villa-card>
    </div>
</section>
