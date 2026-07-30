@php
    $variant = $variant ?? 'mobile';
    $post = $post ?? null;
    $from = $from ?? null;
    $href = $post
        ? route('blog.show', array_filter(['slug' => $post['slug'], 'from' => $from]))
        : route('blog');
    $image = $post && filled($post['image'] ?? null) ? 'blog/' . $post['image'] : null;
    $category = $post['tags'][0] ?? __('lum.blog.category');
    $title = $post['title'] ?? null;
@endphp

<article
    @class(['lum-blog-card shrink-0', 'w-[240px]' => $variant === 'mobile', 'w-[450px]' => $variant === 'tablet'])
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
            <img src="{{ \App\Support\Content::mediaUrl($image) }}" alt="" class="lum-blog-card__img h-full w-full object-cover" width="{{ $variant === 'mobile' ? 240 : 450 }}" height="{{ $variant === 'mobile' ? 240 : 450 }}">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[rgba(57,54,46,0.74)]"></div>
        </div>
    </a>

    {{--
      Figma info paddings:
      - mob 240×192: content gap 16, cat gap 6; Read More @160 → bottom ~16 under line
      - tab 450×287: content top 32, gap 24, cat gap 8; Read More @230 → bottom ~32
    --}}
    <div @class([
        'lum-blog-card__body relative flex flex-col items-center bg-lum-sand text-center',
        'lum-blog-card__body--mobile' => $variant === 'mobile',
        'lum-blog-card__body--tablet' => $variant === 'tablet',
        'h-[192px] w-[240px] px-[20px] pt-[20px] pb-[16px]' => $variant === 'mobile',
        'h-[287px] w-[450px] px-[32px] pt-[32px] pb-[32px]' => $variant === 'tablet',
    ])>
        @if ($variant === 'mobile')
            <a href="{{ $href }}" class="lum-blog-card__content flex w-full max-w-[200px] shrink-0 flex-col items-center gap-[16px]">
                <div class="flex shrink-0 flex-col items-center gap-[6px]">
                    <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                    <p class="text-[12px] font-medium uppercase leading-[12px] tracking-[0.6px] text-lum-ground">{{ $category }}</p>
                </div>
                <p class="line-clamp-3 w-full overflow-hidden font-serif text-[22px] leading-[24px] tracking-[0.19px] text-lum-espresso">
                    @if ($title)
                        {{ $title }}
                    @else
                        {{ __('lum.blog.card_line1') }}<br><span class="font-normal italic">{{ __('lum.blog.card_time') }}</span>
                    @endif
                </p>
            </a>
            <div class="min-h-[12px] flex-1" aria-hidden="true"></div>
            @include('lum.partials.link-read-more', [
                'img' => $img,
                'href' => $href,
                'lineWidth' => 63,
                'classes' => 'shrink-0 text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-green',
            ])
        @else
            <a href="{{ $href }}" class="lum-blog-card__content flex w-full max-w-[386px] shrink-0 flex-col items-center gap-[24px]">
                <div class="flex shrink-0 flex-col items-center gap-[8px]">
                    <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                    <p class="lum-text-2 font-medium uppercase text-lum-espresso">{{ $category }}</p>
                </div>
                <p class="line-clamp-4 w-full overflow-hidden font-serif text-[28px] leading-[34px] tracking-[0.36px] text-lum-espresso">
                    @if ($title)
                        {{ $title }}
                    @else
                        {{ __('lum.blog.card_line2') }}<br>{{ __('lum.blog.card_line3') }}<br><span class="font-normal italic">{{ __('lum.blog.card_time') }}</span>
                    @endif
                </p>
            </a>
            <div class="min-h-[24px] flex-1" aria-hidden="true"></div>
            @include('lum.partials.link-read-more', [
                'img' => $img,
                'href' => $href,
                'lineWidth' => 79,
                'classes' => 'shrink-0 lum-text-2 font-medium text-lum-green',
            ])
        @endif
    </div>
</article>
