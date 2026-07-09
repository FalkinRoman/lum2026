@php
    $villasSlides = array_map(fn ($slide) => array_merge($slide, [
        'subtitle' => $slide['subtitle'] ?? __('lum.villas.subtitle'),
        'subtitleLine1' => $slide['subtitleLine1'] ?? __('lum.villas.subtitle_line1'),
        'subtitleLine2' => $slide['subtitleLine2'] ?? __('lum.villas.subtitle_line2'),
        'href' => route('villa.show', $slide['slug']),
    ]), trans('lum.villas.slides'));
    $villasLifestyle = '<span class="lum-script text-[24px] text-lum-green">' . e(__('lum.villas.lifestyle')) . ' </span>';
    $villasLifestyleTab = '<span class="lum-script text-[26px] text-lum-green">' . e(__('lum.villas.lifestyle')) . '</span>';
    $villasLifestyleDesk = '<span class="lum-script text-[28px] text-lum-green">' . e(__('lum.villas.lifestyle')) . '</span>';
    $villasStart = 0;
@endphp

<section
    id="villas"
    class="lum-container relative z-10 h-[939px] overflow-visible bg-lum-ivory tab:h-[1082px] desk:h-[1413px]"
    data-lum-villas-carousel
    data-slides='@json($villasSlides)'
    data-img-base="{{ asset('images/lum/villas') }}"
    data-start="{{ $villasStart }}"
