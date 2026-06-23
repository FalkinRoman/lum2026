@php
    $variant = $variant ?? 'mobile';
@endphp

<article @class(['shrink-0 snap-start', 'w-[240px]' => $variant === 'mobile', 'w-[450px]' => $variant === 'tablet']) data-lum-blog-card>
    <div @class(['relative overflow-hidden', 'h-[240px] w-[240px]' => $variant === 'mobile', 'h-[450px] w-[450px]' => $variant === 'tablet'])>
        <img src="{{ $img('blog/surfing.jpg') }}" alt="" class="h-full w-full object-cover" width="{{ $variant === 'mobile' ? 240 : 450 }}" height="{{ $variant === 'mobile' ? 240 : 450 }}">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[rgba(57,54,46,0.74)]"></div>
    </div>
    <div @class(['relative bg-lum-sand', 'h-[192px] w-[240px]' => $variant === 'mobile', 'h-[287px] w-[450px]' => $variant === 'tablet'])>
        @if ($variant === 'mobile')
            <div class="absolute left-1/2 top-[calc(50%-26px)] flex w-[200px] -translate-x-1/2 -translate-y-1/2 flex-col items-center gap-[16px] text-center">
                <div class="flex flex-col items-center gap-[6px]">
                    <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                    <p class="text-[12px] font-medium uppercase leading-[12px] tracking-[0.6px] text-lum-ground">SURFING</p>
                </div>
                <p class="font-serif text-[22px] leading-[24px] tracking-[0.19px] text-lum-espresso">
                    our restaurant &amp; bar is open daily from<br><span class="font-normal italic">9 am to 9 pm.</span>
                </p>
            </div>
            <a href="#" class="absolute left-[calc(50%-31px)] top-[160px] text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-green">Read More</a>
            <img src="{{ $img('blog/underline.svg') }}" alt="" class="absolute left-1/2 top-[176px] w-[63px] -translate-x-1/2" width="63" height="2">
        @else
            <div class="absolute left-1/2 top-[32px] flex w-[386px] -translate-x-1/2 flex-col items-center gap-[24px] text-center">
                <div class="flex flex-col items-center gap-[8px]">
                    <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                    <p class="lum-text-2 font-medium uppercase text-lum-espresso">SURFING</p>
                </div>
                <p class="font-serif text-[28px] leading-[34px] tracking-[0.36px] text-lum-espresso">
                    our restaurant &amp; bar<br>is open daily from<br><span class="font-normal italic">9 am to 9 pm.</span>
                </p>
            </div>
            <a href="#" class="absolute left-1/2 top-[230px] -translate-x-1/2 lum-text-2 font-medium text-lum-green">Read More</a>
            <img src="{{ $img('blog/underline.svg') }}" alt="" class="absolute left-1/2 top-[255px] w-[79px] -translate-x-1/2" width="79" height="2">
        @endif
    </div>
</article>
