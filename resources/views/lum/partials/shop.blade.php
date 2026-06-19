<section class="lum-container relative h-[768px]">
    <img src="{{ $img('shop/bg.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover" width="1920" height="768">
    <div class="absolute inset-0 bg-black/32"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[rgba(22,5,5,0.48)]"></div>

    <div class="absolute bottom-0 left-[80px] top-1/2 flex w-[1760px] -translate-y-1/2 flex-col items-center gap-[44px] text-center">
        <img src="{{ $img('shop/logomark.svg') }}" alt="" class="size-[64px]" width="64" height="64">
        <div class="flex w-full flex-col items-center gap-[38px]">
            <p class="lum-eyebrow text-lum-ivory">DISCOVER OUR SHOP</p>
            <div class="flex w-full items-center justify-center gap-[32px]">
                <img src="{{ $img('shop/deco-left.svg') }}" alt="" class="w-[108px] rotate-180 scale-y-[-1]" width="108" height="2">
                <h2 class="lum-heading-1-hero text-lum-ivory">
                    <span class="font-normal not-italic">Visit the </span><span class="italic">Lum Shop</span>
                </h2>
                <img src="{{ $img('shop/deco-right.svg') }}" alt="" class="w-[108px]" width="108" height="2">
            </div>
            <a href="#" class="lum-btn-ivory">view shop</a>
        </div>
    </div>
</section>
