@php
    $cards = [
        [
            'title' => 'Dining',
            'photo' => 'location/card-dining.jpg',
            'photoGradient' => 'bg-gradient-to-b from-[rgba(36,14,4,0.54)] from-[48%] to-transparent',
            'photoLines' => [
                ['text' => 'Flavors of Sri Lanka,', 'italic' => false],
                ['text' => 'thoughtfully prepared', 'italic' => true],
            ],
            'photoLabel' => 'Dining',
            'tag' => 'restaurants <span class="font-medium italic" style="white-space: nowrap;">worth</span> traveling for',
            'tagTop' => ['mob' => 56, 'tab' => 80, 'desk' => 128],
            'activeImg' => 'location/dining.webp',
            'activeImgClass' => 'object-cover opacity-90',
            'activeImgDesk' => 'h-[160px] w-[273px]',
            'activeImgTab' => 'h-[128px] w-[218px]',
            'activeImgMob' => 'h-[96px] w-[163px]',
            'activeImgRotate' => false,
            'listLines' => [
                'Lum Restaurant & Bar / Sandwich Spot /',
                'Rosenköster / Brute Wine & Bar',
            ],
            'listTop' => ['mob' => 292, 'tab' => 492, 'desk' => 566],
            'btn' => 'bg-lum-espresso',
            'width' => 'w-[550px]',
        ],
        [
            'title' => 'Relax',
            'photo' => 'location/card-yoga.jpg',
            'photoGradient' => 'bg-gradient-to-b from-[rgba(36,14,4,0.54)] from-[48%] to-transparent',
            'photoLines' => [
                ['text' => 'We offer private', 'italic' => false],
                ['text' => 'yoga sessions', 'italic' => true],
            ],
            'photoLabel' => 'Relax',
            'tag' => 'new energy from <span class="font-medium italic" style="white-space: nowrap;">old tradition</span>',
            'tagTop' => ['mob' => 56, 'tab' => 80, 'desk' => 128],
            'activeImg' => 'location/relax-sun.webp',
            'activeImgClass' => 'object-contain',
            'activeImgDesk' => 'h-[269px] w-[273px]',
            'activeImgTab' => 'h-[214px] w-[218px]',
            'activeImgMob' => 'h-[160px] w-[163px]',
            'activeImgRotate' => false,
            'listLines' => ['Yoga / Surfing / Padel'],
            'listTop' => ['mob' => 314, 'tab' => 517, 'desk' => 591],
            'btn' => 'bg-lum-green',
            'width' => 'w-[549px]',
        ],
        [
            'title' => 'Discover',
            'photo' => 'location/card-discover.jpg',
            'photoGradient' => 'bg-gradient-to-b from-transparent to-[rgba(22,5,5,0.48)]',
            'photoLines' => [
                ['text' => 'Sri Lanka as it', 'italic' => false],
                ['text' => 'used to be', 'italic' => true],
            ],
            'photoLabel' => 'discover',
            'tag' => 'welcome to the <span class="font-medium italic" style="white-space: nowrap;">true Sri Lanka</span>',
            'tagTop' => ['mob' => 56, 'tab' => 79, 'desk' => 128],
            'activeImg' => 'location/discover-map.webp',
            'activeImgClass' => 'object-cover',
            'activeImgDesk' => 'size-[240px]',
            'activeImgTab' => 'size-[200px]',
            'activeImgMobSize' => 140,
            'activeImgMobCenter' => true,
            'activeImgMobTopShift' => 0,
            'activeImgRotate' => true,
            'listLines' => [
                'Galle Fort / Koggala Lake /',
                'Mirissa / Dondra',
            ],
            'listTop' => ['mob' => 292, 'tab' => 492, 'desk' => 566],
            'btn' => 'bg-lum-green',
            'width' => 'w-[550px]',
        ],
    ];
@endphp

