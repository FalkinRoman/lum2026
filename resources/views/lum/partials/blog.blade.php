@php
    $blogPosts = \App\Support\Content::homeBlogPosts(4);
    $isRu = app()->getLocale() === 'ru';
@endphp
<section @class([
    'lum-container relative bg-lum-ivory tab:h-[1244px] desk:h-[1274px]',
    'h-[822px]' => $isRu,
    'h-[777px]' => ! $isRu,
])>
    {{-- MOBILE — Figma 16:1579 --}}
    <div class="relative h-full tab:hidden" data-lum-blog-slider data-gap="10">
        <img src="{{ $img('blog/top-wave.svg') }}" alt="" class="absolute left-[20px] top-0 w-[335px]" width="335" height="23">
        <div
            @class([
                'absolute top-[67px] text-center font-serif text-[42px] font-medium italic leading-[45px] text-lum-espresso',
                'left-1/2 w-[335px] -translate-x-1/2 px-[8px]' => $isRu,
                'left-[58.5px] w-[258px]' => ! $isRu,
            ])
            data-lum-scroll-reveal
        >
            <p @class(['whitespace-nowrap' => ! $isRu])>{{ __('lum.blog.title_line1') }}</p>
            <p>{{ __('lum.blog.title_line2') }}</p>
        </div>
        {{-- Full-bleed left: cards slide into the left edge; ivory mask hides previous peek in the 20px gutter --}}
        <div
            @class([
                'absolute inset-x-0 overflow-hidden',
                'top-[246px]' => $isRu,
                'top-[201px]' => ! $isRu,
            ])
            data-lum-blog-viewport
        >
            <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-[20px] bg-lum-ivory" aria-hidden="true"></div>
            <div class="flex w-max gap-[10px] pl-[20px] pr-[20px] [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" data-lum-blog-track>
                @foreach ($blogPosts as $post)
                    @include('lum.partials.blog-card', ['img' => $img, 'variant' => 'mobile', 'post' => $post, 'from' => 'home'])
                @endforeach
            </div>
        </div>
        <div
            @class([
                'absolute left-1/2 flex -translate-x-1/2 gap-[10px]',
                'top-[702px]' => $isRu,
                'top-[657px]' => ! $isRu,
            ])
        >
            <button type="button" class="lum-icon-btn lum-icon-btn--green-filled lum-icon-btn--carousel-40" data-lum-blog-prev aria-label="{{ __('lum.aria.previous') }}">
                <img src="{{ $img('ui/carousel-arrow-left.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </button>
            <button type="button" class="lum-icon-btn lum-icon-btn--green-filled lum-icon-btn--carousel-40" data-lum-blog-next aria-label="{{ __('lum.aria.next') }}">
                <img src="{{ $img('ui/carousel-arrow-right.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </button>
        </div>
    </div>

    {{-- TABLET — Figma 16:1042 --}}
    <div class="relative hidden h-full tab:block desk:hidden" data-lum-blog-slider data-gap="20">
        <img src="{{ $img('blog/top-wave.svg') }}" alt="" class="absolute left-[20px] top-0 w-[920px]" width="920" height="28">
        <div
            @class([
                'absolute top-[108px] flex items-center justify-center gap-[12px]',
                'inset-x-[20px]' => $isRu,
                'left-[166px] w-[628px]' => ! $isRu,
            ])
            data-lum-scroll-reveal
        >
            <img src="{{ $img('blog/deco-left.svg') }}" alt="" class="w-[72px] shrink-0 rotate-180 scale-y-[-1]" width="72" height="2">
            <h2
                @class([
                    'shrink-0 font-serif font-medium italic whitespace-nowrap text-lum-espresso',
                    'text-[44px] leading-[48px]' => $isRu,
                    'text-[52px] leading-[52px]' => ! $isRu,
                ])
            >{{ __('lum.blog.title_single') }}</h2>
            <img src="{{ $img('blog/deco-right.svg') }}" alt="" class="w-[72px] shrink-0" width="72" height="2">
        </div>
        <div class="absolute left-1/2 top-[180px] -translate-x-1/2 -rotate-[1.4deg] bg-lum-espresso px-[24px] py-[10px]">
            <span class="text-[18px] font-medium uppercase leading-[18px] tracking-[1.8px] text-lum-ivory">{{ __('lum.blog.label') }}</span>
        </div>
        <div class="absolute left-[20px] top-[287px] w-[920px] overflow-hidden">
            <div class="flex w-full gap-[20px] overflow-x-auto [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" data-lum-blog-track>
                @foreach ($blogPosts as $post)
                    @include('lum.partials.blog-card', ['img' => $img, 'variant' => 'tablet', 'post' => $post, 'from' => 'home'])
                @endforeach
            </div>
        </div>
        <div class="absolute left-1/2 top-[1068px] flex -translate-x-1/2 gap-[20px]">
            <button type="button" class="lum-icon-btn lum-icon-btn--green-filled lum-icon-btn--carousel-56" data-lum-blog-prev aria-label="{{ __('lum.aria.previous') }}">
                <img src="{{ $img('ui/carousel-arrow-left.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </button>
            <button type="button" class="lum-icon-btn lum-icon-btn--green-filled lum-icon-btn--carousel-56" data-lum-blog-next aria-label="{{ __('lum.aria.next') }}">
                <img src="{{ $img('ui/carousel-arrow-right.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </button>
        </div>
    </div>

    {{-- DESKTOP --}}
    <div class="relative hidden h-full desk:block">
        <img src="{{ $img('blog/top-wave.svg') }}" alt="" class="absolute left-[72px] top-0 w-[1776px]" width="1776" height="45">
        <div
            @class([
                'absolute top-[160px] flex items-center justify-center gap-[12px]',
                'inset-x-[72px]' => $isRu,
                'left-1/2 -translate-x-1/2' => ! $isRu,
            ])
            data-lum-scroll-reveal
        >
            <img src="{{ $img('blog/deco-left.svg') }}" alt="" class="w-[108px] shrink-0 rotate-180 scale-y-[-1]" width="108" height="2">
            <h2
                @class([
                    'shrink-0 font-medium italic whitespace-nowrap text-lum-espresso',
                    'font-serif text-[72px] leading-[78px]' => $isRu,
                    'lum-heading-1' => ! $isRu,
                ])
            >{{ __('lum.blog.title_single') }}</h2>
            <img src="{{ $img('blog/deco-right.svg') }}" alt="" class="w-[108px] shrink-0" width="108" height="2">
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
                            <img src="{{ \App\Support\Content::mediaUrl(filled($post['image'] ?? null) ? 'blog/' . $post['image'] : null) }}" alt="" class="lum-blog-card__img h-full w-full object-cover" width="396" height="396">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[rgba(57,54,46,0.74)]"></div>
                        </div>
                    </a>
                    <div class="flex h-[320px] w-[396px] flex-col items-center bg-lum-sand px-[37px] pt-[44px] pb-[44px] text-center">
                        <a href="{{ $postHref }}" class="flex w-full max-w-[322px] shrink-0 flex-col items-center gap-[24px] text-inherit no-underline">
                            <div class="flex shrink-0 flex-col items-center gap-[12px]">
                                <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                                <p class="lum-text-2 font-medium uppercase">{{ $post['tags'][0] ?? __('lum.blog.category') }}</p>
                            </div>
                            <p class="line-clamp-4 w-full overflow-hidden lum-heading-3 text-lum-espresso">{{ $post['title'] }}</p>
                        </a>
                        <div class="min-h-[24px] flex-1" aria-hidden="true"></div>
                        @include('lum.partials.link-read-more', [
                            'img' => $img,
                            'href' => $postHref,
                            'lineWidth' => 79,
                            'classes' => 'shrink-0 lum-text-2 font-medium text-lum-green',
                        ])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
