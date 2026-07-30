@php
    $variant = $variant ?? 'mobile';
    $isTee = ($product['type'] ?? 'tee') === 'tee';
    $isCup = ! $isTee;
    $image = filled($product['image'] ?? null) ? (string) $product['image'] : '';
    $thumbs = array_values(array_filter(
        is_array($product['thumbs'] ?? null) ? $product['thumbs'] : [],
        fn ($t) => is_string($t) && $t !== '',
    ));
    if ($thumbs === [] && $image !== '') {
        $thumbs = [$image];
    }
    $cta = $cta ?? __('lum.shop.cta_price');

    // Cup: Figma dashed frame — keep room under text for 1–2 line subtitle; CTA pinned to bottom
    $cardClass = match ($variant) {
        'mobile' => $isTee ? 'h-[635px] w-[335px]' : 'h-[538px] w-[335px]',
        'tablet' => $isTee ? 'h-[700px] w-[450px]' : 'h-[600px] w-[450px]',
        default => $isTee ? 'h-[700px] w-[396px]' : 'h-[604px] w-[396px]',
    };

    $imageWrapClass = match (true) {
        $variant === 'tablet' && $isTee => 'relative h-[313px] w-full',
        default => null,
    };

    $imageClass = match (true) {
        $variant === 'tablet' && $isTee => 'absolute left-1/2 top-0 h-[313px] w-[350px] -translate-x-1/2 object-contain object-top',
        $isTee && $variant === 'mobile' => 'h-[300px] w-full object-contain object-top',
        $isTee && $variant === 'tablet' => 'h-[313px] w-full object-contain object-top',
        $isTee => 'mx-auto h-[313px] w-[350px] object-contain object-top',
        $variant === 'mobile' => 'h-[300px] w-full object-cover',
        $variant === 'tablet' => 'h-[313px] w-full object-cover',
        default => 'h-[313px] w-full object-cover',
    };

    $imagePlaceholderClass = match (true) {
        $variant === 'tablet' && $isTee => 'absolute left-1/2 top-0 h-[313px] w-[350px] -translate-x-1/2 bg-lum-espresso/6',
        $isTee && $variant === 'mobile' => 'h-[300px] w-full bg-lum-espresso/6',
        $isTee && $variant === 'tablet' => 'h-[313px] w-full bg-lum-espresso/6',
        $isTee => 'mx-auto h-[313px] w-[350px] bg-lum-espresso/6',
        $variant === 'mobile' => 'h-[300px] w-full bg-lum-espresso/6',
        $variant === 'tablet' => 'h-[313px] w-full bg-lum-espresso/6',
        default => 'h-[313px] w-full bg-lum-espresso/6',
    };

    $thumbSize = $variant === 'mobile' ? 'size-[65px]' : 'size-[75px]';
    $thumbGap = $variant === 'mobile' ? 'gap-[6px]' : 'gap-[10px]';

    $thumbWrapClass = match (true) {
        $variant === 'mobile' && $isCup => 'absolute left-[28px] top-[318px]',
        $variant === 'mobile' => 'absolute left-1/2 top-[320px] flex -translate-x-1/2',
        $variant === 'tablet' && $isCup => 'absolute left-[59.5px] top-[336.5px]',
        $variant === 'tablet' => 'absolute left-1/2 top-[337px] flex -translate-x-1/2',
        $isCup => 'absolute left-[32px] top-[336px]',
        default => 'absolute left-1/2 top-[337px] flex -translate-x-1/2',
    };

    // Text sits under thumbs; cup CTA is bottom-pinned so RU wrap doesn't kill spacing
    $textWrapClass = match (true) {
        $isCup && $variant === 'mobile' => 'absolute left-1/2 top-[415px] w-[308px] -translate-x-1/2 text-center',
        $isCup && $variant === 'tablet' => 'absolute left-1/2 top-[443.5px] w-[308px] -translate-x-1/2 text-center',
        $isCup => 'absolute left-1/2 top-[443px] w-[308px] -translate-x-1/2 text-center',
        $variant === 'mobile' => 'absolute left-1/2 top-[417px] w-[308px] -translate-x-1/2 text-center',
        $variant === 'tablet' => 'absolute left-1/2 top-[444px] w-[308px] -translate-x-1/2 text-center',
        default => 'absolute left-[44px] top-[444px] w-[308px] text-center',
    };

    $buttonSize = $variant === 'desktop' ? 'lum-shop-btn--desk' : 'lum-shop-btn--compact';

    $buttonClass = match (true) {
        $isCup && $variant === 'mobile' => "lum-shop-btn {$buttonSize} absolute bottom-[24px] left-1/2 -translate-x-1/2",
        $isCup => "lum-shop-btn {$buttonSize} absolute bottom-[40px] left-1/2 -translate-x-1/2",
        default => "lum-shop-btn {$buttonSize} absolute bottom-0 left-1/2 -translate-x-1/2",
    };
@endphp

<article
    @class([
        'relative overflow-clip bg-lum-ivory',
        'lum-shop-card--cup' => $isCup,
        $cardClass,
    ])
    data-lum-shop-product
    data-lum-shop-variant="{{ $variant }}"
    @if ($isCup) data-lum-shop-type="cup" @endif
