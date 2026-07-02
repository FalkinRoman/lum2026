@php
    $variant = $variant ?? 'mobile';
    $thumbCount = 4;
    $colorSize = $variant === 'mobile' ? 32 : ($variant === 'tablet' ? 36 : 36);
    $swatchSize = $variant === 'mobile' ? 40 : 44;
    $sizeBtn = $variant === 'mobile' ? 32 : 36;
@endphp

<article class="relative border border-dashed border-lum-espresso bg-lum-ivory @if($variant === 'mobile') h-[635px] w-[335px] @elseif($variant === 'tablet') h-[700px] w-[450px] @else h-[700px] w-[396px] @endif" data-lum-shop-product>
    <img
        src="{{ $img('shop/' . $product['image']) }}"
        alt=""
        class="mx-auto object-contain @if($variant === 'mobile') mt-0 h-[300px] w-[335px] @elseif($variant === 'tablet') mt-0 h-[313px] w-[350px] @else mt-0 h-[313px] w-[350px] @endif"
        width="350"
        height="313"
        loading="lazy"
        data-lum-shop-product-image
    >

    <div class="@if($variant === 'mobile') absolute left-[29px] top-[320px] @elseif($variant === 'tablet') absolute left-[60px] top-[337px] @else absolute left-[33px] top-[337px] @endif flex gap-[11px]">
        @for ($i = 0; $i < $thumbCount; $i++)
            <button type="button" class="overflow-hidden border border-transparent @if($variant === 'mobile') size-[65px] @else size-[75px] @endif" data-lum-shop-thumb data-index="{{ $i }}" @if($i === 0) data-active @endif>
                <img src="{{ $img('shop/' . $product['image']) }}" alt="" class="h-full w-full object-cover" loading="lazy">
            </button>
        @endfor
    </div>

    <div class="@if($variant === 'mobile') absolute left-[29px] top-[391px] h-[2px] w-[65px] @elseif($variant === 'tablet') absolute left-[60px] top-[418px] h-[2px] w-[75px] @else absolute left-[33px] top-[418px] h-[2px] w-[75px] @endif bg-lum-espresso" data-lum-shop-thumb-indicator></div>

    <div class="@if($variant === 'mobile') absolute left-[14px] top-[417px] @elseif($variant === 'tablet') absolute left-[71px] top-[444px] @else absolute left-[44px] top-[444px] @endif w-[308px] text-center">
        <p class="@if($variant === 'mobile') text-[14px] leading-[14px] @else lum-text-2 @endif font-medium uppercase text-lum-espresso">{{ $product['title'] }}</p>
        <p class="@if($variant === 'mobile') mt-[6px] text-[14px] leading-[22px] @else mt-[6px] lum-text-2 @endif text-lum-espresso mix-blend-multiply">{{ $product['subtitle'] }}</p>
    </div>

    <div class="@if($variant === 'mobile') absolute left-[58px] top-[483px] @elseif($variant === 'tablet') absolute left-[122px] top-[524px] @else absolute left-[95px] top-[524px] @endif flex gap-[10px]" data-lum-shop-colors>
        @foreach ($product['colors'] as $index => $color)
            <button type="button" class="flex items-center justify-center rounded-full border border-lum-espresso/20 @if($variant === 'mobile') size-[40px] @else size-[44px] @endif" data-lum-shop-color data-index="{{ $index }}" @if($index === 0) data-active @endif>
                <span class="rounded-full" style="width: {{ $colorSize }}px; height: {{ $colorSize }}px; background-color: {{ $color }}"></span>
            </button>
        @endforeach
    </div>

    <div class="@if($variant === 'mobile') absolute left-[86px] top-[547px] @elseif($variant === 'tablet') absolute left-[135px] top-[592px] @else absolute left-[108px] top-[592px] @endif flex gap-[12px]" data-lum-shop-sizes>
        @foreach ($product['sizes'] as $index => $size)
            <button type="button" @class([
                'flex items-center justify-center rounded-full border border-lum-espresso font-medium text-lum-espresso',
                'size-[32px] text-[14px]' => $variant === 'mobile',
                'size-[36px] lum-text-2' => $variant !== 'mobile',
            ]) data-lum-shop-size data-index="{{ $index }}" @if($index === 1) data-active @endif>{{ $size }}</button>
        @endforeach
    </div>

    <button type="button" class="lum-btn-green absolute left-1/2 -translate-x-1/2 @if($variant === 'mobile') bottom-[32px] px-[20px] py-[5px] text-[14px] leading-[23px] tracking-[2.84px] @elseif($variant === 'tablet') bottom-[32px] px-[20px] py-[5px] text-[14px] leading-[23px] tracking-[2.84px] @else bottom-[32px] @endif">{{ __('lum.shop.buy') }}</button>
</article>
