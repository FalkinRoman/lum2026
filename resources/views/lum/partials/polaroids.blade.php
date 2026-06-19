<section class="lum-container relative h-[1299px] bg-lum-ivory">
    <img src="{{ $img('polaroids/bg-texture.png') }}" alt="" class="pointer-events-none absolute inset-0 h-full w-full object-cover opacity-40 mix-blend-multiply" width="1920" height="1299">
    {{-- polaroid decorations --}}
    <p class="lum-script pointer-events-none absolute left-[195px] top-[150px] text-[73px] leading-none tracking-[3.65px] text-lum-green mix-blend-hard-light">shine</p>
    <p class="lum-script pointer-events-none absolute left-[1091px] top-[455px] rotate-[9deg] text-[73px] leading-none tracking-[3.65px] text-lum-green mix-blend-hard-light">relax</p>
    <p class="lum-script pointer-events-none absolute left-[1291px] top-[-20px] -rotate-[10deg] text-[73px] leading-none tracking-[3.65px] text-lum-green mix-blend-hard-light">impressive</p>

    <div class="absolute left-[216px] top-[362px] h-[425px] w-[301px] rotate-[13.5deg]">
        <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="absolute inset-0 w-full" width="301" height="425">
        <img src="{{ $img('polaroids/photo-1.jpg') }}" alt="" class="absolute left-[14px] top-[14px] h-[calc(100%-28px)] w-[calc(100%-28px)] object-cover" width="270" height="387">
    </div>

    <div class="absolute left-[787px] top-[109px] h-[425px] w-[301px] -rotate-[5.5deg]">
        <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="absolute inset-0 w-full" width="301" height="425">
        <img src="{{ $img('polaroids/photo-2.jpg') }}" alt="" class="absolute left-[14px] top-[14px] h-[calc(100%-28px)] w-[calc(100%-28px)] object-cover" width="270" height="387">
    </div>

    <div class="absolute left-[1463px] top-[392px] h-[425px] w-[301px] -rotate-[1deg]">
        <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="absolute inset-0 w-full" width="301" height="425">
        <img src="{{ $img('polaroids/photo-3.jpg') }}" alt="" class="absolute left-[14px] top-[14px] h-[calc(100%-28px)] w-[calc(100%-28px)] object-cover" width="270" height="387">
    </div>

    <div class="absolute left-[80px] top-[693px] flex w-[1760px] flex-col items-center gap-[64px]">
        <div class="flex flex-col items-center gap-[24px]">
            <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[12px]" width="12" height="12">
            <div class="text-center">
                <h2 class="lum-heading-1 text-lum-espresso">
                    hard to find,<br>
                    <span class="font-medium italic">hard to leave</span>
                </h2>
                <p class="lum-body mx-auto mt-[44px] max-w-[760px] mix-blend-multiply text-lum-espresso">
                    Just a few hours from the airport. Light years away from the crowds.
                    Here you you find the true Sri Lanka. And a small resort with a big view, a
                    great restaurant, and a special sense of calm. Welcome to The Lum.
                </p>
            </div>
        </div>
        <a href="#villas" class="lum-btn-dark">explore our villas</a>
    </div>

    <div class="lum-divider absolute bottom-0 left-[72px]"></div>
</section>
