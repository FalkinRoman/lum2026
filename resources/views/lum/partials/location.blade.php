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
            @foreach ([
                ['title' => 'Dining', 'tag' => 'restaurants <span class="italic">worth</span> traveling for', 'img' => 'dining.png', 'imgW' => '163px', 'imgH' => '96px', 'imgTop' => '162px', 'list' => 'Lum Restaurant & Bar / Sandwich Spot / Rosenköster / Brute Wine & Bar'],
                ['title' => 'Relax', 'tag' => 'new energy from <span class="italic">old tradition</span>', 'img' => 'card-yoga.jpg', 'imgW' => '163px', 'imgH' => '160px', 'imgTop' => '130px', 'list' => 'Yoga / Surfing / Padel', 'photo' => true],
                ['title' => 'Discover', 'tag' => 'welcome to the <span class="italic">true Sri Lanka</span>', 'img' => 'card-discover.jpg', 'imgW' => '171px', 'imgH' => '171px', 'imgTop' => '137px', 'list' => 'Galle Fort / Koggala Lake / Mirissa / Dondra', 'photo' => true],
            ] as $card)
                <article class="relative h-[420px] w-[335px] overflow-hidden border border-dashed border-lum-espresso bg-lum-sand">
                    @if (! empty($card['photo']))
                        <img src="{{ $img('location/' . $card['img']) }}" alt="" class="absolute inset-0 h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-b from-[rgba(36,14,4,0.54)] from-[48%] to-transparent"></div>
                    @else
                        <img src="{{ $img('location/dining-bg.svg') }}" alt="" class="pointer-events-none absolute left-1/2 top-1/2 size-[780px] -translate-x-1/2 -translate-y-1/2 max-w-none" width="780" height="780">
                        <img src="{{ $img('location/' . $card['img']) }}" alt="" class="absolute left-1/2 opacity-90 object-cover" style="top: {{ $card['imgTop'] }}; width: {{ $card['imgW'] }}; height: {{ $card['imgH'] }}; transform: translateX(-50%);">
                    @endif
                    <h3 class="absolute left-1/2 top-[28px] -translate-x-1/2 font-serif text-[28px] leading-[28px] text-lum-espresso">{{ $card['title'] }}</h3>
                    <div class="absolute left-1/2 top-[56px] -translate-x-1/2 rotate-[1deg] bg-lum-cream px-[24px] py-[1px]">
                        <p class="font-serif text-[16px] leading-[24px] tracking-[-0.4px] text-lum-espresso">{!! $card['tag'] !!}</p>
                    </div>
                    <p class="absolute left-1/2 top-[292px] w-[245px] -translate-x-1/2 text-center text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">{{ $card['list'] }}</p>
                    <a href="#" class="lum-btn absolute left-1/2 top-[360px] -translate-x-1/2 bg-lum-green px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px] text-lum-ivory">more info</a>
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
                <article class="relative h-[650px] w-[450px] overflow-hidden border border-dashed border-lum-espresso bg-lum-sand">
                    <img src="{{ $img('location/dining-bg.svg') }}" alt="" class="pointer-events-none absolute left-1/2 top-1/2 size-[1048px] -translate-x-1/2 -translate-y-1/2 max-w-none" width="1048" height="1048">
                    <img src="{{ $img('location/dining.png') }}" alt="" class="absolute left-1/2 top-1/2 h-[128px] w-[218px] -translate-x-1/2 -translate-y-1/2 object-cover opacity-90" width="218" height="128">
                    <h3 class="absolute left-1/2 top-[44px] -translate-x-1/2 font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">Dining</h3>
                    <div class="absolute left-1/2 top-[80px] -translate-x-1/2 rotate-[1deg] bg-lum-cream px-[48px] py-[4px]">
                        <p class="font-serif text-[20px] leading-[24px] tracking-[-0.4px] text-lum-espresso">restaurants <span class="italic">worth</span> traveling for</p>
                    </div>
                    <p class="absolute left-1/2 top-[492px] -translate-x-1/2 text-center lum-text-2 text-lum-espresso">Lum Restaurant & Bar / Sandwich Spot /<br>Rosenköster / Brute Wine & Bar</p>
                    <a href="#" class="lum-btn absolute left-1/2 top-[574px] -translate-x-1/2 bg-lum-green px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px] text-lum-ivory">more info</a>
                </article>
                <article class="relative h-[650px] w-[450px] overflow-hidden border border-dashed border-lum-espresso bg-lum-sand">
                    <img src="{{ $img('location/dining-bg.svg') }}" alt="" class="pointer-events-none absolute left-1/2 top-1/2 size-[1048px] -translate-x-1/2 -translate-y-1/2 max-w-none" width="1048" height="1048">
                    <img src="{{ $img('location/card-yoga.jpg') }}" alt="" class="absolute left-1/2 top-1/2 h-[214px] w-[218px] -translate-x-1/2 -translate-y-1/2 object-cover" width="218" height="214">
                    <h3 class="absolute left-1/2 top-[44px] -translate-x-1/2 font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">Relax</h3>
                    <div class="absolute left-1/2 top-[80px] -translate-x-1/2 rotate-[1deg] bg-lum-cream px-[48px] py-[4px]">
                        <p class="font-serif text-[20px] leading-[24px] tracking-[-0.4px] text-lum-espresso">new energy from <span class="italic">old tradition</span></p>
                    </div>
                    <p class="absolute left-1/2 top-[517px] -translate-x-1/2 lum-text-2 text-lum-espresso">Yoga / Surfing / Padel</p>
                    <a href="#" class="lum-btn absolute left-1/2 top-[574px] -translate-x-1/2 bg-lum-green px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px] text-lum-ivory">more info</a>
                </article>
            </div>
            <article class="relative mt-[40px] h-[650px] w-[450px] overflow-hidden border border-dashed border-lum-espresso bg-lum-sand">
                <img src="{{ $img('location/dining-bg.svg') }}" alt="" class="pointer-events-none absolute left-1/2 top-1/2 size-[1048px] -translate-x-1/2 -translate-y-1/2 max-w-none" width="1048" height="1048">
                <img src="{{ $img('location/card-discover.jpg') }}" alt="" class="absolute left-1/2 top-1/2 size-[200px] -translate-x-1/2 -translate-y-1/2 -rotate-[15deg] object-cover" width="200" height="200">
                <h3 class="absolute left-1/2 top-[44px] -translate-x-1/2 font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">Discover</h3>
                <div class="absolute left-1/2 top-[79px] -translate-x-1/2 rotate-[1deg] bg-lum-cream px-[48px] py-[4px]">
                    <p class="font-serif text-[20px] leading-[24px] tracking-[-0.4px] text-lum-espresso">welcome to the <span class="italic">true Sri Lanka</span></p>
                </div>
                <p class="absolute left-1/2 top-[492px] -translate-x-1/2 text-center lum-text-2 text-lum-espresso">Galle Fort / Koggala Lake /<br>Mirissa / Dondra</p>
                <a href="#" class="lum-btn absolute left-1/2 top-[574px] -translate-x-1/2 bg-lum-green px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px] text-lum-ivory">more info</a>
            </article>
        </div>
        <div class="lum-divider absolute bottom-0 left-[20px]"></div>
    </div>

    {{-- DESKTOP (не трогаем) --}}
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
            <div class="relative h-[740px] w-[550px] overflow-hidden bg-lum-sand">
                <img src="{{ $img('location/dining-bg.svg') }}" alt="" class="pointer-events-none absolute left-1/2 top-1/2 size-[1280px] -translate-x-1/2 -translate-y-1/2 max-w-none" width="1280" height="1280">
                <img src="{{ $img('location/dining.png') }}" alt="" class="absolute left-1/2 top-1/2 h-[160px] w-[273px] -translate-x-1/2 -translate-y-1/2 object-cover opacity-90" width="273" height="160">
                <h3 class="lum-heading-2 absolute left-1/2 top-[64px] -translate-x-1/2 text-lum-espresso">Dining</h3>
                <div class="absolute left-1/2 top-[129px] -translate-x-1/2 rotate-[1deg] bg-lum-cream px-[48px] py-[4px]">
                    <p class="font-serif text-[20px] leading-[24px] tracking-[-0.4px] text-lum-espresso">restaurants <span class="italic">worth</span> traveling for</p>
                </div>
                <p class="lum-text-2 absolute left-1/2 top-[565px] -translate-x-1/2 text-center text-lum-espresso">
                    Lum Restaurant & Bar / Sandwich Spot /<br>Rosenköster / Brute Wine & Bar
                </p>
                <a href="#" class="lum-btn absolute left-1/2 top-[640px] -translate-x-1/2 bg-lum-espresso text-lum-ivory">more info</a>
            </div>
            <article class="relative h-[740px] w-[549px] overflow-hidden">
                <img src="{{ $img('location/card-yoga.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover" width="549" height="740">
                <div class="absolute inset-0 bg-gradient-to-b from-[rgba(36,14,4,0.54)] from-[48%] to-transparent"></div>
                <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-center text-lum-ivory">
                    <p class="lum-heading-3">We offer private</p>
                    <p class="lum-heading-3 font-normal italic">yoga sessions</p>
                </div>
                <div class="absolute bottom-[52px] left-1/2 flex -translate-x-1/2 flex-col items-center gap-[12px]">
                    <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                    <span class="lum-eyebrow text-lum-ivory">Relax</span>
                </div>
            </article>
            <article class="relative h-[740px] w-[550px] overflow-hidden">
                <img src="{{ $img('location/card-discover.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover" width="550" height="740">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[rgba(22,5,5,0.48)]"></div>
                <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-center text-lum-ivory">
                    <p class="lum-heading-3">Sri Lanka as it</p>
                    <p class="lum-heading-3 font-normal italic">used to be</p>
                </div>
                <div class="absolute bottom-[52px] left-1/2 flex -translate-x-1/2 flex-col items-center gap-[12px]">
                    <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                    <span class="lum-eyebrow text-lum-ivory">discover</span>
                </div>
            </article>
        </div>
        <div class="lum-divider absolute bottom-0 left-[72px]"></div>
    </div>
</section>
