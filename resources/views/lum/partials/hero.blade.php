<section class="lum-container relative h-[1242px] bg-lum-cream">
    <div class="absolute inset-0 h-[1242px] w-[1920px] overflow-hidden">
        <video
            class="h-full w-full object-cover object-center"
            autoplay
            muted
            loop
            playsinline
            poster="{{ $img('hero/video-poster.png') }}"
        >
            <source src="{{ $img('hero/video.mp4') }}" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-black/24"></div>
    </div>

    @include('lum.partials.header')

    <div class="absolute left-[80px] top-[520px] flex w-[1760px] flex-col items-center gap-[44px]">
        <img src="{{ $img('hero/logomark.svg') }}" alt="" class="size-[64px]" width="64" height="64">
        <div class="flex w-full flex-col items-center gap-[38px]">
            <p class="lum-eyebrow text-center text-lum-ivory">The lum – sri lanka</p>
            <div class="flex w-full items-center justify-center gap-[32px]">
                <img src="{{ $img('hero/deco-left.svg') }}" alt="" class="w-[108px] rotate-180 scale-y-[-1]" width="108" height="2">
                <h1 class="text-center text-lum-ivory">
                    <span class="block font-serif text-[120px] leading-[120px] tracking-[-1.16px]">Find the spirit of</span>
                    <span class="block font-serif text-[120px] font-medium italic leading-[120px] tracking-[-1.16px]">Sri Lanka</span>
                </h1>
                <img src="{{ $img('hero/deco-right.svg') }}" alt="" class="w-[108px]" width="108" height="2">
            </div>
        </div>
    </div>

    <div class="absolute left-1/2 top-[868px] flex h-[86px] w-[86px] -translate-x-1/2 items-center justify-center">
        <img src="{{ $img('hero/scroll-arrow.svg') }}" alt="" class="w-[86px] rotate-90" width="86" height="2">
    </div>

    <a href="#villas" class="lum-btn-green absolute left-1/2 top-[1018px] -translate-x-1/2">explore our villas</a>

    <img src="{{ $img('hero/torn-edge.svg') }}" alt="" class="pointer-events-none absolute bottom-0 left-0 w-[1920px] rotate-180 scale-x-[-1]" width="1920" height="269">
</section>
