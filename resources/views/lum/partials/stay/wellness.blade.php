@php
    use App\Support\Content;

    $isRu = app()->getLocale() === 'ru';
    $quote = Content::pageText('stay', 'quote', 'quote');
    $quoteBreak = Content::pageText('stay', 'quote', 'quote_break');
    $note1 = Content::pageText('stay', 'quote', 'note_line1');
    $note2 = Content::pageText('stay', 'quote', 'note_line2');
    $heroUrl = Content::pageMediaUrl('stay', 'media', 'hero_image', 'stay/wellness-hero.webp');
    $ovalUrl = Content::pageMediaUrl('stay', 'media', 'oval_image', 'stay/wellness-oval.webp');
@endphp

<section class="lum-container relative bg-lum-ivory" data-lum-stay-wellness>
    {{-- MOBILE — Figma 73:752 + 73:754 --}}
    <div class="relative tab:hidden">
        <div class="relative z-[1] h-[660px] overflow-hidden" data-lum-stay-wellness-hero>
            <img src="{{ $heroUrl }}" alt="" class="h-full w-full object-cover" width="375" height="660" loading="lazy">
        </div>

        <div class="pointer-events-none absolute left-1/2 z-[3] h-[188px] w-[140px] -translate-x-1/2 overflow-hidden rounded-[50%]" style="top: 513px" data-lum-stay-wellness-oval>
            <img src="{{ $ovalUrl }}" alt="" class="h-full w-full object-cover" width="140" height="188" loading="lazy">
        </div>

        <div class="relative z-[2] -mt-[64px] h-[563px] w-full bg-lum-ivory">
            <div class="absolute left-1/2 top-[128px] flex w-[335px] -translate-x-1/2 flex-col items-center gap-[16px] text-center" data-lum-scroll-reveal>
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                <p class="font-serif text-[42px] leading-[45px] text-lum-espresso">{{ $quote }}</p>
            </div>

            <div class="absolute left-1/2 top-[331px] w-[280px] -translate-x-1/2" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.12">
                <img src="{{ $img('stay/quote-line-full.svg') }}" alt="" class="h-px w-full" width="280" height="1">
            </div>

            <div class="absolute left-1/2 top-[359px] w-[301px] -translate-x-1/2" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.16">
                <div class="relative flex flex-col items-center">
                    <img src="{{ $img('stay/clip.png') }}" alt="" class="absolute left-1/2 top-[-35px] z-[1] h-[42px] w-[33px] -translate-x-1/2 rotate-2" width="33" height="42" loading="lazy">
                    <div class="relative z-0 w-full bg-lum-cream px-[24px] py-[20px] text-center shadow-[1.3px_1px_1.2px_rgba(0,0,0,0.51)]">
                        <p class="whitespace-nowrap text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">{{ $note1 }}</p>
                        <p class="whitespace-nowrap text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">{{ $note2 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLET — Figma 73:658 + 73:660 --}}
    <div class="relative hidden tab:block desk:hidden">
        <div class="relative z-[1] h-[660px] overflow-hidden" data-lum-stay-wellness-hero>
            <img src="{{ $heroUrl }}" alt="" class="h-full w-full object-cover" width="960" height="660" loading="lazy">
        </div>

        <div class="pointer-events-none absolute left-1/2 z-[3] h-[240px] w-[180px] -translate-x-1/2 overflow-hidden rounded-[50%]" style="top: 473px" data-lum-stay-wellness-oval>
            <img src="{{ $ovalUrl }}" alt="" class="h-full w-full object-cover" width="180" height="240" loading="lazy">
        </div>

        <div @class(['relative z-[2] -mt-[64px] w-full bg-lum-ivory', 'h-[692px]' => $isRu, 'h-[588px]' => ! $isRu])>
            <div class="absolute left-1/2 top-[152px] flex -translate-x-1/2 flex-col items-center gap-[12px] text-center" data-lum-scroll-reveal>
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8">
                <p @class(['font-serif text-[52px] leading-[52px] text-lum-espresso text-center', 'whitespace-nowrap' => ! $isRu])>{!! nl2br(e($quoteBreak)) !!}</p>
            </div>

            <div @class(['absolute left-1/2 w-[733px] -translate-x-1/2', 'top-[444px]' => $isRu, 'top-[340px]' => ! $isRu]) data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.12">
                <img src="{{ $img('stay/quote-line-full.svg') }}" alt="" class="h-[2px] w-full" width="733" height="2">
            </div>

            <div @class(['absolute left-1/2 w-[301px] -translate-x-1/2', 'top-[482px]' => $isRu, 'top-[378px]' => ! $isRu]) data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.16">
                <div class="relative flex flex-col items-center">
                    <img src="{{ $img('stay/clip.png') }}" alt="" class="absolute left-[130px] top-[-45px] z-[1] h-[52px] w-[40px] rotate-2" width="40" height="52" loading="lazy">
                    <div class="relative z-0 w-full bg-lum-cream px-[24px] py-[20px] text-center shadow-[1.3px_1px_1.2px_rgba(0,0,0,0.51)]">
                        <p class="whitespace-nowrap lum-text-2 text-lum-espresso">{{ $note1 }}</p>
                        <p class="whitespace-nowrap lum-text-2 text-lum-espresso">{{ $note2 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- DESKTOP — Figma 73:563 --}}
    <div @class(['relative hidden desk:block', 'h-[1886px]' => $isRu, 'h-[1698px]' => ! $isRu])>
        <div class="absolute left-0 top-0 h-[820px] w-full overflow-hidden" data-lum-stay-wellness-hero>
            <img src="{{ $heroUrl }}" alt="" class="h-full w-full object-cover" width="1920" height="820" loading="lazy">
        </div>

        <div class="absolute left-1/2 top-[550px] h-[430px] w-[320px] -translate-x-1/2 overflow-hidden rounded-[50%]" data-lum-stay-wellness-oval>
            <img src="{{ $ovalUrl }}" alt="" class="h-full w-full object-cover" width="320" height="430" loading="lazy">
        </div>

        <div class="absolute left-1/2 top-[1140px] flex -translate-x-1/2 flex-col items-center gap-[24px] text-center" data-lum-scroll-reveal>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12">
            <p @class(['font-serif text-[88px] leading-[94px] text-lum-espresso text-center', 'whitespace-nowrap' => ! $isRu])>{!! nl2br(e($quoteBreak)) !!}</p>
        </div>

        <div @class(['absolute left-1/2 w-[733px] -translate-x-1/2', 'top-[1596px]' => $isRu, 'top-[1408px]' => ! $isRu]) data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.12">
            <img src="{{ $img('stay/quote-line-full.svg') }}" alt="" class="h-[2px] w-full" width="733" height="2">
        </div>

        <div @class(['absolute left-1/2 w-[301px] -translate-x-1/2', 'top-[1634px]' => $isRu, 'top-[1446px]' => ! $isRu]) data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.16">
            <div class="relative flex flex-col items-center">
                <img src="{{ $img('stay/clip.png') }}" alt="" class="absolute left-[130px] top-[-45px] z-[1] h-[52px] w-[40px] rotate-2" width="40" height="52" loading="lazy">
                <div class="relative z-0 w-full bg-lum-cream px-[24px] py-[20px] text-center shadow-[1.3px_1px_1.2px_rgba(0,0,0,0.51)]">
                    <p class="whitespace-nowrap lum-body text-lum-espresso">{{ $note1 }}</p>
                    <p class="whitespace-nowrap lum-body text-lum-espresso">{{ $note2 }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