>
    {{-- MOBILE — Figma 16:1479 + 16:1488 --}}
    <div class="relative h-full overflow-visible tab:hidden" data-lum-villas-panel data-lum-villas-suffix="-sm">
        <div class="absolute left-1/2 top-[44px] flex w-[335px] -translate-x-1/2 flex-col items-center gap-[16px] text-center">
            <p class="lum-text-3 font-medium uppercase text-lum-espresso">{{ __('lum.villas.eyebrow') }}</p>
            <img src="{{ $img('villas/divider.svg') }}" alt="" class="h-px w-full" width="335" height="1">
            <div class="text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">
                <p>{{ __('lum.villas.intro_mobile_1') }}</p>
                <p>{!! $villasLifestyle !!}{{ __('lum.villas.intro_mobile_2') }}</p>
                <p>{{ __('lum.villas.intro_mobile_3') }}</p>
                <p>{{ __('lum.villas.intro_mobile_4') }}</p>
                <p>{{ __('lum.villas.intro_mobile_5') }}</p>
            </div>
        </div>

        <div class="absolute left-0 top-[269px] h-[670px] w-full">
            <div class="relative h-[550px] w-full overflow-hidden" data-lum-villas-slider>
                <img src="{{ $img('villas/slide-01-sm.webp') }}" alt="" data-lum-villas-photo class="h-full w-full object-cover" width="375" height="550">
                <div class="absolute inset-0 bg-black/32"></div>
                <div class="absolute inset-y-0 left-0 w-[20px] backdrop-blur-[20px] bg-lum-ivory-40"></div>
                <div class="absolute inset-y-0 right-0 w-[20px] backdrop-blur-[20px] bg-lum-ivory-40"></div>

                <div class="absolute left-[111.5px] top-[28px] flex items-center gap-[16px] text-lum-ivory">
                    <span data-lum-villas-current class="font-serif text-[16px] font-medium leading-[20px] tracking-[-0.16px]">01</span>
                    <span class="h-px w-[86px] bg-lum-ivory-64"></span>
                    <span class="font-serif text-[16px] font-medium leading-[20px] tracking-[-0.16px] text-lum-ivory-64">04</span>
                </div>

                <div
                    class="pointer-events-none absolute left-1/2 top-[181px] w-[335px] max-w-[calc(100%-40px)] -translate-x-1/2 -translate-y-1/2 overflow-hidden text-center text-[14px] leading-[22px] tracking-[0.1px] text-lum-ivory-88"
                    data-lum-villas-mobile-subtitle
                >
                    <div class="relative w-full" data-lum-villas-mobile-subtitle-stage>
                        <div class="w-full text-center" data-lum-villas-mobile-subtitle-content>
                            <p class="m-0">{{ $villasSlides[$villasStart]['subtitleLine1'] }}</p>
                            <p class="m-0">{{ $villasSlides[$villasStart]['subtitleLine2'] }}</p>
                        </div>
                    </div>
                </div>

                <h2 class="absolute left-1/2 top-[275px] -translate-x-1/2 -translate-y-1/2 whitespace-nowrap text-center font-serif text-[56px] leading-[56px] text-lum-ivory">
                    <span data-lum-villas-title-normal class="font-normal">Lum</span><span data-lum-villas-title-italic class="font-medium italic"> Villas</span>
                </h2>
            </div>

            <div class="absolute left-[118px] top-[422px] z-20 h-[188px] w-[140px] overflow-hidden rounded-[50%]" data-lum-villas-oval-hit>
                <img src="{{ $img('villas/oval-01-sm.webp') }}" alt="" data-lum-villas-oval class="h-full w-full object-cover" width="140" height="188">
            </div>

            <button type="button" data-lum-villas-prev class="absolute left-[58px] top-[530px] z-20 lum-icon-btn lum-icon-btn--green-filled lum-icon-btn--carousel-40" aria-label="{{ __('lum.aria.previous') }}">
                <img src="{{ $img('ui/carousel-arrow-left.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </button>
            <button type="button" data-lum-villas-next class="absolute left-[278px] top-[530px] z-20 lum-icon-btn lum-icon-btn--green-filled lum-icon-btn--carousel-40" aria-label="{{ __('lum.aria.next') }}">
                <img src="{{ $img('ui/carousel-arrow-right.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </button>
        </div>
    </div>

    {{-- TABLET — Figma 16:949 --}}
    <div class="relative hidden h-full overflow-visible tab:block desk:hidden" data-lum-villas-panel>
        <div class="absolute left-1/2 top-[60px] flex w-[640px] -translate-x-1/2 flex-col items-center gap-[16px] text-center">
            <p class="lum-text-2 font-medium uppercase text-lum-espresso">{{ __('lum.villas.eyebrow') }}</p>
            <img src="{{ $img('villas/divider.svg') }}" alt="" class="h-px w-full" width="640" height="1">
            <div class="lum-text-2 text-lum-espresso">
                <p>{!! __('lum.villas.intro_tablet', ['lifestyle' => $villasLifestyleTab]) !!}</p>
                <p>{{ __('lum.villas.intro_tablet_2') }}</p>
                <p>{{ __('lum.villas.intro_tablet_3') }}</p>
            </div>
        </div>

        <div class="absolute left-0 top-[255px] h-[755px] w-full overflow-hidden" data-lum-villas-slider>
            <img src="{{ $img('villas/slide-01.webp') }}" alt="" data-lum-villas-photo class="h-full w-full object-cover" width="960" height="755">
            <div class="absolute inset-0 bg-black/32"></div>
            <div class="absolute inset-y-0 left-0 w-[20px] backdrop-blur-[20px] bg-lum-ivory-40"></div>
            <div class="absolute inset-y-0 right-0 w-[20px] backdrop-blur-[20px] bg-lum-ivory-40"></div>
        </div>

        <div class="absolute left-1/2 top-[295px] flex -translate-x-1/2 items-center gap-[16px] text-lum-ivory">
            <span data-lum-villas-current class="font-serif text-[16px] font-medium leading-[20px] tracking-[-0.16px]">01</span>
            <span class="h-px w-[64px] bg-lum-ivory-64"></span>
            <span class="font-serif text-[16px] font-medium leading-[20px] tracking-[-0.16px] text-lum-ivory-64">04</span>
        </div>

        <p data-lum-villas-subtitle class="absolute left-1/2 top-[523px] -translate-x-1/2 whitespace-nowrap lum-text-2 text-lum-ivory-88">
            {{ __('lum.villas.subtitle') }}
        </p>

        <h2 class="absolute left-1/2 top-[calc(50%+91px)] -translate-x-1/2 -translate-y-1/2 whitespace-nowrap text-center font-serif text-[80px] leading-[80px] text-lum-ivory">
            <span data-lum-villas-title-normal class="font-normal">Lum </span><span data-lum-villas-title-italic class="font-medium italic">Villas</span>
        </h2>

        <div class="absolute left-1/2 top-[842px] z-20 h-[240px] w-[180px] -translate-x-1/2 overflow-hidden rounded-[50%]" data-lum-villas-oval-hit>
            <img src="{{ $img('villas/oval-01.webp') }}" alt="" data-lum-villas-oval class="h-full w-full object-cover" width="180" height="240">
        </div>

        <button type="button" data-lum-villas-prev class="absolute left-[20px] top-[calc(50%+91px)] z-20 lum-icon-btn lum-icon-btn--ivory-filled lum-icon-btn--carousel-56 -translate-y-1/2" aria-label="{{ __('lum.aria.previous') }}">
            <img src="{{ $img('ui/carousel-arrow-left.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
        <button type="button" data-lum-villas-next class="absolute right-[20px] top-[calc(50%+91px)] z-20 lum-icon-btn lum-icon-btn--ivory-filled lum-icon-btn--carousel-56 -translate-y-1/2" aria-label="{{ __('lum.aria.next') }}">
            <img src="{{ $img('ui/carousel-arrow-right.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
    </div>

    {{-- DESKTOP — Figma 16:627 --}}
    <div class="relative hidden h-full overflow-visible desk:block" data-lum-villas-panel>
        <div class="absolute left-1/2 top-[80px] flex w-[530px] -translate-x-1/2 flex-col items-center gap-[24px] text-center">
            <p class="lum-eyebrow text-lum-espresso">{{ __('lum.villas.eyebrow') }}</p>
            <img src="{{ $img('villas/divider.svg') }}" alt="" class="h-[2px] w-full" width="530" height="2">
            <div class="lum-body text-lum-espresso">
                <p>{!! __('lum.villas.intro_desk_1', ['lifestyle' => $villasLifestyleDesk]) !!}</p>
                <p>{{ __('lum.villas.intro_desk_2') }}</p>
                <p>{{ __('lum.villas.intro_desk_3') }}</p>
                <p>{{ __('lum.villas.intro_desk_4') }}</p>
            </div>
        </div>

        <div
            class="absolute left-0 top-[333px] h-[1080px] w-full cursor-default overflow-hidden"
            data-lum-villas-slider
            data-lum-villas-slider-view
            data-lum-villas-view-safe-left="104"
            data-lum-villas-view-safe-right="72"
            data-lum-villas-view-safe-top="48"
            data-lum-villas-view-safe-bottom="48"
        >
            <img src="{{ $img('villas/slide-01.webp') }}" alt="" data-lum-villas-photo class="h-full w-full object-cover" width="1920" height="1080">
            <div class="pointer-events-none absolute inset-0 bg-black/32"></div>
            <div class="absolute inset-y-0 left-0 w-[32px] overflow-hidden pointer-events-none">
                <img src="{{ $img('villas/side-gradient.webp') }}" alt="" class="pointer-events-none absolute top-0 left-[-123px] h-full w-[617px] max-w-none object-cover" width="617" height="1080">
            </div>
            <div class="pointer-events-none absolute inset-y-0 left-[32px] w-[72px] backdrop-blur-[20px] bg-lum-ivory-40"></div>
            <div class="pointer-events-none absolute inset-y-0 right-0 w-[72px] backdrop-blur-[20px] bg-lum-ivory-40"></div>

            <div
                data-lum-villas-view-cursor
                class="lum-villas-view-cursor pointer-events-none absolute left-0 top-0 z-30 flex size-[88px] items-center justify-center rounded-[50px] bg-lum-ivory text-[16px] font-extrabold tracking-[3.2px] text-lum-espresso uppercase opacity-0"
                aria-hidden="true"
            >{{ __('lum.villas.view') }}</div>
        </div>

        <div class="pointer-events-none absolute left-1/2 top-[413px] flex -translate-x-1/2 items-center gap-[16px] text-lum-ivory">
            <span data-lum-villas-current class="font-serif text-[20px] font-medium leading-[24px] tracking-[-0.4px]">01</span>
            <span class="h-px w-[86px] bg-lum-ivory-64"></span>
            <span class="font-serif text-[20px] font-medium leading-[24px] tracking-[-0.4px] text-lum-ivory-64">04</span>
        </div>

        <p data-lum-villas-subtitle class="pointer-events-none absolute left-1/2 top-[698px] -translate-x-1/2 whitespace-nowrap lum-body text-lum-ivory-88">
            {{ __('lum.villas.subtitle') }}
        </p>

        <h2 class="pointer-events-none absolute left-1/2 top-[873px] -translate-x-1/2 -translate-y-1/2 whitespace-nowrap text-center font-serif text-[164px] leading-[170px] text-lum-ivory">
            <span data-lum-villas-title-normal class="font-normal">Lum </span><span data-lum-villas-title-italic class="font-medium italic">Villas</span>
        </h2>

        <div class="absolute left-1/2 top-[1143px] z-20 h-[430px] w-[320px] -translate-x-1/2 overflow-hidden rounded-[50%]" data-lum-villas-oval-hit>
            <img src="{{ $img('villas/oval-01.webp') }}" alt="" data-lum-villas-oval class="h-full w-full object-cover" width="320" height="430">
        </div>

        <button type="button" data-lum-villas-prev class="absolute left-[72px] top-[calc(50%+166.5px)] z-20 lum-icon-btn lum-icon-btn--ivory-filled lum-icon-btn--carousel-64 -translate-y-1/2" aria-label="{{ __('lum.aria.previous') }}">
            <img src="{{ $img('ui/carousel-arrow-left.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
        <button type="button" data-lum-villas-next class="absolute left-[1848px] top-[calc(50%+166.5px)] z-20 lum-icon-btn lum-icon-btn--ivory-filled lum-icon-btn--carousel-64 -translate-x-1/2 -translate-y-1/2" aria-label="{{ __('lum.aria.next') }}">
            <img src="{{ $img('ui/carousel-arrow-right.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>

        <a href="{{ route('villa.show', 'villas') }}" data-lum-villas-view-fixed class="absolute left-[1467px] top-[1129px] z-20 flex size-[88px] items-center justify-center rounded-[50px] bg-lum-ivory text-[16px] font-extrabold tracking-[3.2px] text-lum-espresso uppercase">{{ __('lum.villas.view') }}</a>
    </div>
</section>