>
    @if ($imageWrapClass)
        <div class="{{ $imageWrapClass }}">
            @if ($image !== '')
                <img
                    src="{{ $img('shop/' . $image) }}"
                    alt=""
                    class="{{ $imageClass }}"
                    width="350"
                    height="313"
                    loading="lazy"
                    data-lum-shop-product-image
                >
            @else
                <div class="{{ $imagePlaceholderClass }}" data-lum-shop-product-image aria-hidden="true"></div>
            @endif
        </div>
    @elseif ($image !== '')
        <img
            src="{{ $img('shop/' . $image) }}"
            alt=""
            class="{{ $imageClass }}"
            width="350"
            height="313"
            loading="lazy"
            data-lum-shop-product-image
        >
    @else
        <div class="{{ $imagePlaceholderClass }}" data-lum-shop-product-image aria-hidden="true"></div>
    @endif

    @if ($thumbs !== [])
        <div class="{{ $thumbWrapClass }} flex {{ $thumbGap }}" data-lum-shop-thumbs>
            @foreach ($thumbs as $index => $thumb)
                <button
                    type="button"
                    class="cursor-pointer overflow-hidden {{ $thumbSize }}"
                    data-lum-shop-thumb
                    data-index="{{ $index }}"
                    @if ($index === 0) data-active @endif
                >
                    <img src="{{ $img('shop/' . $thumb) }}" alt="" class="h-full w-full object-cover" loading="lazy">
                </button>
            @endforeach
            <div class="w-[65px]" data-lum-shop-thumb-indicator aria-hidden="true"></div>
        </div>
    @endif

    <div class="{{ $textWrapClass }}">
        <p @class([
            'font-medium uppercase text-lum-espresso',
            'text-[14px] leading-[14px] tracking-[0.6px]' => $variant === 'mobile',
            'lum-text-2' => $variant !== 'mobile',
        ])>{{ $product['title'] }}</p>
        <p @class([
            'mt-[6px] text-balance text-lum-espresso',
            'text-[14px] leading-[22px] tracking-[0.1px]' => $variant === 'mobile',
            'lum-text-2' => $variant !== 'mobile',
        ])>{{ $product['subtitle'] }}</p>
    </div>

    @if ($isTee)
        @if (($product['colors'] ?? []) !== [])
            <div @class([
                'absolute flex',
                'left-1/2 top-[483px] -translate-x-1/2 gap-[20px]' => $variant === 'mobile',
                'left-1/2 top-[524px] -translate-x-1/2 gap-[10px]' => $variant !== 'mobile',
            ]) data-lum-shop-colors>
                @foreach ($product['colors'] as $index => $color)
                    @php
                        $colorKind = is_array($color) ? ($color['kind'] ?? 'image') : 'image';
                        $colorHex = is_array($color) ? ($color['hex'] ?? null) : null;
                        $colorImage = is_array($color)
                            ? ($color['image'] ?? null)
                            : (is_string($color) ? $color : null);
                    @endphp
                    <button
                        type="button"
                        class="cursor-pointer overflow-hidden @if($variant === 'mobile') size-[40px] @else size-[44px] @endif"
                        data-lum-shop-color
                        data-index="{{ $index }}"
                        @if ($index === 0) data-active @endif
                    >
                        @if ($colorKind === 'hex' && filled($colorHex))
                            <span class="block size-full rounded-full" style="background: {{ $colorHex }}" aria-hidden="true"></span>
                        @elseif (filled($colorImage))
                            <img src="{{ $img('shop/' . $colorImage) }}" alt="" class="size-full object-cover" loading="lazy">
                        @endif
                    </button>
                @endforeach
            </div>
        @endif

        @if (($product['sizes'] ?? []) !== [])
            <div @class([
                'absolute flex gap-[12px]',
                'left-1/2 top-[547px] -translate-x-1/2' => $variant === 'mobile',
                'left-1/2 top-[592px] -translate-x-1/2' => $variant !== 'mobile',
            ]) data-lum-shop-sizes>
                @foreach ($product['sizes'] as $index => $size)
                    <button
                        type="button"
                        @class([
                            'lum-shop-size flex cursor-pointer items-center justify-center border font-normal text-lum-espresso transition-colors duration-200',
                            'size-[32px] text-[16px] leading-[25px] tracking-[0.16px]' => $variant === 'mobile',
                            'size-[36px] text-[18px] leading-[26px] tracking-[0.1px]' => $variant !== 'mobile',
                        ])
                        data-lum-shop-size
                        data-index="{{ $index }}"
                        @if ($index === 0) data-active @endif
                    >{{ $size }}</button>
                @endforeach
            </div>
        @endif
    @endif

    @php
        $ctaHref = $product['cta_href'] ?? \App\Support\Site::whatsappUrl();
        $ctaExternal = str_starts_with($ctaHref, 'http://')
            || str_starts_with($ctaHref, 'https://')
            || str_starts_with($ctaHref, '//');
    @endphp
    <a
        href="{{ $ctaHref }}"
        class="{{ $buttonClass }}"
        @if ($ctaExternal) target="_blank" rel="noopener noreferrer" @endif
    >{{ $cta }}</a>
</article>
