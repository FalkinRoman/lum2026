<section class="lum-container relative h-[675px] tab:h-[455px] desk:h-[768px]">
    <img src="{{ $img('shop/bg.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover" width="1920" height="768">
    <div class="absolute inset-0 bg-black/32"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[rgba(22,5,5,0.48)]"></div>

    {{-- MOBILE — Figma 16:1609 --}}
    <div class="absolute inset-0 flex items-center justify-center tab:hidden">
        <div class="flex w-[335px] flex-col items-center gap-[30px] text-center">
            <img src="{{ $img('shop/logomark.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            <div class="flex flex-col items-center gap-[24px]">
                <p class="lum-text-3 font-medium uppercase text-lum-ivory">DISCOVER OUR SHOP</p>
                <div class="pt-[12px] pb-[40px] text-lum-ivory">
                    <p class="font-serif text-[56px] leading-[56px]"><span class="font-normal not-italic">Visit the</span></p>
                    <p class="font-serif text-[56px] font-medium italic leading-[56px]">Lum Shop</p>
                </div>
                <a href="#" class="lum-btn-ivory px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">view shop</a>
            </div>
        </div>
    </div>

    {{-- TABLET — Figma 16:1078 --}}
    <div class="absolute inset-0 hidden items-center justify-center tab:flex desk:hidden">
        <div class="flex w-[920px] flex-col items-center gap-[32px] text-center">
            <div class="flex flex-col items-center gap-[24px]">
                <img src="{{ $img('shop/logomark.svg') }}" alt="" class="size-[40px]" width="40" height="40">
                <p class="lum-text-2 font-medium uppercase text-lum-ivory">DISCOVER OUR SHOP</p>
            </div>
            <div class="flex w-full items-center justify-center gap-[32px]">
                <img src="{{ $img('shop/deco-left.svg') }}" alt="" class="w-[72px] rotate-180 scale-y-[-1]" width="72" height="2">
                <h2 class="whitespace-nowrap font-serif text-[80px] leading-[80px] text-lum-ivory"><span class="font-normal not-italic">Visit the </span><span class="italic">Lum Shop</span></h2>
                <img src="{{ $img('shop/deco-right.svg') }}" alt="" class="w-[72px]" width="72" height="2">
            </div>
            <a href="#" class="rounded-[50px] bg-lum-ivory px-[34px] pt-[6px] pb-[5px] text-[16px] font-extrabold uppercase leading-[25px] tracking-[3.2px] text-lum-espresso">view shop</a>
        </div>
    </div>

    {{-- DESKTOP (не трогаем) --}}
    <div class="absolute bottom-0 left-[80px] top-1/2 hidden w-[1760px] -translate-y-1/2 flex-col items-center gap-[44px] text-center desk:flex">
        <img src="{{ $img('shop/logomark.svg') }}" alt="" class="size-[64px]" width="64" height="64">
        <div class="flex w-full flex-col items-center gap-[38px]">
            <p class="lum-eyebrow text-lum-ivory">DISCOVER OUR SHOP</p>
            <div class="flex w-full items-center justify-center gap-[32px]">
                <img src="{{ $img('shop/deco-left.svg') }}" alt="" class="w-[108px] rotate-180 scale-y-[-1]" width="108" height="2">
                <h2 class="lum-heading-1-hero text-lum-ivory"><span class="font-normal not-italic">Visit the </span><span class="italic">Lum Shop</span></h2>
                <img src="{{ $img('shop/deco-right.svg') }}" alt="" class="w-[108px]" width="108" height="2">
            </div>
            <a href="#" class="lum-btn-ivory">view shop</a>
        </div>
    </div>
</section>
