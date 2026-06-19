<section id="villas" class="lum-container relative h-[1413px] bg-lum-ivory">
    <div class="absolute left-[701px] top-[80px] flex w-[519px] flex-col items-center gap-[24px] text-center">
        <p class="lum-eyebrow text-lum-espresso">Hotel and restaurant & bar</p>
        <img src="{{ $img('villas/divider.svg') }}" alt="" class="h-[2px] w-full" width="519" height="2">
        <p class="lum-body text-lum-espresso">
            A BOUTIQUE HOTEL, RESTAURANT, AND <span class="lum-script text-[28px] text-lum-green">lifestyle</span> SPACE FOR
            RELAX, SURFING, AND BEAUTIFUL LIVING BY THE OCEAN.
            EUROPEAN CUISINE, GRILL PARTIES, DELICIOUS COCKTAILS,
            AND THE ATMOSPHERE OF A TROPICAL EVENING.
        </p>
    </div>

    <div class="absolute left-0 top-[333px] h-[1080px] w-full">
        <img src="{{ $img('villas/photo.jpg') }}" alt="" class="h-full w-full object-cover" width="1920" height="1080">
        <div class="absolute inset-0 bg-black/32"></div>
        <div class="absolute bottom-0 left-0 h-full w-[32px] overflow-hidden">
            <div class="absolute inset-0 bg-[#d9d9d9]"></div>
        </div>
        <div class="absolute bottom-0 left-[32px] h-full w-[72px] overflow-hidden">
            <img src="{{ $img('villas/side-blur.jpg') }}" alt="" class="h-full w-full object-cover" width="72" height="1080">
        </div>
        <div class="absolute right-0 bottom-0 h-full w-[72px] overflow-hidden">
            <img src="{{ $img('villas/side-blur.jpg') }}" alt="" class="h-full w-full scale-x-[-1] object-cover" width="72" height="1080">
        </div>
    </div>

    <div class="absolute left-1/2 top-[413px] flex -translate-x-1/2 items-center gap-[16px] text-lum-ivory">
        <span class="font-serif text-[20px] font-medium leading-[24px] tracking-[-0.4px]">01</span>
        <span class="h-px w-[86px] bg-lum-ivory-64"></span>
        <span class="font-serif text-[20px] font-medium leading-[24px] tracking-[-0.4px] text-lum-ivory-64">04</span>
    </div>

    <p class="absolute left-1/2 top-[698px] -translate-x-1/2 whitespace-nowrap lum-body text-lum-ivory-88">
        Sleeps 4 adults — with 2 pools, 2 bedrooms and 2 bathrooms
    </p>

    <h2 class="absolute left-1/2 top-[873px] -translate-x-1/2 -translate-y-1/2 text-center text-[164px] leading-[170px] text-lum-ivory">
        <span class="font-serif font-normal">Lum </span><span class="font-serif font-medium italic">Villas</span>
    </h2>

    <button type="button" class="absolute left-[72px] top-[calc(50%+166.5px)] flex size-[64px] -translate-y-1/2 rotate-90 items-center justify-center rounded-[50px] bg-lum-ivory p-[16px]" aria-label="Previous">
        <img src="{{ $img('villas/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
    </button>
    <button type="button" class="absolute right-[72px] top-[calc(50%+166.5px)] flex size-[64px] -translate-y-1/2 -scale-y-100 rotate-90 items-center justify-center rounded-[50px] bg-lum-ivory p-[16px]" aria-label="Next">
        <img src="{{ $img('villas/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
    </button>

    <a href="#" class="absolute right-[365px] top-[1129px] flex size-[88px] items-center justify-center rounded-[50px] bg-lum-ivory text-[16px] font-extrabold tracking-[3.2px] text-lum-espresso uppercase">VIEW</a>
</section>
