@php
    $cards = trans('lum.location.cards');
    $cardLayout = [
        [
            'width' => 'w-[550px]',
            'deskImg' => 'h-[160px] w-[273px]',
            'tabImg' => 'h-[128px] w-[218px]',
            'mobImg' => 'h-[96px] w-[163px]',
        ],
        [
            'width' => 'w-[549px]',
            'deskImg' => 'h-[269px] w-[273px]',
            'tabImg' => 'h-[214px] w-[218px]',
            'mobImg' => 'h-[160px] w-[163px]',
        ],
        [
            'width' => 'w-[550px]',
            'deskImg' => 'size-[240px]',
            'tabImg' => 'size-[200px]',
            'mobSize' => 140,
        ],
    ];
@endphp

<section class="lum-container relative bg-lum-ivory">
    {{-- MOBILE --}}
    <div class="relative tab:hidden">
        <img src="{{ $img('location/decor.svg') }}" alt="" class="absolute left-1/2 top-0 z-[1] h-[54px] w-[32px] -translate-x-1/2" width="32" height="54">
        <div class="relative z-0 flex flex-col items-center px-[20px] pb-[40px] pt-[78px] text-center" data-lum-scroll-reveal>
            <h2 class="w-[335px] font-serif text-[36px] leading-[45px] text-lum-espresso">
                {!! __('lum.location.heading') !!}
            </h2>
            <img src="{{ $img('location/divider.svg') }}" alt="" class="mt-[32px] h-px w-[335px]" width="335" height="1">
            <a href="#" class="lum-btn-dark relative z-[1] mt-[90px] px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.location.see_on_map') }}</a>
        </div>

        <div class="relative z-0 mx-auto flex w-[335px] flex-col gap-[24px] pb-[40px]">
            @foreach ($cards as $index => $card)
                @php
                    $layout = $cardLayout[$index];
                    $activeImgMobTop = $card['activeImgMobTop'] ?? null;
                    if (!empty($card['activeImgMobCenter'])) {
                        $tagBottom = $card['tagTop']['mob'] + 28;
                        $listTop = $card['listTop']['mob'];
                        $imgSize = $layout['mobSize']
                            ?? (preg_match('/(\d+)px/', $card['activeImgMob'] ?? '', $imgSizeMatch) ? (int) $imgSizeMatch[1] : 115);
                        $imgBox = ! empty($layout['mobSize'])
                            ? $imgSize
                            : $imgSize * (sin(deg2rad(15)) + cos(deg2rad(15)));
                        $activeImgMobTop = round(($tagBottom + $listTop) / 2 - $imgBox / 2 + ($card['activeImgMobTopShift'] ?? 0), 2);
                    }
                @endphp
                <article class="relative h-[420px] w-[335px] border border-dashed border-lum-espresso bg-lum-sand">
                    <div class="lum-location-card__bg">
                        <img src="{{ $img('location/dining-bg.svg') }}" alt="" class="absolute left-1/2 top-1/2 size-[780px] -translate-x-1/2 -translate-y-1/2 max-w-none" width="780" height="780">
                    </div>
                    @if ($card['activeImgRotate'])
                        @if (!empty($card['activeImgMobCenter']) && isset($activeImgMobTop) && !empty($layout['mobSize']))
                            <div class="absolute left-1/2 -translate-x-1/2" style="top: {{ $activeImgMobTop }}px">
                                <img
                                    src="{{ $img($card['activeImg']) }}"
                                    alt=""
                                    class="block object-contain"
                                    style="width: {{ $layout['mobSize'] }}px; height: {{ $layout['mobSize'] }}px; transform: rotate(-15deg)"
                                >
                            </div>
                        @else
                        <div @class(['absolute left-1/2 flex -translate-x-1/2 items-center justify-center', isset($activeImgMobTop) ? '' : 'top-1/2 -translate-y-1/2']) @if(isset($activeImgMobTop)) style="top: {{ $activeImgMobTop }}px" @endif>
                            <div class="-rotate-[15deg]">
                                <img src="{{ $img($card['activeImg']) }}" alt="" @class([$card['activeImgClass'], empty($layout['mobSize']) ? $layout['mobImg'] : null]) @if(!empty($layout['mobSize'])) style="width: {{ $layout['mobSize'] }}px; height: {{ $layout['mobSize'] }}px" @endif>
                            </div>
                        </div>
                        @endif
                    @else
                        <img src="{{ $img($card['activeImg']) }}" alt="" class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 {{ $card['activeImgClass'] }} {{ empty($layout['mobSize']) ? $layout['mobImg'] : '' }}" @if(!empty($layout['mobSize'])) style="width: {{ $layout['mobSize'] }}px; height: {{ $layout['mobSize'] }}px" @endif>
                    @endif
                    <h3 class="absolute left-1/2 top-[28px] -translate-x-1/2 font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso">{{ $card['title'] }}</h3>
                    @include('lum.partials.location-card-tag', [
                        'top' => $card['tagTop']['mob'],
                        'tag' => $card['tag'],
                        'padding' => app()->getLocale() === 'ru' ? 'px-[16px] py-[4px]' : 'px-[24px] py-[4px]',
                    ])
                    @include('lum.partials.location-card-list', ['top' => $card['listTop']['mob'], 'lines' => $card['listLines'], 'class' => 'text-[14px] leading-[22px] tracking-[0.1px]'])
                    <a href="{{ ! empty($card['route']) ? route($card['route']) : '#' }}" class="lum-btn lum-btn-info absolute left-1/2 top-[360px] -translate-x-1/2 px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.location.more_info') }}</a>
                </article>
            @endforeach
        </div>
        <div class="lum-divider mx-auto mb-0"></div>
    </div>

    {{-- TABLET --}}
    <div class="relative hidden tab:block desk:hidden">
        <img src="{{ $img('location/decor.svg') }}" alt="" class="absolute left-1/2 top-[60px] z-[1] h-[67px] w-[40px] -translate-x-1/2" width="40" height="67">
        <div class="relative z-0 flex flex-col items-center px-[20px] pb-[64px] pt-[172px] text-center" data-lum-scroll-reveal>
            <h2 class="w-[680px] font-serif text-[52px] leading-[52px] text-lum-espresso">
                {!! __('lum.location.heading') !!}
            </h2>
            <img src="{{ $img('location/divider.svg') }}" alt="" class="mt-[44px] h-[2px] w-[580px]" width="580" height="2">
            <a href="#" class="lum-btn-dark relative z-[1] mt-[118px] px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.location.see_on_map') }}</a>
        </div>

        <div class="relative z-0 mx-auto w-[920px] pb-[40px]">
            <div class="flex gap-[20px]">
                @foreach (array_slice($cards, 0, 2) as $index => $card)
                    @include('lum.partials.location-card-tablet', ['card' => $card, 'layout' => $cardLayout[$index]])
                @endforeach
            </div>
            @include('lum.partials.location-card-tablet', ['card' => $cards[2], 'layout' => $cardLayout[2], 'stacked' => true])
        </div>
        <div class="lum-divider mx-auto mb-0"></div>
    </div>

    {{-- DESKTOP --}}
    <div class="relative hidden desk:block">
        <svg class="pointer-events-none absolute size-0" aria-hidden="true">
            @foreach ($cards as $index => $card)
                <filter id="lum-location-filter-{{ $index }}">
                    <feTurbulence type="fractalNoise" baseFrequency="0.01 0.005" numOctaves="5" seed="{{ 2 + $index }}" result="noise" />
                    <feDisplacementMap in="SourceGraphic" in2="noise" scale="0" xChannelSelector="R" yChannelSelector="B" filterUnits="userSpaceOnUse" />
                </filter>
            @endforeach
        </svg>
        <img src="{{ $img('location/decor.svg') }}" alt="" class="absolute left-1/2 top-[240px] z-[1] h-[80px] w-[48px] -translate-x-1/2" width="48" height="80">
        <div class="relative z-0 flex flex-col items-center pb-[80px] pt-[357px] text-center" data-lum-scroll-reveal>
            <h2 class="w-[856px] lum-heading-1 text-lum-espresso">
                {!! __('lum.location.heading') !!}
            </h2>
            <img src="{{ $img('location/divider.svg') }}" alt="" class="mt-[44px] h-[2px] w-[856px]" width="856" height="2">
            <a href="#" class="lum-btn-dark relative z-[1] mt-[160px]">{{ __('lum.location.see_on_map') }}</a>
        </div>

        <div class="relative z-0 mx-auto flex w-[1776px] gap-[64px] pb-[60px]">
            @foreach ($cards as $index => $card)
                @php($layout = $cardLayout[$index])
                <article @class(['lum-location-card group relative h-[740px]', $layout['width']]) data-lum-location-card data-filter-id="lum-location-filter-{{ $index }}">
                    <div class="lum-location-card__photo absolute inset-0 overflow-hidden">
                        <img src="{{ $img($card['photo']) }}" alt="" class="lum-location-card__photo-img absolute inset-0 h-full w-full object-cover" data-lum-location-photo>
                        <div class="absolute inset-0 {{ $card['photoGradient'] }}"></div>
                        <div class="lum-location-card__photo-overlay absolute inset-0">
                            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-center text-lum-ivory">
                                @foreach ($card['photoLines'] as $line)
                                    <p @class(['lum-heading-3', 'font-normal italic' => $line['italic']])>{{ $line['text'] }}</p>
                                @endforeach
                            </div>
                            <div class="absolute bottom-[52px] left-1/2 flex -translate-x-1/2 flex-col items-center gap-[12px]">
                                <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                                <span class="lum-eyebrow text-lum-ivory">{{ $card['photoLabel'] }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="lum-location-card__active absolute inset-0">
                        <div class="lum-location-card__bg">
                            <img src="{{ $img('location/dining-bg.svg') }}" alt="" class="absolute left-1/2 top-1/2 size-[1280px] -translate-x-1/2 -translate-y-1/2 max-w-none" width="1280" height="1280">
                        </div>
                        @if ($card['activeImgRotate'])
                            <div class="absolute left-1/2 top-1/2 flex -translate-x-1/2 -translate-y-1/2 items-center justify-center" data-lum-reveal="1">
                                <div class="-rotate-[15deg]">
                                    <img src="{{ $img($card['activeImg']) }}" alt="" class="{{ $layout['deskImg'] }} {{ $card['activeImgClass'] }}">
                                </div>
                            </div>
                        @else
                            <img src="{{ $img($card['activeImg']) }}" alt="" class="absolute left-1/2 top-1/2 {{ $layout['deskImg'] }} -translate-x-1/2 -translate-y-1/2 {{ $card['activeImgClass'] }}" data-lum-reveal="1">
                        @endif
                        <h3 class="lum-heading-2 absolute left-1/2 top-[64px] -translate-x-1/2 text-lum-espresso" data-lum-reveal="2">{{ $card['title'] }}</h3>
                        @include('lum.partials.location-card-tag', ['top' => $card['tagTop']['desk'], 'tag' => $card['tag'], 'reveal' => 3])
                        @include('lum.partials.location-card-list', ['top' => $card['listTop']['desk'], 'lines' => $card['listLines'], 'reveal' => 4])
                        <a href="{{ ! empty($card['route']) ? route($card['route']) : '#' }}" class="lum-btn lum-btn-info absolute left-1/2 top-[640px] -translate-x-1/2" data-lum-reveal="5">{{ __('lum.location.more_info') }}</a>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="lum-divider mx-auto mb-0"></div>
    </div>
</section>
