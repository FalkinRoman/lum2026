@php
    $variant = $variant ?? 'mobile';
    $post = $post ?? null;
    $href = $post ? route('blog.show', $post['slug']) : route('blog');
    $image = $post ? 'blog/' . $post['image'] : 'blog/surfing.jpg';
    $category = $post['tags'][0] ?? __('lum.blog.category');
    $title = $post['title'] ?? null;
@endphp

<article
    @class(['lum-blog-card shrink-0 snap-start', 'w-[240px]' => $variant === 'mobile', 'w-[450px]' => $variant === 'tablet'])
    data-lum-blog-card
    data-lum-blog-variant="{{ $variant }}"
>
    <a href="{{ $href }}" class="block">
        <div @class([
            'lum-blog-card__media relative overflow-hidden',
            'lum-blog-card__media--mobile' => $variant === 'mobile',
            'lum-blog-card__media--tablet' => $variant === 'tablet',
            'h-[240px] w-[240px]' => $variant === 'mobile',
            'h-[450px] w-[450px]' => $variant === 'tablet',
        ])>
            <img src="{{ $img($image) }}" alt="" class="lum-blog-card__img h-full w-full object-cover" width="{{ $variant === 'mobile' ? 240 : 450 }}" height="{{ $variant === 'mobile' ? 240 : 450 }}">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[rgba(57,54,46,0.74)]"></div>
        </div>
        <div @class([
            'lum-blog-card__body relative bg-lum-sand',
            'lum-blog-card__body--mobile' => $variant === 'mobile',
            'lum-blog-card__body--tablet' => $variant === 'tablet',
            'h-[192px] w-[240px]' => $variant === 'mobile',
            'h-[287px] w-[450px]' => $variant === 'tablet',
        ])>
            @if ($variant === 'mobile')
                <div class="absolute left-1/2 top-[calc(50%-26px)] flex w-[200px] -translate-x-1/2 -translate-y-1/2 flex-col items-center gap-[16px] text-center">
                    <div class="flex flex-col items-center gap-[6px]">
                        <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                        <p class="text-[12px] font-medium uppercase leading-[12px] tracking-[0.6px] text-lum-ground">{{ $category }}</p>
                    </div>
                    <p class="font-serif text-[22px] leading-[24px] tracking-[0.19px] text-lum-espresso">
                        @if ($title)
                            {{ $title }}
                        @else
                            {{ __('lum.blog.card_line1') }}<br><span class="font-normal italic">{{ __('lum.blog.card_time') }}</span>
                        @endif
                    </p>
                </div>
                @include('lum.partials.link-read-more', [
                    'img' => $img,
                    'href' => $href,
                    'lineWidth' => 63,
                    'asSpan' => true,
                    'classes' => 'absolute left-1/2 top-[160px] -translate-x-1/2 text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-green pointer-events-none',
                ])
            @else
                <div class="absolute left-1/2 top-[32px] flex w-[386px] -translate-x-1/2 flex-col items-center gap-[24px] text-center">
                    <div class="flex flex-col items-center gap-[8px]">
                        <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                        <p class="lum-text-2 font-medium uppercase text-lum-espresso">{{ $category }}</p>
                    </div>
                    <p class="font-serif text-[28px] leading-[34px] tracking-[0.36px] text-lum-espresso">
                        @if ($title)
                            {{ $title }}
                        @else
                            {{ __('lum.blog.card_line2') }}<br>{{ __('lum.blog.card_line3') }}<br><span class="font-normal italic">{{ __('lum.blog.card_time') }}</span>
                        @endif
                    </p>
                </div>
                @include('lum.partials.link-read-more', [
                    'img' => $img,
                    'href' => $href,
                    'lineWidth' => 79,
                    'asSpan' => true,
                    'classes' => 'absolute left-1/2 top-[230px] -translate-x-1/2 lum-text-2 font-medium text-lum-green pointer-events-none',
                ])
            @endif
        </div>
    </a>
</article>
