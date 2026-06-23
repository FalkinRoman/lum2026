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
            'tag' => 'restaurants <span class="italic">worth</span> traveling for',
            'activeImg' => 'location/dining.png',
            'activeImgClass' => 'object-cover opacity-90',
            'activeImgDesk' => 'h-[160px] w-[273px]',
            'activeImgTab' => 'h-[128px] w-[218px]',
            'activeImgMob' => 'w-[163px] h-[96px]',
            'activeImgMobTop' => '162px',
            'list' => 'Lum Restaurant & Bar / Sandwich Spot / Rosenköster / Brute Wine & Bar',
            'listBr' => 'Lum Restaurant & Bar / Sandwich Spot /<br>Rosenköster / Brute Wine & Bar',
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
            'tag' => 'new energy from <span class="italic">old tradition</span>',
            'activeImg' => 'location/relax-sun.png',
            'activeImgClass' => 'object-contain',
            'activeImgDesk' => 'h-[214px] w-[218px]',
            'activeImgTab' => 'h-[214px] w-[218px]',
            'activeImgMob' => 'w-[163px] h-[160px]',
            'activeImgMobTop' => '130px',
            'list' => 'Yoga / Surfing / Padel',
            'listBr' => 'Yoga / Surfing / Padel',
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
            'tag' => 'welcome to the <span class="italic">true Sri Lanka</span>',
            'activeImg' => 'location/discover-map.png',
            'activeImgClass' => 'object-cover -rotate-[15deg]',
            'activeImgDesk' => 'size-[240px]',
            'activeImgTab' => 'size-[240px]',
            'activeImgMob' => 'size-[171px]',
            'activeImgMobTop' => '137px',
            'list' => 'Galle Fort / Koggala Lake / Mirissa / Dondra',
            'listBr' => 'Galle Fort / Koggala Lake /<br>Mirissa / Dondra',
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
                <article class="relative h-[420px] w-[335px] overflow-hidden border border-dashed border-lum-espresso bg-lum-sand">
                    <img src="{{ $img('location/dining-bg.svg') }}" alt="" class="pointer-events-none absolute left-1/2 top-1/2 size-[780px] -translate-x-1/2 -translate-y-1/2 max-w-none" width="780" height="780">
                    <img src="{{ $img($card['activeImg']) }}" alt="" class="absolute left-1/2 {{ $card['activeImgMob'] }} {{ $card['activeImgClass'] }}" style="top: {{ $card['activeImgMobTop'] }}; transform: translateX(-50%);">
                    <h3 class="absolute left-1/2 top-[28px] -translate-x-1/2 font-serif text-[28px] leading-[28px] text-lum-espresso">{{ $card['title'] }}</h3>
                    <div class="lum-location-card__tag absolute left-1/2 top-[56px] w-max max-w-none -translate-x-1/2 rotate-[1deg] bg-lum-cream px-[16px] py-[1px]">
                        <p class="whitespace-nowrap font-serif text-[14px] leading-[20px] tracking-[-0.4px] text-lum-espresso">{!! $card['tag'] !!}</p>
                    </div>
                    <p class="absolute left-1/2 top-[292px] w-[245px] -translate-x-1/2 text-center text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">{{ $card['list'] }}</p>
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
                    <article class="relative h-[650px] w-[450px] overflow-hidden border border-dashed border-lum-espresso bg-lum-sand">
                        <img src="{{ $img('location/dining-bg.svg') }}" alt="" class="pointer-events-none absolute left-1/2 top-1/2 size-[1048px] -translate-x-1/2 -translate-y-1/2 max-w-none" width="1048" height="1048">
                        <img src="{{ $img($card['activeImg']) }}" alt="" class="absolute left-1/2 top-1/2 {{ $card['activeImgTab'] }} -translate-x-1/2 -translate-y-1/2 {{ $card['activeImgClass'] }}">
                        <h3 class="absolute left-1/2 top-[44px] -translate-x-1/2 font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">{{ $card['title'] }}</h3>
                        <div class="lum-location-card__tag absolute left-1/2 top-[80px] w-max max-w-none -translate-x-1/2 rotate-[1deg] bg-lum-cream px-[48px] py-[4px]">
                            <p class="whitespace-nowrap font-serif text-[20px] leading-[24px] tracking-[-0.4px] text-lum-espresso">{!! $card['tag'] !!}</p>
                        </div>
                        <p class="absolute left-1/2 top-[492px] -translate-x-1/2 text-center lum-text-2 text-lum-espresso">{!! $card['listBr'] !!}</p>
                        <a href="#" class="lum-btn absolute left-1/2 top-[574px] -translate-x-1/2 {{ $card['btn'] }} px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px] text-lum-ivory">more info</a>
                    </article>
                @endforeach
            </div>
            @php $card = $cards[2]; @endphp
            <article class="relative mt-[40px] h-[650px] w-[450px] overflow-hidden border border-dashed border-lum-espresso bg-lum-sand">
                <img src="{{ $img('location/dining-bg.svg') }}" alt="" class="pointer-events-none absolute left-1/2 top-1/2 size-[1048px] -translate-x-1/2 -translate-y-1/2 max-w-none" width="1048" height="1048">
                <img src="{{ $img($card['activeImg']) }}" alt="" class="absolute left-1/2 top-1/2 {{ $card['activeImgTab'] }} -translate-x-1/2 -translate-y-1/2 {{ $card['activeImgClass'] }}">
                <h3 class="absolute left-1/2 top-[44px] -translate-x-1/2 font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">{{ $card['title'] }}</h3>
                <div class="lum-location-card__tag absolute left-1/2 top-[79px] w-max max-w-none -translate-x-1/2 rotate-[1deg] bg-lum-cream px-[48px] py-[4px]">
                    <p class="whitespace-nowrap font-serif text-[20px] leading-[24px] tracking-[-0.4px] text-lum-espresso">{!! $card['tag'] !!}</p>
                </div>
                <p class="absolute left-1/2 top-[492px] -translate-x-1/2 text-center lum-text-2 text-lum-espresso">{!! $card['listBr'] !!}</p>
                <a href="#" class="lum-btn absolute left-1/2 top-[574px] -translate-x-1/2 {{ $card['btn'] }} px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px] text-lum-ivory">more info</a>
            </article>
        </div>
        <div class="lum-divider absolute bottom-0 left-[20px]"></div>
    </div>

    {{-- DESKTOP --}}
    <div class="relative hidden h-full desk:block">
        <img src="{{ $img('location/decor.svg') }}" alt="" class="absolute left-1/2 top-[240px] h-[80px] w-[48px] -translate-x-1/2" width="48" height="80">
        <div class="absolute left-[532px] top-[357px] flex w-[856px] flex-col items-center gap-[44px] text-center">
            <h2 class="lum-heading-1 text-lum-espresso">
                prime location in <span class="font-medium italic">Abangama</span> on the pristine southearn coast of <span class="font-medium italic">Sri Lanka</span>
            </h2>
            <img src="{{ $img('location/divider.svg') }}" alt="" class="h-[2px] w-full" width="856" height="2">
        </div>
        <a href="#" class="lum-btn-dark absolute left-1/2 top-[843px] -translate-x-1/2">See on map</a>

        <div class="absolute left-[72px] top-[1039px] flex gap-[64px]">
            @foreach ($cards as $card)
                <article @class(['lum-location-card group relative h-[740px] overflow-hidden', $card['width']])>
                    <div class="lum-location-card__photo absolute inset-0">
                        <img src="{{ $img($card['photo']) }}" alt="" class="absolute inset-0 h-full w-full object-cover">
                        <div class="absolute inset-0 {{ $card['photoGradient'] }}"></div>
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

                    <div class="lum-location-card__active absolute inset-0 bg-lum-sand">
                        <img src="{{ $img('location/dining-bg.svg') }}" alt="" class="pointer-events-none absolute left-1/2 top-1/2 size-[1280px] -translate-x-1/2 -translate-y-1/2 max-w-none" width="1280" height="1280">
                        <img src="{{ $img($card['activeImg']) }}" alt="" class="absolute left-1/2 top-1/2 {{ $card['activeImgDesk'] }} -translate-x-1/2 -translate-y-1/2 {{ $card['activeImgClass'] }}">
                        <h3 class="lum-heading-2 absolute left-1/2 top-[64px] -translate-x-1/2 text-lum-espresso">{{ $card['title'] }}</h3>
                        <div class="lum-location-card__tag absolute left-1/2 top-[129px] w-max max-w-none -translate-x-1/2 rotate-[1deg] bg-lum-cream px-[48px] py-[4px]">
                            <p class="whitespace-nowrap font-serif text-[20px] leading-[24px] tracking-[-0.4px] text-lum-espresso">{!! $card['tag'] !!}</p>
                        </div>
                        <p class="lum-text-2 absolute left-1/2 top-[565px] -translate-x-1/2 text-center text-lum-espresso">{!! $card['listBr'] !!}</p>
                        <a href="#" class="lum-btn absolute left-1/2 top-[640px] -translate-x-1/2 {{ $card['btn'] }} text-lum-ivory">more info</a>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="lum-divider absolute bottom-0 left-[72px]"></div>
    </div>
</section>