<section class="lum-container relative h-[1865px] bg-lum-ivory tab:h-[2102px] desk:h-[1939px]">
    {{-- MOBILE --}}
    <div class="relative h-full tab:hidden">
        <img src="{{ $img('location/decor.svg') }}" alt="" class="absolute left-1/2 top-0 h-[54px] w-[32px] -translate-x-1/2" width="32" height="54">
        <div class="absolute left-1/2 top-[78px] flex w-[335px] -translate-x-1/2 flex-col items-center gap-[32px] text-center">
            <h2 class="font-serif text-[36px] leading-[45px] text-lum-espresso">
                prime location in <span class="font-medium italic">Abangama</span> on the pristine southearn coast of <span class="font-medium italic">Sri Lanka</span>
            </h2>
            <img src="{{ $img('location/divider.svg') }}" alt="" class="h-px w-full" width="335" height="1">
        </div>
        <a href="#" class="lum-btn-dark absolute left-1/2 top-[380px] -translate-x-1/2 px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">See on map</a>

        <div class="absolute left-[20px] top-[476px] flex w-[335px] flex-col gap-[24px]">
            @foreach ($cards as $card)
                @php
                    $activeImgMobTop = $card['activeImgMobTop'] ?? null;
                    if (!empty($card['activeImgMobCenter'])) {
                        $tagBottom = $card['tagTop']['mob'] + 28;
                        $listTop = $card['listTop']['mob'];
                        $imgSize = $card['activeImgMobSize']
                            ?? (preg_match('/(\d+)px/', $card['activeImgMob'] ?? '', $imgSizeMatch) ? (int) $imgSizeMatch[1] : 115);
                        $imgBox = ! empty($card['activeImgMobSize'])
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
                        @if (!empty($card['activeImgMobCenter']) && isset($activeImgMobTop) && !empty($card['activeImgMobSize']))
                            <div class="absolute left-1/2 -translate-x-1/2" style="top: {{ $activeImgMobTop }}px">
                                <img
                                    src="{{ $img($card['activeImg']) }}"
                                    alt=""
                                    class="block object-contain"
                                    style="width: {{ $card['activeImgMobSize'] }}px; height: {{ $card['activeImgMobSize'] }}px; transform: rotate(-15deg)"
                                >
                            </div>
                        @else
                        <div @class(['absolute left-1/2 flex -translate-x-1/2 items-center justify-center', isset($activeImgMobTop) ? '' : 'top-1/2 -translate-y-1/2']) @if(isset($activeImgMobTop)) style="top: {{ $activeImgMobTop }}px" @endif>
                            <div class="-rotate-[15deg]">
                                <img src="{{ $img($card['activeImg']) }}" alt="" @class([$card['activeImgClass'], empty($card['activeImgMobSize']) ? $card['activeImgMob'] : null]) @if(!empty($card['activeImgMobSize'])) style="width: {{ $card['activeImgMobSize'] }}px; height: {{ $card['activeImgMobSize'] }}px" @endif>
                            </div>
                        </div>
                        @endif
                    @else
                        <img src="{{ $img($card['activeImg']) }}" alt="" class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 {{ $card['activeImgClass'] }} {{ empty($card['activeImgMobSize']) ? $card['activeImgMob'] : '' }}" @if(!empty($card['activeImgMobSize'])) style="width: {{ $card['activeImgMobSize'] }}px; height: {{ $card['activeImgMobSize'] }}px" @endif>
                    @endif
                    <h3 class="absolute left-1/2 top-[28px] -translate-x-1/2 font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso">{{ $card['title'] }}</h3>
                    @include('lum.partials.location-card-tag', ['top' => $card['tagTop']['mob'], 'tag' => $card['tag'], 'padding' => 'px-[24px] py-[4px]'])
                    @include('lum.partials.location-card-list', ['top' => $card['listTop']['mob'], 'lines' => $card['listLines'], 'class' => 'text-[14px] leading-[22px] tracking-[0.1px]'])
                    <a href="#" class="lum-btn absolute left-1/2 top-[360px] -translate-x-1/2 {{ $card['btn'] }} px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px] text-lum-ivory">more info</a>
                </article>
            @endforeach
        </div>
        <div class="lum-divider absolute bottom-0 left-[20px]"></div>
    </div>

    {{-- TABLET --}}
    <div class="relative hidden h-full tab:block desk:hidden">
        <img src="{{ $img('location/decor.svg') }}" alt="" class="absolute left-1/2 top-[60px] h-[67px] w-[40px] -translate-x-1/2" width="40" height="67">
        <div class="absolute left-1/2 top-[172px] flex w-[680px] -translate-x-1/2 flex-col items-center gap-[44px] text-center">
            <h2 class="font-serif text-[52px] leading-[52px] text-lum-espresso">
                prime location in <span class="font-medium italic">Abangama</span> on the pristine southearn coast of <span class="font-medium italic">Sri Lanka</span>
            </h2>
            <img src="{{ $img('location/divider.svg') }}" alt="" class="h-[2px] w-[580px]" width="580" height="2">
        </div>
        <a href="#" class="lum-btn-dark absolute left-1/2 top-[490px] -translate-x-1/2 px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">See on map</a>

        <div class="absolute left-[20px] top-[642px] w-[920px]">
            <div class="flex gap-[20px]">
                @foreach (array_slice($cards, 0, 2) as $card)
                    @include('lum.partials.location-card-tablet', ['card' => $card])
                @endforeach
            </div>
            @include('lum.partials.location-card-tablet', ['card' => $cards[2], 'stacked' => true])
        </div>
        <div class="lum-divider absolute bottom-0 left-[20px]"></div>
    </div>

    {{-- DESKTOP --}}
    <div class="relative hidden h-full desk:block">
        <svg class="pointer-events-none absolute size-0" aria-hidden="true">
            @foreach ($cards as $index => $card)
                <filter id="lum-location-filter-{{ $index }}">
                    <feTurbulence type="fractalNoise" baseFrequency="0.01 0.005" numOctaves="5" seed="{{ 2 + $index }}" result="noise" />
                    <feDisplacementMap in="SourceGraphic" in2="noise" scale="0" xChannelSelector="R" yChannelSelector="B" filterUnits="userSpaceOnUse" />
                </filter>
            @endforeach
        </svg>
        <img src="{{ $img('location/decor.svg') }}" alt="" class="absolute left-1/2 top-[240px] h-[80px] w-[48px] -translate-x-1/2" width="48" height="80">
        <div class="absolute left-[532px] top-[357px] flex w-[856px] flex-col items-center gap-[44px] text-center">
            <h2 class="lum-heading-1 text-lum-espresso">
                prime location in <span class="font-medium italic">Abangama</span> on the pristine southearn coast of <span class="font-medium italic">Sri Lanka</span>
            </h2>
            <img src="{{ $img('location/divider.svg') }}" alt="" class="h-[2px] w-full" width="856" height="2">
        </div>
        <a href="#" class="lum-btn-dark absolute left-1/2 top-[843px] -translate-x-1/2">See on map</a>

        <div class="absolute left-[72px] top-[1039px] flex gap-[64px]">
            @foreach ($cards as $index => $card)
                <article @class(['lum-location-card group relative h-[740px]', $card['width']]) data-lum-location-card data-filter-id="lum-location-filter-{{ $index }}">
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
                                    <img src="{{ $img($card['activeImg']) }}" alt="" class="{{ $card['activeImgDesk'] }} {{ $card['activeImgClass'] }}">
                                </div>
                            </div>
                        @else
                            <img src="{{ $img($card['activeImg']) }}" alt="" class="absolute left-1/2 top-1/2 {{ $card['activeImgDesk'] }} -translate-x-1/2 -translate-y-1/2 {{ $card['activeImgClass'] }}" data-lum-reveal="1">
                        @endif
                        <h3 class="lum-heading-2 absolute left-1/2 top-[64px] -translate-x-1/2 text-lum-espresso" data-lum-reveal="2">{{ $card['title'] }}</h3>
                        @include('lum.partials.location-card-tag', ['top' => $card['tagTop']['desk'], 'tag' => $card['tag'], 'reveal' => 3])
                        @include('lum.partials.location-card-list', ['top' => $card['listTop']['desk'], 'lines' => $card['listLines'], 'reveal' => 4])
                        <a href="#" class="lum-btn absolute left-1/2 top-[640px] -translate-x-1/2 {{ $card['btn'] }} text-lum-ivory" data-lum-reveal="5">more info</a>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="lum-divider absolute bottom-0 left-[72px]"></div>
    </div>
</section>
