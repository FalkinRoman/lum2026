@php
    $blogPosts = trans('lum.blog.posts');
@endphp
<section class="lum-container relative h-[777px] bg-lum-ivory tab:h-[1244px] desk:h-[1274px]">
    {{-- MOBILE — Figma 16:1579 --}}
    <div class="relative h-full tab:hidden" data-lum-blog-slider data-gap="10">
        <img src="{{ $img('blog/top-wave.svg') }}" alt="" class="absolute left-[20px] top-0 w-[335px]" width="335" height="23">
        <div class="absolute left-[58.5px] top-[67px] w-[258px] text-center font-serif text-[42px] font-medium italic leading-[45px] text-lum-espresso" data-lum-scroll-reveal>
            <p class="whitespace-nowrap">{{ __('lum.blog.title_line1') }}</p>
            <p>{{ __('lum.blog.title_line2') }}</p>
        </div>
        <div class="absolute left-[20px] top-[201px] w-[355px] overflow-hidden">
            <div class="flex w-full gap-[10px] overflow-x-auto scroll-smooth pr-[20px] [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden snap-x snap-mandatory" data-lum-blog-track>
                @foreach ($blogPosts as $post)
                    @include('lum.partials.blog-card', ['img' => $img, 'variant' => 'mobile', 'post' => $post, 'from' => 'home'])
                @endforeach
            </div>
        </div>
        <div class="absolute left-1/2 top-[657px] flex -translate-x-1/2 gap-[10px]">
            <button type="button" class="flex size-[40px] rotate-90 items-center justify-center rounded-[28px] bg-lum-green p-[4px]" data-lum-blog-prev aria-label="{{ __('lum.aria.previous') }}">
                <img src="{{ $img('villas/arrow.svg') }}" alt="" class="size-[32px] brightness-0 invert" width="32" height="32">
            </button>
            <button type="button" class="flex size-[40px] -scale-y-100 rotate-90 items-center justify-center rounded-[28px] bg-lum-green p-[4px]" data-lum-blog-next aria-label="{{ __('lum.aria.next') }}">
                <img src="{{ $img('villas/arrow.svg') }}" alt="" class="size-[32px] brightness-0 invert" width="32" height="32">
            </button>
        </div>
    </div>

    {{-- TABLET — Figma 16:1042 --}}
    <div class="relative hidden h-full tab:block desk:hidden" data-lum-blog-slider data-gap="20">
        <img src="{{ $img('blog/top-wave.svg') }}" alt="" class="absolute left-[20px] top-0 w-[920px]" width="920" height="28">
        <div class="absolute left-[166px] top-[108px] flex w-[628px] items-center justify-center gap-[12px]" data-lum-scroll-reveal>
            <img src="{{ $img('blog/deco-left.svg') }}" alt="" class="w-[72px] rotate-180 scale-y-[-1]" width="72" height="2">
            <h2 class="font-serif text-[52px] font-medium italic leading-[52px] whitespace-nowrap text-lum-espresso">{{ __('lum.blog.title_single') }}</h2>
            <img src="{{ $img('blog/deco-right.svg') }}" alt="" class="w-[72px]" width="72" height="2">
        </div>
        <div class="absolute left-1/2 top-[180px] -translate-x-1/2 -rotate-[1.4deg] bg-lum-espresso px-[24px] py-[10px]">
            <span class="text-[18px] font-medium uppercase leading-[18px] tracking-[1.8px] text-lum-ivory">{{ __('lum.blog.label') }}</span>
        </div>
        <div class="absolute left-[20px] top-[287px] w-[920px] overflow-hidden">
            <div class="flex w-full gap-[20px] overflow-x-auto scroll-smooth [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden snap-x snap-mandatory" data-lum-blog-track>
                @foreach ($blogPosts as $post)
                    @include('lum.partials.blog-card', ['img' => $img, 'variant' => 'tablet', 'post' => $post, 'from' => 'home'])
                @endforeach
            </div>
        </div>
        <div class="absolute left-1/2 top-[1068px] flex -translate-x-1/2 gap-[20px]">
            <button type="button" class="flex size-[56px] rotate-90 items-center justify-center rounded-[28px] bg-lum-green p-[12px]" data-lum-blog-prev aria-label="{{ __('lum.aria.previous') }}">
                <img src="{{ $img('villas/arrow.svg') }}" alt="" class="size-[32px] brightness-0 invert" width="32" height="32">
            </button>
            <button type="button" class="flex size-[56px] -scale-y-100 rotate-90 items-center justify-center rounded-[28px] bg-lum-green p-[12px]" data-lum-blog-next aria-label="{{ __('lum.aria.next') }}">
                <img src="{{ $img('villas/arrow.svg') }}" alt="" class="size-[32px] brightness-0 invert" width="32" height="32">
            </button>
        </div>
    </div>

    {{-- DESKTOP (не трогаем) --}}
    <div class="relative hidden h-full desk:block">
        <img src="{{ $img('blog/top-wave.svg') }}" alt="" class="absolute left-[72px] top-0 w-[1776px]" width="1776" height="45">
        <div class="absolute left-1/2 top-[160px] flex -translate-x-1/2 items-center gap-[12px]" data-lum-scroll-reveal>
            <img src="{{ $img('blog/deco-left.svg') }}" alt="" class="w-[108px] rotate-180 scale-y-[-1]" width="108" height="2">
            <h2 class="lum-heading-1 font-medium italic whitespace-nowrap text-lum-espresso">{{ __('lum.blog.title_single') }}</h2>
            <img src="{{ $img('blog/deco-right.svg') }}" alt="" class="w-[108px]" width="108" height="2">
        </div>
        <div class="absolute left-1/2 top-[276px] -translate-x-1/2 -rotate-[1.4deg] bg-lum-espresso px-[32px] py-[12px]">
            <span class="lum-headline uppercase text-lum-ivory">{{ __('lum.blog.label') }}</span>
        </div>
        <div class="absolute left-[72px] top-[398px] flex gap-[64px]">
            @foreach ($blogPosts as $post)
                @php
                    $postHref = route('blog.show', ['slug' => $post['slug'], 'from' => 'home']);
                @endphp
                <div class="lum-blog-card flex w-[396px] shrink-0 flex-col">
                    <a href="{{ $postHref }}" class="block">
                        <div class="relative h-[396px] w-[396px] overflow-hidden">
                            <img src="{{ $img('blog/' . $post['image']) }}" alt="" class="lum-blog-card__img h-full w-full object-cover" width="396" height="396">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[rgba(57,54,46,0.74)]"></div>
                        </div>
                    </a>
                    <div class="flex h-[320px] w-[396px] flex-col items-center bg-lum-sand px-[37px] pt-[44px] pb-[40px] text-center">
                        <a href="{{ $postHref }}" class="flex flex-1 flex-col items-center text-inherit no-underline">
                            <img src="{{ $img('ui/dot.svg') }}" alt="" class="mb-[12px] size-[6px]" width="6" height="6">
                            <p class="lum-text-2 mb-[24px] font-medium uppercase">{{ $post['tags'][0] }}</p>
                            <p class="lum-heading-3 flex flex-1 items-center text-lum-espresso">{{ $post['title'] }}</p>
                        </a>
                        @include('lum.partials.link-read-more', [
                            'img' => $img,
                            'href' => $postHref,
                            'lineWidth' => 79,
                            'classes' => 'lum-text-2 mt-auto font-medium text-lum-green',
                        ])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
