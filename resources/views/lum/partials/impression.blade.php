@php
    $variant = $variant ?? 'home';
    $titleKey = $titleKey ?? 'lum.interior';
    $imgBase = $imgBase ?? 'interior';
    $showLogomark = $showLogomark ?? ($variant === 'home');
    $showCta = $showCta ?? false;
    $showTabs = $showTabs ?? true;
    $startIndex = $startIndex ?? 0;

    $sectionHeights = match (true) {
        ! $showTabs && $variant === 'villa' => 'h-[700px] tab:h-[1080px] desk:h-[1336px]',
        $variant === 'villa' => 'h-[856px] tab:h-[1324px] desk:h-[1555px]',
        default => 'h-[827px] tab:h-[1317px] desk:h-[1527px]',
    };

    $tabLabels = trans($titleKey . '.tabs');
    $tabs = [];
    foreach ($tabLabels as $i => $label) {
        $tabs[($i === 0 ? '✓' : '') . $label] = $i === 0;
    }
    $mobileTabRows = [
        array_slice($tabs, 0, 2, true),
        array_slice($tabs, 2, 3, true),
        array_slice($tabs, 5, 1, true),
    ];
    $slides = ['slide-01', 'slide-02', 'slide-03', 'slide-04'];
    $total = 7;
@endphp

<section
    class="lum-container relative bg-lum-ivory {{ $sectionHeights }}"
    data-lum-interior-carousel
    data-slides='@json($slides)'
    data-img-base="{{ asset('images/lum/' . $imgBase) }}"
    data-total="{{ $total }}"
    data-start="{{ $startIndex }}"
