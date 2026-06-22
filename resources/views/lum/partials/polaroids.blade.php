<section class="lum-container relative h-[1173px] bg-lum-ivory tab:h-[1134px] desk:h-[1299px]">
    {{-- MOBILE --}}
    <div class="relative h-full tab:hidden">
        <p class="lum-script pointer-events-none absolute left-[52px] top-[79px] -rotate-[10deg] text-[32px] leading-none tracking-[1.6px] text-lum-green">shine</p>
        <p class="lum-script pointer-events-none absolute left-[281px] top-[33px] -rotate-[10deg] text-[32px] leading-none tracking-[1.6px] text-lum-green">impressions</p>
        <p class="lum-script pointer-events-none absolute left-[298px] top-[1052px] rotate-[9deg] text-[32px] leading-none tracking-[1.6px] text-lum-green">relax</p>

        @foreach ([
            ['left' => '59px', 'top' => '107px', 'rotate' => '13.5deg', 'fw' => '153px', 'fh' => '229px', 'pw' => '139px', 'ph' => '135px', 'px' => '7px', 'py' => '10px', 'photo' => 'photo-1.jpg', 'date' => '06.08.2023', 'script' => '14px'],
            ['left' => '198px', 'top' => '156px', 'rotate' => '-1deg', 'fw' => '153px', 'fh' => '229px', 'pw' => '139px', 'ph' => '135px', 'px' => '7px', 'py' => '10px', 'photo' => 'photo-2.jpg', 'date' => '06.01.2024', 'script' => '14px'],
            ['left' => '91px', 'top' => '853px', 'rotate' => '-10deg', 'fw' => '153px', 'fh' => '229px', 'pw' => '139px', 'ph' => '135px', 'px' => '7px', 'py' => '10px', 'photo' => 'photo-3.jpg', 'date' => '07.03.2023', 'script' => '14px'],
        ] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});">
                <div class="relative" style="width: {{ $polaroid['fw'] }}; height: {{ $polaroid['fh'] }};">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="absolute inset-0 w-full drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                    <p class="absolute left-0 right-0 top-[10px] text-center text-[10px] leading-none tracking-[0.6px] text-lum-espresso">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img('polaroids/' . $polaroid['photo']) }}" alt="" class="absolute object-cover" style="left: {{ $polaroid['px'] }}; top: {{ $polaroid['py'] }}; width: {{ $polaroid['pw'] }}; height: {{ $polaroid['ph'] }};">
                    <p class="lum-script absolute bottom-[16px] left-0 right-0 px-[8px] text-center leading-[1.1] tracking-[1.1px] text-lum-green" style="font-size: {{ $polaroid['script'] }};">share your impressions</p>
                </div>
            </div>
        @endforeach

        <div class="absolute left-[20px] top-[450px] flex w-[335px] flex-col items-center gap-[44px]">
            <div class="flex flex-col items-center gap-[16px]">
                <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                <div class="text-center">
                    <h2 class="font-serif text-[42px] leading-[45px] text-lum-espresso">
                        hard to find,<br><span class="font-medium italic">hard to leave</span>
                    </h2>
                    <p class="mx-auto mt-[24px] max-w-[335px] text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">
                        Just a few hours from the airport. Light years away from the crowds.
                        Here you find the true Sri Lanka. And a small resort with a big view, a
                        great restaurant, and a special sense of calm. Welcome to The Lum.
                    </p>
                </div>
            </div>
            <a href="#villas" class="lum-btn-dark px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">explore our villas</a>
        </div>
        <div class="lum-divider absolute bottom-0 left-[20px]"></div>
    </div>

    {{-- TABLET --}}
    <div class="relative hidden h-full tab:block desk:hidden">
        <p class="lum-script pointer-events-none absolute left-[56px] top-[33px] text-[48px] leading-none tracking-[2.4px] text-lum-green">shine</p>
        <p class="lum-script pointer-events-none absolute left-[564px] top-[-25px] -rotate-[10deg] text-[48px] leading-none tracking-[2.4px] text-lum-green">impressions</p>
        <p class="lum-script pointer-events-none absolute left-[549px] top-[498px] rotate-[9deg] text-[48px] leading-none tracking-[2.4px] text-lum-green">relax</p>

        @foreach ([
            ['left' => '109px', 'top' => '148px', 'rotate' => '13.5deg', 'fw' => '251px', 'fh' => '355px', 'pw' => '228px', 'ph' => '222px', 'px' => '12px', 'py' => '32px', 'photo' => 'photo-1.jpg', 'date' => '06.08.2023', 'script' => '18px'],
            ['left' => '655px', 'top' => '138px', 'rotate' => '-5.5deg', 'fw' => '251px', 'fh' => '355px', 'pw' => '228px', 'ph' => '222px', 'px' => '12px', 'py' => '32px', 'photo' => 'photo-2.jpg', 'date' => '06.01.2024', 'script' => '18px'],
            ['left' => '327px', 'top' => '184px', 'rotate' => '-1deg', 'fw' => '251px', 'fh' => '355px', 'pw' => '228px', 'ph' => '222px', 'px' => '12px', 'py' => '32px', 'photo' => 'photo-3.jpg', 'date' => '07.03.2023', 'script' => '18px'],
        ] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});">
                <div class="relative" style="width: {{ $polaroid['fw'] }}; height: {{ $polaroid['fh'] }};">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="absolute inset-0 w-full drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                    <p class="absolute left-0 right-0 top-[14px] text-center text-[12px] leading-none tracking-[0.6px] text-lum-espresso">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img('polaroids/' . $polaroid['photo']) }}" alt="" class="absolute object-cover" style="left: {{ $polaroid['px'] }}; top: {{ $polaroid['py'] }}; width: {{ $polaroid['pw'] }}; height: {{ $polaroid['ph'] }};">
                    <p class="lum-script absolute bottom-[20px] left-0 right-0 px-[10px] text-center leading-[1.1] tracking-[1.1px] text-lum-green" style="font-size: {{ $polaroid['script'] }};">share your impressions</p>
                </div>
            </div>
        @endforeach

        <div class="absolute left-[80px] top-[695px] flex w-[800px] flex-col items-center gap-[56px]">
            <div class="flex flex-col items-center gap-[20px]">
                <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[8px]" width="8" height="8">
                <div class="text-center">
                    <h2 class="font-serif text-[52px] leading-[52px] text-lum-espresso">
                        hard to find,<br><span class="font-medium italic">hard to leave</span>
                    </h2>
                    <p class="mx-auto mt-[32px] max-w-[800px] text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">
                        Just a few hours from the airport. Light years away from the crowds.
                        Here you find the true Sri Lanka. And a small resort with a big view, a
                        great restaurant, and a special sense of calm. Welcome to The Lum.
                    </p>
                </div>
            </div>
            <a href="#villas" class="lum-btn-dark px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">explore our villas</a>
        </div>
        <div class="lum-divider absolute bottom-0 left-[20px]"></div>
    </div>

    {{-- DESKTOP (не трогаем) --}}
    <div class="relative hidden h-full desk:block">
        <p class="lum-script pointer-events-none absolute left-[195px] top-[150px] text-[73px] leading-none tracking-[3.65px] text-lum-green">shine</p>
        <p class="lum-script pointer-events-none absolute left-[1091px] top-[455px] rotate-[9deg] text-[73px] leading-none tracking-[3.65px] text-lum-green">relax</p>
        <p class="lum-script pointer-events-none absolute left-[1291px] top-[-20px] -rotate-[10deg] text-[73px] leading-none tracking-[3.65px] text-lum-green">impressions</p>

        @foreach ([
            ['left' => '216px', 'top' => '362px', 'rotate' => '13.5deg', 'photo' => 'photo-1.jpg', 'date' => '06.08.2023'],
            ['left' => '787px', 'top' => '109px', 'rotate' => '-5.5deg', 'photo' => 'photo-2.jpg', 'date' => '06.01.2024'],
            ['left' => '1463px', 'top' => '392px', 'rotate' => '-1deg', 'photo' => 'photo-3.jpg', 'date' => '07.03.2023'],
        ] as $polaroid)
            <div class="absolute h-[425px] w-[301px]" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});">
                <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="absolute inset-0 w-full drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                <p class="absolute left-0 right-0 top-[18px] text-center font-sans text-[14px] leading-none tracking-[0.6px] text-lum-espresso">{{ $polaroid['date'] }}</p>
                <img src="{{ $img('polaroids/' . $polaroid['photo']) }}" alt="" class="absolute left-[14px] top-[38px] h-[266px] w-[273px] object-cover" width="273" height="266">
                <p class="lum-script absolute bottom-[28px] left-0 right-0 px-[12px] text-center text-[22px] leading-[24px] tracking-[1.1px] text-lum-green">share your impressions</p>
            </div>
        @endforeach

        <div class="absolute left-[532px] top-[693px] flex w-[856px] flex-col items-center gap-[64px]">
            <div class="flex flex-col items-center gap-[24px]">
                <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[12px]" width="12" height="12">
                <div class="text-center">
                    <h2 class="lum-heading-1 text-lum-espresso">
                        hard to find,<br><span class="font-medium italic">hard to leave</span>
                    </h2>
                    <p class="lum-body mx-auto mt-[44px] max-w-[760px] text-lum-espresso">
                        Just a few hours from the airport. Light years away from the crowds.
                        Here you find the true Sri Lanka. And a small resort with a big view, a
                        great restaurant, and a special sense of calm. Welcome to The Lum.
                    </p>
                </div>
            </div>
            <a href="#villas" class="lum-btn-dark">explore our villas</a>
        </div>
        <div class="lum-divider absolute bottom-0 left-[72px]"></div>
    </div>
</section>
