@php
    use App\Support\Content;

    $quote = Content::pageText('stay', 'quote', 'quote');
    $quoteBreak = Content::pageText('stay', 'quote', 'quote_break');
    $note1 = Content::pageText('stay', 'quote', 'note_line1');
    $note2 = Content::pageText('stay', 'quote', 'note_line2');
    $heroUrl = Content::pageMediaUrl('stay', 'media', 'hero_image', 'stay/wellness-hero.webp');
    $ovalUrl = Content::pageOptionalMediaUrl('stay', 'media', 'oval_image', 'stay/wellness-oval.webp');
@endphp

<section class="lum-container relative bg-lum-ivory" data-lum-stay-wellness>
    {{-- MOBILE — Figma 73:752 + 73:754 --}}
    <div class="relative tab:hidden">
        <div class="relative z-[1] h-[660px] overflow-hidden" data-lum-stay-wellness-hero>
            <img src="{{ $heroUrl }}" alt="" class="h-full w-full object-cover" width="375" height="660" loading="lazy">
        </div>

        @if ($ovalUrl)
            <div class="pointer-events-none absolute left-1/2 z-[3] h-[188px] w-[140px] -translate-x-1/2 overflow-hidden rounded-[50%]" style="top: 513px" data-lum-stay-wellness-oval>
                <img src="{{ $ovalUrl }}" alt="" class="h-full w-full object-cover" width="140" height="188" loading="lazy">
            </div>
        @endif

        <div class="relative z-[2] -mt-[64px] w-full bg-lum-ivory px-[20px] pb-[80px] pt-[128px]">
            <div class="mx-auto flex w-[335px] flex-col items-center">
                <div class="flex w-full flex-col items-center gap-[16px] text-center" data-lum-scroll-reveal>
                    <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                    <p class="font-serif text-[42px] leading-[45px] text-lum-espresso">{{ $quote }}</p>
                </div>

                @include('lum.partials.quote-clip-note', [
                    'img' => $img,
                    'size' => 'mob',
                    'note1' => $note1,
                    'note2' => $note2,
                ])
            </div>
        </div>
    </div>

    {{-- TABLET — Figma 73:658 + 73:660 --}}
    <div class="relative hidden tab:block desk:hidden">
        <div class="relative z-[1] h-[660px] overflow-hidden" data-lum-stay-wellness-hero>
            <img src="{{ $heroUrl }}" alt="" class="h-full w-full object-cover" width="960" height="660" loading="lazy">
        </div>

        @if ($ovalUrl)
            <div class="pointer-events-none absolute left-1/2 z-[3] h-[240px] w-[180px] -translate-x-1/2 overflow-hidden rounded-[50%]" style="top: 473px" data-lum-stay-wellness-oval>
                <img src="{{ $ovalUrl }}" alt="" class="h-full w-full object-cover" width="180" height="240" loading="lazy">
            </div>
        @endif

        <div class="relative z-[2] -mt-[64px] w-full bg-lum-ivory px-[20px] pb-[100px] pt-[152px]">
            <div class="mx-auto flex w-full max-w-[800px] flex-col items-center">
                <div class="flex flex-col items-center gap-[12px] text-center" data-lum-scroll-reveal>
                    <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8">
                    <p class="text-center font-serif text-[52px] leading-[52px] text-lum-espresso">{!! nl2br(e($quoteBreak)) !!}</p>
                </div>

                @include('lum.partials.quote-clip-note', [
                    'img' => $img,
                    'size' => 'tab',
                    'note1' => $note1,
                    'note2' => $note2,
                ])
            </div>
        </div>
    </div>

    {{-- DESKTOP — Figma 73:563 --}}
    <div class="relative hidden desk:block">
        <div class="relative h-[820px] w-full overflow-hidden" data-lum-stay-wellness-hero>
            <img src="{{ $heroUrl }}" alt="" class="h-full w-full object-cover" width="1920" height="820" loading="lazy">
        </div>

        @if ($ovalUrl)
            <div class="absolute left-1/2 top-[550px] z-[3] h-[430px] w-[320px] -translate-x-1/2 overflow-hidden rounded-[50%]" data-lum-stay-wellness-oval>
                <img src="{{ $ovalUrl }}" alt="" class="h-full w-full object-cover" width="320" height="430" loading="lazy">
            </div>
        @endif

        <div class="relative z-[2] flex flex-col items-center pb-[120px] pt-[320px]">
            <div class="flex flex-col items-center gap-[24px] text-center" data-lum-scroll-reveal>
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12">
                <p class="text-center font-serif text-[88px] leading-[94px] text-lum-espresso">{!! nl2br(e($quoteBreak)) !!}</p>
            </div>

            @include('lum.partials.quote-clip-note', [
                'img' => $img,
                'size' => 'desk',
                'note1' => $note1,
                'note2' => $note2,
            ])
        </div>
    </div>
</section>