>
    {{-- MOBILE --}}
    <div class="relative h-full tab:hidden" data-lum-interior-panel data-lum-interior-suffix="-sm">
        @if ($showTabs)
        @if ($showLogomark)
            <img src="{{ $img('interior/logomark.svg') }}" alt="" class="absolute left-1/2 top-[45px] size-[32px] -translate-x-1/2" width="32" height="32">
        @endif
        <div @class(['absolute left-1/2 -translate-x-1/2 text-center text-lum-espresso', 'top-[107px]' => $showLogomark, 'top-[60px]' => ! $showLogomark]) data-lum-scroll-reveal>
            <p class="font-serif text-[36px] font-medium italic leading-[45px] tracking-[-0.72px]">{{ __($titleKey . '.title_normal') }}</p>
            <p class="font-serif text-[36px] leading-[45px] tracking-[-0.72px]">{{ __($titleKey . '.title_caps') }}</p>
        </div>
        <div @class(['absolute left-1/2 h-[41px] w-[201px] -translate-x-1/2 -rotate-[1.4deg] bg-lum-orange opacity-56 shadow-[3px_3px_0_rgba(0,0,0,0.25)]', 'top-[172px]' => $showLogomark, 'top-[124px]' => ! $showLogomark])></div>
        <div @class(['absolute left-0 z-20 flex w-full flex-col items-center gap-[8px]', 'top-[252px]' => $showLogomark, 'top-[205px]' => ! $showLogomark])>
            @foreach ($mobileTabRows as $row)
                <div class="flex items-center justify-center gap-[8px]">
                    @foreach ($row as $label => $active)
                        <button type="button" @class(['lum-tab lum-tab--s', 'lum-tab--active' => $active, 'lum-tab--inactive' => ! $active])>{{ $label }}</button>
                    @endforeach
                </div>
            @endforeach
        </div>
        <div @class(['absolute left-0 z-0 w-full', 'top-[388px]' => $showLogomark, 'top-[341px]' => ! $showLogomark])>
            <div
                data-lum-interior-single
                class="relative z-0 h-[260px] w-full overflow-hidden shadow-[3px_3px_0_rgba(0,0,0,0.25)]"
            >
                <img
                    src="{{ $img($imgBase . '/slide-01-sm.webp') }}"
                    alt=""
                    class="h-full w-full object-cover"
                    width="375"
                    height="260"
                >
            </div>
            <div class="absolute left-1/2 top-[260px] z-30 flex -translate-x-1/2 -translate-y-1/2 gap-[10px]">
                <button type="button" data-lum-interior-prev class="z-20 lum-icon-btn lum-icon-btn--green-filled lum-icon-btn--carousel-40" aria-label="{{ __('lum.aria.previous') }}">
                    <img src="{{ $img('ui/carousel-arrow-left.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                </button>
                <button type="button" data-lum-interior-next class="z-20 lum-icon-btn lum-icon-btn--green-filled lum-icon-btn--carousel-40" aria-label="{{ __('lum.aria.next') }}">
                    <img src="{{ $img('ui/carousel-arrow-right.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                </button>
            </div>
        </div>
        <div @class(['absolute left-1/2 flex w-[280px] -translate-x-1/2 flex-col items-center gap-[16px]', 'top-[692px]' => $showLogomark, 'top-[645px]' => ! $showLogomark])>
            @include('lum.partials.interior-progress', ['total' => $total, 'startIndex' => $startIndex, 'itemClass' => 'w-[33px]', 'gapClass' => 'gap-[8px]'])
            <p class="font-serif text-[16px] font-medium leading-[20px] tracking-[-0.16px] text-lum-espresso">
                <span class="lum-interior-counter" data-lum-interior-current><span class="lum-interior-counter__viewport"><span class="lum-interior-counter__text" data-lum-interior-current-text>{{ str_pad($startIndex + 1, 2, '0', STR_PAD_LEFT) }}</span></span></span> <span class="text-lum-espresso-40">/ {{ str_pad($total, 2, '0', STR_PAD_LEFT) }}</span>
            </p>
        </div>
        @if ($showCta)
            <a href="#" @class(['lum-btn-green absolute left-1/2 -translate-x-1/2 whitespace-nowrap px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]', 'top-[744px]' => $showLogomark, 'top-[697px]' => ! $showLogomark]) data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.12">{{ $ctaLabel ?? __('lum.nav.take_a_break') }}</a>
        @endif
        @else
        {{-- MOBILE excursion — Figma 103:907 --}}
        <div class="absolute left-1/2 top-[60px] -translate-x-1/2 text-center text-lum-espresso" data-lum-scroll-reveal>
            <p class="font-serif text-[42px] font-medium italic leading-[45px] tracking-[-0.84px]">{{ __($titleKey . '.title_normal') }}</p>
            <p class="font-serif text-[42px] leading-[45px] tracking-[-0.84px]">{{ __($titleKey . '.title_caps') }}</p>
        </div>
        <div class="absolute left-1/2 top-[119px] h-[36px] w-[260px] -translate-x-1/2 -rotate-[1.4deg] bg-lum-orange opacity-56 shadow-[1.33px_1.33px_0_rgba(0,0,0,0.25)]"></div>
        <div
            data-lum-interior-single
            class="absolute left-0 top-[205px] z-0 h-[260px] w-full overflow-hidden shadow-[3px_3px_0_rgba(0,0,0,0.25)]"
        >
            <img
                src="{{ $img($imgBase . '/slide-01-sm.webp') }}"
                alt=""
                class="h-full w-full object-cover"
                width="375"
                height="260"
            >
        </div>
        <div class="absolute left-[143px] top-[445px] z-30 flex gap-[10px]">
            <button type="button" data-lum-interior-prev class="z-20 lum-icon-btn lum-icon-btn--green-filled lum-icon-btn--carousel-40" aria-label="{{ __('lum.aria.previous') }}">
                <img src="{{ $img('ui/carousel-arrow-left.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </button>
            <button type="button" data-lum-interior-next class="z-20 lum-icon-btn lum-icon-btn--green-filled lum-icon-btn--carousel-40" aria-label="{{ __('lum.aria.next') }}">
                <img src="{{ $img('ui/carousel-arrow-right.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </button>
        </div>
        <div class="absolute left-[48px] top-[509px] flex w-[280px] flex-col items-center gap-[16px]">
            @include('lum.partials.interior-progress', ['total' => $total, 'startIndex' => $startIndex, 'itemClass' => 'flex-1', 'gapClass' => 'gap-[8px]'])
            <p class="font-serif text-[16px] font-medium leading-[20px] tracking-[-0.16px] text-lum-espresso">
                <span class="lum-interior-counter" data-lum-interior-current><span class="lum-interior-counter__viewport"><span class="lum-interior-counter__text" data-lum-interior-current-text>{{ str_pad($startIndex + 1, 2, '0', STR_PAD_LEFT) }}</span></span></span> <span class="text-lum-espresso-40">/ {{ str_pad($total, 2, '0', STR_PAD_LEFT) }}</span>
            </p>
        </div>
        @if ($showCta)
            <a href="#" class="lum-btn-green absolute left-1/2 top-[585px] -translate-x-1/2 whitespace-nowrap px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ $ctaLabel ?? __('lum.nav.take_a_break') }}</a>
        @endif
        @endif
    </div>

    {{-- TABLET --}}
    <div class="relative hidden h-full tab:block desk:hidden" data-lum-interior-panel>
        @if ($showLogomark)
            <img src="{{ $img('interior/logomark.svg') }}" alt="" class="absolute left-1/2 top-[61px] size-[40px] -translate-x-1/2" width="40" height="40">
        @endif
        <div @class(['absolute left-1/2 -translate-x-1/2 text-center text-lum-espresso', 'top-[145px]' => $showLogomark && $showTabs, 'top-[80px]' => ! $showLogomark || ! $showTabs]) data-lum-scroll-reveal>
            <p class="font-serif text-[52px] font-medium italic leading-[52px] tracking-[-1.04px]">{{ __($titleKey . '.title_normal') }}</p>
            <p class="font-serif text-[52px] leading-[52px] tracking-[-1.04px]">{{ __($titleKey . '.title_caps') }}</p>
        </div>
        <div @class(['absolute left-1/2 h-[71px] w-[281px] -translate-x-1/2 -rotate-[1.4deg] bg-lum-orange opacity-56 shadow-[3px_3px_0_rgba(0,0,0,0.25)]', 'top-[217px]' => $showLogomark && $showTabs, 'top-[151px]' => ! $showLogomark && $showTabs, 'top-[144px]' => ! $showTabs])></div>
        @if ($showTabs)
        <div @class(['absolute flex flex-nowrap items-center gap-[10px]', 'left-[127px] top-[325px]' => $showLogomark, 'left-[127px] top-[260px]' => ! $showLogomark])>
            @foreach ($tabs as $label => $active)
                <button type="button" @class(['lum-tab lum-tab--s', 'lum-tab--active' => $active, 'lum-tab--inactive' => ! $active])>{{ $label }}</button>
            @endforeach
        </div>
        @endif
        <div
            data-lum-interior-single
            @class(['absolute left-0 h-[641px] w-full overflow-hidden shadow-[3px_3px_0_rgba(0,0,0,0.25)]', 'top-[421px]' => $showLogomark && $showTabs, 'top-[356px]' => ! $showLogomark && $showTabs, 'top-[260px]' => ! $showTabs])
        >
            <img
                src="{{ $img($imgBase . '/slide-01.webp') }}"
                alt=""
                class="h-full w-full object-cover"
                width="960"
                height="641"
            >
        </div>
        @if ($showTabs)
        <button type="button" data-lum-interior-prev @class(['z-20 absolute lum-icon-btn lum-icon-btn--green-filled lum-icon-btn--carousel-56', 'left-[414px] top-[1034px]' => $showLogomark, 'left-[414px] top-[969px]' => ! $showLogomark]) aria-label="{{ __('lum.aria.previous') }}">
            <img src="{{ $img('ui/carousel-arrow-left.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
        <button type="button" data-lum-interior-next @class(['z-20 absolute lum-icon-btn lum-icon-btn--green-filled lum-icon-btn--carousel-56', 'left-[490px] top-[1034px]' => $showLogomark, 'left-[490px] top-[969px]' => ! $showLogomark]) aria-label="{{ __('lum.aria.next') }}">
            <img src="{{ $img('ui/carousel-arrow-right.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
        @else
        <div class="absolute left-1/2 top-[873px] flex -translate-x-1/2 gap-[20px]">
            <button type="button" data-lum-interior-prev class="z-20 lum-icon-btn lum-icon-btn--green-filled lum-icon-btn--carousel-56" aria-label="{{ __('lum.aria.previous') }}">
                <img src="{{ $img('ui/carousel-arrow-left.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </button>
            <button type="button" data-lum-interior-next class="z-20 lum-icon-btn lum-icon-btn--green-filled lum-icon-btn--carousel-56" aria-label="{{ __('lum.aria.next') }}">
                <img src="{{ $img('ui/carousel-arrow-right.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </button>
        </div>
        @endif
        <div @class(['absolute left-1/2 flex w-[378px] -translate-x-1/2 flex-col items-center gap-[24px]', 'top-[1134px]' => $showLogomark && $showTabs, 'top-[1069px]' => ! $showLogomark && $showTabs, 'top-[973px]' => ! $showTabs])>
            @include('lum.partials.interior-progress', ['total' => $total, 'startIndex' => $startIndex, 'itemClass' => 'w-[42px]', 'gapClass' => 'gap-[14px]'])
            <p class="font-serif text-[20px] font-medium leading-[24px] tracking-[-0.4px] text-lum-espresso">
                <span class="lum-interior-counter" data-lum-interior-current><span class="lum-interior-counter__viewport"><span class="lum-interior-counter__text" data-lum-interior-current-text>{{ str_pad($startIndex + 1, 2, '0', STR_PAD_LEFT) }}</span></span></span> <span class="text-lum-espresso-40">/ {{ str_pad($total, 2, '0', STR_PAD_LEFT) }}</span>
            </p>
        </div>
        @if ($showCta)
            <a href="#" @class(['lum-btn-green absolute left-1/2 -translate-x-1/2 whitespace-nowrap px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]', 'top-[1212px]' => $showLogomark && $showTabs, 'top-[1057px]' => ! $showTabs, 'top-[1147px]' => ! $showLogomark && $showTabs]) @if($showTabs) data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.12" @endif>{{ $ctaLabel ?? __('lum.nav.take_a_break') }}</a>
        @endif
    </div>

    {{-- DESKTOP --}}
    <div class="relative hidden h-full desk:block" data-lum-interior-panel>
        @if ($showLogomark)
            <img src="{{ $img('interior/logomark.svg') }}" alt="" class="absolute left-1/2 top-[80px] size-[64px] -translate-x-1/2" width="64" height="64">
        @endif
        <div @class(['absolute left-1/2 -translate-x-1/2 text-center text-lum-espresso', 'top-[208px]' => $showLogomark && $showTabs, 'top-[160px]' => ! $showLogomark && $showTabs, 'top-[160px]' => ! $showTabs]) data-lum-scroll-reveal>
            <p class="lum-heading-1 font-medium italic tracking-[-1.76px]">{{ __($titleKey . '.title_normal') }}</p>
            <p class="lum-heading-1 font-normal tracking-[-1.76px]">{{ __($titleKey . '.title_caps') }}</p>
        </div>
        <div @class(['absolute left-1/2 h-[80px] w-[440px] -translate-x-1/2 -rotate-[1.4deg] bg-lum-orange opacity-56 shadow-[3px_3px_0_rgba(0,0,0,0.25)]', 'top-[328.64px]' => $showLogomark && $showTabs, 'top-[292px]' => ! $showLogomark && $showTabs, 'top-[279px]' => ! $showTabs])></div>
        @if ($showTabs)
        <div @class(['absolute left-1/2 flex -translate-x-1/2 flex-nowrap items-center gap-[10px]', 'top-[484px]' => $showLogomark, 'top-[436px]' => ! $showLogomark])>
            @foreach ($tabs as $label => $active)
                <button type="button" @class(['lum-tab lum-tab--l', 'lum-tab--active' => $active, 'lum-tab--inactive' => ! $active])>{{ $label }}</button>
            @endforeach
        </div>
        @endif
        <div
            @class(['absolute left-0 h-[620px] w-[928px] overflow-hidden shadow-[3px_3px_0_rgba(0,0,0,0.25)]', 'top-[605px]' => $showLogomark && $showTabs, 'top-[556px]' => ! $showLogomark && $showTabs, 'top-[493px]' => ! $showTabs])
            data-lum-interior-left
        >
            <img
                src="{{ $img($imgBase . '/slide-01.webp') }}"
                alt=""
                class="h-full w-full object-cover"
                width="928"
                height="620"
            >
        </div>
        <div
            @class(['absolute left-[992px] h-[620px] w-[928px] overflow-hidden shadow-[3px_3px_0_rgba(0,0,0,0.25)]', 'top-[604px]' => $showLogomark && $showTabs, 'top-[556px]' => ! $showLogomark && $showTabs, 'top-[493px]' => ! $showTabs])
            data-lum-interior-right
        >
            <img
                src="{{ $img($imgBase . '/slide-02.webp') }}"
                alt=""
                class="h-full w-full object-cover"
                width="928"
                height="620"
            >
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[rgba(22,5,5,0.48)]"></div>
        </div>
        <button type="button" data-lum-interior-prev @class(['z-20 absolute lum-icon-btn lum-icon-btn--ivory-filled lum-icon-btn--carousel-64', 'left-[72px] top-[884px]' => $showLogomark && $showTabs, 'left-[136px] top-[836px]' => ! $showLogomark && $showTabs, 'left-[72px] top-[773px]' => ! $showTabs]) aria-label="{{ __('lum.aria.previous') }}">
            <img src="{{ $img('ui/carousel-arrow-left.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
        <button type="button" data-lum-interior-next @class(['z-20 absolute lum-icon-btn lum-icon-btn--ivory-filled lum-icon-btn--carousel-64', 'left-[1784px] top-[884px]' => $showLogomark && $showTabs, 'left-[1784px] top-[836px]' => ! $showLogomark && $showTabs, 'left-[1784px] top-[773px]' => ! $showTabs]) aria-label="{{ __('lum.aria.next') }}">
            <img src="{{ $img('ui/carousel-arrow-right.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
        <div @class(['absolute left-[771px] flex w-[378px] flex-col items-center gap-[24px]', 'top-[1300px]' => $showLogomark && $showTabs, 'top-[1252px]' => ! $showLogomark && $showTabs, 'top-[1189px]' => ! $showTabs])>
            @include('lum.partials.interior-progress', ['total' => $total, 'startIndex' => $startIndex, 'itemClass' => 'w-[42px]', 'gapClass' => 'gap-[14px]'])
            <p class="font-serif text-[20px] font-medium leading-[24px] tracking-[-0.4px] text-lum-espresso">
                <span class="lum-interior-counter" data-lum-interior-current><span class="lum-interior-counter__viewport"><span class="lum-interior-counter__text" data-lum-interior-current-text>{{ str_pad($startIndex + 1, 2, '0', STR_PAD_LEFT) }}</span></span></span> <span class="text-lum-espresso-40">/ {{ str_pad($total, 2, '0', STR_PAD_LEFT) }}</span>
            </p>
        </div>
        @if ($showCta)
            <a href="#" @class(['lum-btn-green absolute left-1/2 -translate-x-1/2 whitespace-nowrap px-[34px] pt-[6px] pb-[5px] text-[16px] leading-[25px] tracking-[3.2px]', 'top-[1399px]' => $showLogomark && $showTabs, 'top-[1280px]' => ! $showTabs, 'top-[1351px]' => ! $showLogomark && $showTabs]) @if($showTabs) data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.12" @endif>{{ $ctaLabel ?? __('lum.nav.take_a_break') }}</a>
        @endif
    </div>
</section>
