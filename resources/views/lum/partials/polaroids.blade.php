<section class="lum-container relative h-[1173px] bg-lum-ivory tab:h-[1134px] desk:h-[1299px]">
    {{-- MOBILE --}}
    <div class="relative h-full tab:hidden" data-lum-scroll-stagger>
        @foreach ([
            ['left' => '59.07px', 'top' => '107.45px', 'rotate' => '13.51deg', 'fw' => '153px', 'fh' => '229px', 'photo' => 'photo-1.jpg', 'date' => '06.08.2023', 'script' => '14px'],
            ['left' => '198.36px', 'top' => '156px', 'rotate' => '-0.97deg', 'fw' => '153px', 'fh' => '229px', 'photo' => 'photo-2.jpg', 'date' => '06.01.2024', 'script' => '14px'],
            ['left' => '91px', 'top' => '852.55px', 'rotate' => '-9.98deg', 'fw' => '153px', 'fh' => '229px', 'photo' => 'photo-3.jpg', 'date' => '07.03.2023', 'script' => '14px'],
        ] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});">
                <div class="relative" data-lum-scroll-item style="width: {{ $polaroid['fw'] }}; height: {{ $polaroid['fh'] }};">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="271" height="405">
                    <p class="absolute left-0 right-0 top-[10px] z-[3] text-center text-[10px] leading-none tracking-[0.6px] text-lum-espresso">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img('polaroids/' . $polaroid['photo']) }}" alt="" class="lum-polaroid__photo">
                    <p class="lum-script absolute bottom-[16px] left-0 right-0 z-[3] px-[8px] text-center leading-[1.1] tracking-[1.1px] text-lum-green" style="font-size: {{ $polaroid['script'] }};">{{ __('lum.polaroids.share') }}</p>
                </div>
            </div>
        @endforeach

        <div class="pointer-events-none absolute z-20 flex -translate-x-1/2 items-center justify-center mix-blend-hard-light" style="left: 51.69px; top: 78.5px;">
            <p class="lum-script whitespace-nowrap text-center leading-none text-lum-green" style="font-size: 32px; letter-spacing: 1.6px; transform: rotate(-9.6deg);">{{ __('lum.polaroids.shine') }}</p>
        </div>
        <div class="pointer-events-none absolute z-20 flex -translate-x-1/2 items-center justify-center mix-blend-hard-light" style="left: 281.09px; top: 32.83px;">
            <p class="lum-script whitespace-nowrap text-center leading-none text-lum-green" style="font-size: 32px; letter-spacing: 1.6px; transform: rotate(-9.6deg);">{{ __('lum.polaroids.impressions') }}</p>
        </div>
        <div class="pointer-events-none absolute z-20 flex -translate-x-1/2 items-center justify-center mix-blend-hard-light" style="left: 275px; top: 1052px;">
            <p class="lum-script whitespace-nowrap text-center leading-none text-lum-green" style="font-size: 32px; letter-spacing: 1.6px; transform: rotate(9.07deg);">{{ __('lum.polaroids.relax') }}</p>
        </div>

        <div class="absolute left-[20px] top-[450px] flex w-[335px] flex-col items-center gap-[44px]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.2">
            <div class="flex flex-col items-center gap-[16px]">
                <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                <div class="text-center">
                    <h2 class="font-serif text-[42px] leading-[45px] text-lum-espresso">
                        {{ __('lum.polaroids.title_normal') }}<br><span class="font-medium italic">{{ __('lum.polaroids.title_italic') }}</span>
                    </h2>
                    <p class="mx-auto mt-[24px] max-w-[335px] text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">
                        {{ __('lum.polaroids.body') }}
                    </p>
                </div>
            </div>
            <a href="{{ route('stay') }}" class="lum-btn-dark px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.hero.cta') }}</a>
        </div>
        <div class="lum-divider absolute bottom-0 left-[20px]"></div>
    </div>

    {{-- TABLET --}}
    <div class="relative hidden h-full tab:block desk:hidden" data-lum-scroll-stagger>
        @foreach ([
            ['left' => '108.77px', 'top' => '147.56px', 'rotate' => '13.51deg', 'fw' => '251px', 'fh' => '375px', 'photo' => 'photo-1.jpg', 'date' => '06.08.2023', 'script' => '18px'],
            ['left' => '654.73px', 'top' => '138px', 'rotate' => '-0.97deg', 'fw' => '251px', 'fh' => '375px', 'photo' => 'photo-2.jpg', 'date' => '06.01.2024', 'script' => '18px'],
            ['left' => '380px', 'top' => '184.2px', 'rotate' => '-9.98deg', 'fw' => '251px', 'fh' => '375px', 'photo' => 'photo-3.jpg', 'date' => '07.03.2023', 'script' => '18px'],
        ] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});">
                <div class="relative" data-lum-scroll-item style="width: {{ $polaroid['fw'] }}; height: {{ $polaroid['fh'] }};">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="271" height="405">
                    <p class="absolute left-0 right-0 top-[14px] z-[3] text-center text-[12px] leading-none tracking-[0.6px] text-lum-espresso">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img('polaroids/' . $polaroid['photo']) }}" alt="" class="lum-polaroid__photo">
                    <p class="lum-script absolute bottom-[20px] left-0 right-0 z-[3] px-[10px] text-center leading-[1.1] tracking-[1.1px] text-lum-green" style="font-size: {{ $polaroid['script'] }};">{{ __('lum.polaroids.share') }}</p>
                </div>
            </div>
        @endforeach

        <div class="pointer-events-none absolute z-20 flex -translate-x-1/2 items-center justify-center mix-blend-hard-light" style="left: 120.97px; top: 40px;">
            <p class="lum-script whitespace-nowrap text-center leading-none text-lum-green" style="font-size: 58.473px; letter-spacing: 2.9237px; transform: rotate(-9.6deg);">{{ __('lum.polaroids.shine') }}</p>
        </div>
        <div class="pointer-events-none absolute z-20 flex -translate-x-1/2 items-center justify-center mix-blend-hard-light" style="left: 705.41px; top: -38px;">
            <p class="lum-script whitespace-nowrap text-center leading-none text-lum-green" style="font-size: 58.473px; letter-spacing: 2.9237px; transform: rotate(-9.6deg);">{{ __('lum.polaroids.impressions') }}</p>
        </div>
        <div class="pointer-events-none absolute z-20 flex -translate-x-1/2 items-center justify-center mix-blend-hard-light" style="left: 606.3px; top: 536px;">
            <p class="lum-script whitespace-nowrap text-center leading-none text-lum-green" style="font-size: 58.473px; letter-spacing: 2.9237px; transform: rotate(9.07deg);">{{ __('lum.polaroids.relax') }}</p>
        </div>

        <div class="absolute left-[80px] top-[695px] flex w-[800px] flex-col items-center gap-[56px]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.2">
            <div class="flex flex-col items-center gap-[20px]">
                <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[8px]" width="8" height="8">
                <div class="text-center">
                    <h2 class="font-serif text-[52px] leading-[52px] text-lum-espresso">
                        {{ __('lum.polaroids.title_normal') }}<br><span class="font-medium italic">{{ __('lum.polaroids.title_italic') }}</span>
                    </h2>
                    <p class="mx-auto mt-[32px] max-w-[800px] text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">
                        {{ __('lum.polaroids.body') }}
                    </p>
                </div>
            </div>
            <a href="{{ route('stay') }}" class="lum-btn-dark px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.hero.cta') }}</a>
        </div>
        <div class="lum-divider absolute bottom-0 left-[20px]"></div>
    </div>

    {{-- DESKTOP — frame 271×405 matches Figma Union / frame.svg --}}
    <div class="relative hidden h-full desk:block" data-lum-scroll-stagger>
        @foreach ([
            ['left' => '216px', 'top' => '362px', 'rotate' => '13.5deg', 'photo' => 'photo-1.jpg', 'date' => '06.08.2023'],
            ['left' => '787px', 'top' => '109px', 'rotate' => '-5.5deg', 'photo' => 'photo-2.jpg', 'date' => '06.01.2024'],
            ['left' => '1463px', 'top' => '392px', 'rotate' => '-1deg', 'photo' => 'photo-3.jpg', 'date' => '07.03.2023'],
        ] as $polaroid)
            <div class="absolute h-[405px] w-[271px]" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});">
                <div class="relative h-full w-full" data-lum-scroll-item>
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="271" height="405">
                    <p class="absolute left-0 right-0 top-[18px] z-[3] text-center font-sans text-[14px] leading-none tracking-[0.6px] text-lum-espresso">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img('polaroids/' . $polaroid['photo']) }}" alt="" class="lum-polaroid__photo">
                    <p class="lum-script absolute bottom-[28px] left-0 right-0 z-[3] px-[12px] text-center text-[22px] leading-[24px] tracking-[1.1px] text-lum-green">{{ __('lum.polaroids.share') }}</p>
                </div>
            </div>
        @endforeach

        <div class="pointer-events-none absolute z-20 flex -translate-x-1/2 items-center justify-center mix-blend-hard-light" style="left: 274.97px; top: 149.67px;">
            <p class="lum-script whitespace-nowrap text-center leading-none text-lum-green" style="font-size: 73.092px; letter-spacing: 3.6546px; transform: rotate(-9.6deg);">{{ __('lum.polaroids.shine') }}</p>
        </div>
        <div class="pointer-events-none absolute z-20 flex -translate-x-1/2 items-center justify-center mix-blend-hard-light" style="left: 1468.64px; top: -78px;">
            <p class="lum-script whitespace-nowrap text-center leading-none text-lum-green" style="font-size: 73.092px; letter-spacing: 3.6546px; transform: rotate(-9.6deg);">{{ __('lum.polaroids.impressions') }}</p>
        </div>
        <div class="pointer-events-none absolute z-20 flex -translate-x-1/2 items-center justify-center mix-blend-hard-light" style="left: 1125px; top: 455px;">
            <p class="lum-script whitespace-nowrap text-center leading-none text-lum-green" style="font-size: 73.092px; letter-spacing: 3.6546px; transform: rotate(9.07deg);">{{ __('lum.polaroids.relax') }}</p>
        </div>

        <div class="absolute left-[532px] top-[693px] flex w-[856px] flex-col items-center gap-[64px]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.2">
            <div class="flex flex-col items-center gap-[24px]">
                <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[12px]" width="12" height="12">
                <div class="text-center">
                    <h2 class="lum-heading-1 text-lum-espresso">
                        {{ __('lum.polaroids.title_normal') }}<br><span class="font-medium italic">{{ __('lum.polaroids.title_italic') }}</span>
                    </h2>
                    <p class="lum-body mx-auto mt-[44px] max-w-[760px] text-lum-espresso">
                        {{ __('lum.polaroids.body') }}
                    </p>
                </div>
            </div>
            <a href="{{ route('stay') }}" class="lum-btn-dark">{{ __('lum.hero.cta') }}</a>
        </div>
        <div class="lum-divider absolute bottom-0 left-[72px]"></div>
    </div>
</section>
