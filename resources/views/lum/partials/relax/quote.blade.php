@php
    $quoteLine1 = __('lum.dining.quote_line1');
    $quoteLine2 = __('lum.dining.quote_line2');
    $noteLine1 = __('lum.dining.note_line1');
    $noteLine2 = __('lum.dining.note_line2');
@endphp

<section class="lum-container relative overflow-visible bg-lum-ivory" data-lum-stay-wellness>
    {{-- MOBILE — Figma 101:565 + 101:567 --}}
    <div class="relative overflow-visible tab:hidden">
        <div class="relative z-[1] -mt-[120px] h-[780px] overflow-visible" data-lum-stay-wellness-hero>
            <img src="{{ $img('relax/wellness-hero-mob.webp') }}" alt="" class="h-full w-full object-cover" width="375" height="780" loading="lazy">
        </div>

        <div class="relative z-[2] h-[563px] w-full bg-lum-ivory">
            <div class="absolute left-1/2 top-[128px] flex w-[335px] -translate-x-1/2 flex-col items-center gap-[16px] text-center" data-lum-scroll-reveal>
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                <p class="font-serif text-[42px] leading-[45px] text-lum-espresso">
                    <span class="italic">{{ $quoteLine1 }}</span><br>
                    {{ $quoteLine2 }}
                </p>
            </div>

            <div class="absolute left-1/2 top-[331px] flex w-[280px] -translate-x-1/2 items-center justify-center gap-[8px]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.12">
                <img src="{{ $img('stay/quote-line-half.svg') }}" alt="" class="h-px w-[130px] object-cover object-right" width="130" height="1">
                <span class="w-[20px] shrink-0" aria-hidden="true"></span>
                <img src="{{ $img('stay/quote-line-half.svg') }}" alt="" class="h-px w-[130px] -scale-x-100 object-cover object-left" width="130" height="1">
            </div>

            <div class="absolute left-1/2 top-[359px] w-[301px] -translate-x-1/2" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.16">
                <div class="relative flex flex-col items-center">
                    <img src="{{ $img('stay/clip.png') }}" alt="" class="absolute left-1/2 top-[-35px] h-[42px] w-[33px] -translate-x-1/2 rotate-2" width="33" height="42" loading="lazy">
                    <div class="w-full bg-lum-cream px-[24px] py-[20px] text-center shadow-[1.3px_1px_1.2px_rgba(0,0,0,0.51)]">
                        <p class="text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">{{ $noteLine1 }}</p>
                        <p class="text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">{{ $noteLine2 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLET — Figma 101:518 + 101:520 --}}
    <div class="relative hidden overflow-visible tab:block desk:hidden">
        <div class="relative z-[1] -mt-[160px] h-[820px] overflow-visible" data-lum-stay-wellness-hero>
            <img src="{{ $img('relax/wellness-hero-tab.webp') }}" alt="" class="h-full w-full object-cover" width="960" height="820" loading="lazy">
        </div>

        <div class="relative z-[2] h-[588px] w-full bg-lum-ivory">
            <div class="absolute left-1/2 top-[152px] flex -translate-x-1/2 flex-col items-center gap-[12px] text-center" data-lum-scroll-reveal>
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8">
                <p class="whitespace-nowrap font-serif text-[52px] leading-[52px] text-lum-espresso">
                    <span class="italic">{{ $quoteLine1 }}</span>{{ $quoteLine2 }}
                </p>
            </div>

            <div class="absolute left-1/2 top-[340px] flex w-[733px] -translate-x-1/2 items-center justify-center gap-[12px]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.12">
                <img src="{{ $img('stay/quote-line-half.svg') }}" alt="" class="h-[2px] w-[366px] object-cover object-right" width="366" height="2">
                <span class="w-[40px] shrink-0" aria-hidden="true"></span>
                <img src="{{ $img('stay/quote-line-half.svg') }}" alt="" class="h-[2px] w-[366px] -scale-x-100 object-cover object-left" width="366" height="2">
            </div>

            <div class="absolute left-1/2 top-[378px] w-[301px] -translate-x-1/2" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.16">
                <div class="relative flex flex-col items-center">
                    <img src="{{ $img('stay/clip.png') }}" alt="" class="absolute left-[130px] top-[-45px] h-[52px] w-[40px] rotate-2" width="40" height="52" loading="lazy">
                    <div class="w-full bg-lum-cream px-[24px] py-[20px] text-center shadow-[1.3px_1px_1.2px_rgba(0,0,0,0.51)]">
                        <p class="lum-text-2 text-lum-espresso">{{ $noteLine1 }}</p>
                        <p class="lum-text-2 text-lum-espresso">{{ $noteLine2 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- DESKTOP — Figma 101:421 --}}
    <div class="relative hidden h-[1931px] desk:block">
        <img src="{{ $img('dining/detail/shared/divider.svg') }}" alt="" class="absolute left-[72px] top-0 h-[63px] w-[1776px]" width="1776" height="63">

        <div class="absolute left-1/2 top-[183px] z-[3] h-[430px] w-[320px] -translate-x-1/2 overflow-hidden rounded-[50%]" data-lum-stay-wellness-oval>
            <img src="{{ $img('relax/wellness-oval.webp') }}" alt="" class="h-full w-full object-cover" width="320" height="430" loading="lazy">
        </div>

        <div class="absolute left-0 top-[433px] z-[1] h-[820px] w-full overflow-hidden" data-lum-stay-wellness-hero>
            <img src="{{ $img('relax/wellness-hero.webp') }}" alt="" class="h-full w-full object-cover" width="1920" height="820" loading="lazy">
        </div>

        <div class="absolute left-1/2 top-[1373px] flex -translate-x-1/2 flex-col items-center gap-[24px] text-center" data-lum-scroll-reveal>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12">
            <p class="whitespace-nowrap font-serif text-[88px] leading-[94px] text-lum-espresso">
                <span class="italic">{{ $quoteLine1 }}</span>{{ $quoteLine2 }}
            </p>
        </div>

        <div class="absolute left-1/2 top-[1641px] flex w-[733px] -translate-x-1/2 items-center justify-center gap-[12px]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.12">
            <img src="{{ $img('stay/quote-line-half.svg') }}" alt="" class="h-[2px] w-[366px] object-cover object-right" width="366" height="2">
            <span class="w-[40px] shrink-0" aria-hidden="true"></span>
            <img src="{{ $img('stay/quote-line-half.svg') }}" alt="" class="h-[2px] w-[366px] -scale-x-100 object-cover object-left" width="366" height="2">
        </div>

        <div class="absolute left-1/2 top-[1679px] w-[301px] -translate-x-1/2" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.16">
            <div class="relative flex flex-col items-center">
                <img src="{{ $img('stay/clip.png') }}" alt="" class="absolute left-[130px] top-[-45px] h-[52px] w-[40px] rotate-2" width="40" height="52" loading="lazy">
                <div class="w-full bg-lum-cream px-[24px] py-[20px] text-center shadow-[1.3px_1px_1.2px_rgba(0,0,0,0.51)]">
                    <p class="lum-body text-lum-espresso">{{ $noteLine1 }}</p>
                    <p class="lum-body text-lum-espresso">{{ $noteLine2 }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
