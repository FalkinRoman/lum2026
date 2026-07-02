<section class="lum-container relative z-[1] overflow-visible bg-lum-ivory" data-lum-stay-wellness>
    {{-- MOBILE — Figma 103:834: frame h 660, image inset -18.18% top --}}
    <div class="relative h-[660px] overflow-visible tab:hidden">
        <div class="absolute -top-[18.18%] right-0 bottom-0 left-0">
            <img
                src="{{ $img('discover/detail/shared/hero-composite-mob.webp') }}"
                alt=""
                class="block h-[780px] w-full max-w-none object-cover object-top"
                width="375"
                height="780"
                loading="lazy"
                data-lum-stay-wellness-hero
            >
        </div>
    </div>

    {{-- TABLET — Figma 103:723 / 103:724: frame h 660 @ top 240, inset -24.24% top --}}
    <div class="relative hidden h-[980px] overflow-visible tab:block desk:hidden">
        <div class="absolute left-1/2 top-[240px] h-[660px] w-[960px] -translate-x-1/2 overflow-visible">
            <div class="absolute -top-[24.24%] right-0 bottom-0 left-0">
                <img
                    src="{{ $img('discover/detail/shared/hero-composite-tab.webp') }}"
                    alt=""
                    class="block h-[820px] w-full max-w-none object-cover object-top"
                    width="960"
                    height="820"
                    loading="lazy"
                    data-lum-stay-wellness-hero
                >
            </div>
        </div>
    </div>

    {{-- DESKTOP — Figma 103:593 --}}
    <div class="relative hidden h-[1150px] desk:block">
        <div class="absolute left-1/2 top-[80px] z-[3] h-[430px] w-[320px] -translate-x-1/2 overflow-hidden rounded-[50%]" data-lum-stay-wellness-oval>
            <img src="{{ $img($assetBase . '/oval.webp') }}" alt="" class="h-full w-full object-cover" width="320" height="430" loading="lazy">
        </div>
        <div class="absolute inset-x-0 top-[330px] h-[820px] overflow-hidden" data-lum-stay-wellness-hero>
            <img src="{{ $img($assetBase . '/wellness-hero.webp') }}" alt="" class="h-full w-full object-cover" width="1920" height="820" loading="lazy">
        </div>
    </div>
</section>
