@php
    $galleryPolaroids = [
        'mob' => [
            ['left' => '20px', 'top' => '430px', 'rotate' => '8deg', 'fw' => '160px', 'fh' => '226px', 'pw' => '146px', 'ph' => '142px', 'px' => '7px', 'py' => '10px', 'photo' => 'gallery-01.webp', 'date' => '06.08.2023'],
            ['left' => '195px', 'top' => '430px', 'rotate' => '-6deg', 'fw' => '160px', 'fh' => '226px', 'pw' => '146px', 'ph' => '142px', 'px' => '7px', 'py' => '10px', 'photo' => 'gallery-02.webp', 'date' => '06.01.2024'],
        ],
        'tab' => [
            ['left' => '20px', 'top' => '385px', 'rotate' => '6deg', 'fw' => '450px', 'fh' => '635px', 'pw' => '410px', 'ph' => '400px', 'px' => '20px', 'py' => '28px', 'photo' => 'gallery-01.webp', 'date' => '06.08.2023'],
            ['left' => '490px', 'top' => '385px', 'rotate' => '-4deg', 'fw' => '450px', 'fh' => '635px', 'pw' => '410px', 'ph' => '400px', 'px' => '20px', 'py' => '28px', 'photo' => 'gallery-02.webp', 'date' => '06.01.2024'],
        ],
        'desk' => [
            ['left' => '72px', 'top' => '560px', 'rotate' => '5deg', 'fw' => '549px', 'fh' => '775px', 'pw' => '500px', 'ph' => '488px', 'px' => '24px', 'py' => '34px', 'photo' => 'gallery-01.webp', 'date' => '06.08.2023'],
            ['left' => '685px', 'top' => '560px', 'rotate' => '-3deg', 'fw' => '549px', 'fh' => '775px', 'pw' => '500px', 'ph' => '488px', 'px' => '24px', 'py' => '34px', 'photo' => 'gallery-02.webp', 'date' => '06.01.2024'],
            ['left' => '1299px', 'top' => '560px', 'rotate' => '7deg', 'fw' => '549px', 'fh' => '775px', 'pw' => '500px', 'ph' => '488px', 'px' => '24px', 'py' => '34px', 'photo' => 'gallery-03.webp', 'date' => '07.03.2023'],
        ],
    ];
@endphp

<section class="lum-container relative bg-lum-ivory h-[952px] tab:h-[1400px] desk:h-[1756px]" data-lum-villa-panel>
    {{-- MOBILE --}}
    <div class="relative h-full tab:hidden">
        <p class="lum-script absolute left-1/2 top-[60px] -translate-x-1/2 whitespace-nowrap text-[24px] leading-none tracking-[1.2px] text-lum-espresso" data-lum-villa-eyebrow>{{ $villa['gallery']['eyebrow'] }}</p>

        <div class="absolute left-1/2 top-[144px] flex w-[335px] -translate-x-1/2 flex-col items-center gap-[22px] text-center" data-lum-scroll-reveal>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
            <h2 class="font-serif text-[36px] leading-[45px] text-lum-espresso">
                {{ $villa['gallery']['title_normal'] }}<br><span class="font-medium italic">{{ $villa['gallery']['title_italic'] }}</span>
            </h2>
            <p class="text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">{{ $villa['gallery']['body'] }}</p>
        </div>

        @foreach ($galleryPolaroids['mob'] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});" data-lum-villa-polaroid>
                <div class="relative" style="width: {{ $polaroid['fw'] }}; height: {{ $polaroid['fh'] }};">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="absolute inset-0 w-full drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                    <p class="absolute left-0 right-0 top-[10px] text-center text-[10px] leading-none tracking-[0.6px] text-lum-espresso">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img('villa/' . $polaroid['photo']) }}" alt="" class="absolute object-cover" style="left: {{ $polaroid['px'] }}; top: {{ $polaroid['py'] }}; width: {{ $polaroid['pw'] }}; height: {{ $polaroid['ph'] }};">
                    <p class="lum-script absolute bottom-[12px] left-0 right-0 px-[6px] text-center text-[12px] leading-[1.1] tracking-[1px] text-lum-green">{{ __('lum.polaroids.share') }}</p>
                </div>
            </div>
        @endforeach

        <p class="absolute left-1/2 top-[720px] w-[290px] -translate-x-1/2 text-center text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.1">{{ $villa['gallery']['body_bottom'] }}</p>

        <div class="absolute bottom-[31px] left-[20px] flex w-[335px] items-center gap-[22px]">
            <div class="h-px flex-1 bg-lum-espresso/40"></div>
            <img src="{{ $img('villa/divider-sun.svg') }}" alt="" class="size-[32px]" width="32" height="32" data-lum-villa-divider>
            <div class="h-px flex-1 bg-lum-espresso/40"></div>
        </div>
    </div>

    {{-- TABLET --}}
    <div class="relative hidden h-full tab:block desk:hidden">
        <p class="lum-script absolute left-1/2 top-0 -translate-x-1/2 whitespace-nowrap text-[28px] leading-none tracking-[1.4px] text-lum-espresso" data-lum-villa-eyebrow>{{ $villa['gallery']['eyebrow'] }}</p>

        <div class="absolute left-1/2 top-[101px] flex w-[800px] -translate-x-1/2 flex-col items-center gap-[20px] text-center" data-lum-scroll-reveal>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8">
            <h2 class="font-serif text-[52px] leading-[52px] text-lum-espresso">
                {{ $villa['gallery']['title_normal'] }}<br><span class="font-medium italic">{{ $villa['gallery']['title_italic'] }}</span>
            </h2>
            <p class="max-w-[560px] lum-text-2 text-lum-espresso">{{ $villa['gallery']['body'] }}</p>
        </div>

        @foreach ($galleryPolaroids['tab'] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});" data-lum-villa-polaroid>
                <div class="relative" style="width: {{ $polaroid['fw'] }}; height: {{ $polaroid['fh'] }};">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="absolute inset-0 w-full drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                    <p class="absolute left-0 right-0 top-[20px] text-center text-[12px] leading-none tracking-[0.6px] text-lum-espresso">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img('villa/' . $polaroid['photo']) }}" alt="" class="absolute object-cover" style="left: {{ $polaroid['px'] }}; top: {{ $polaroid['py'] }}; width: {{ $polaroid['pw'] }}; height: {{ $polaroid['ph'] }};">
                    <p class="lum-script absolute bottom-[20px] left-0 right-0 px-[10px] text-center text-[16px] leading-[1.1] tracking-[1.2px] text-lum-green">{{ __('lum.polaroids.share') }}</p>
                </div>
            </div>
        @endforeach

        <p class="absolute left-1/2 top-[1140px] w-[560px] -translate-x-1/2 text-center lum-text-2 text-lum-espresso" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.1">{{ $villa['gallery']['body_bottom'] }}</p>

        <div class="absolute bottom-[39px] left-[20px] flex w-[920px] items-center gap-[22px]">
            <div class="h-px flex-1 bg-lum-espresso/40"></div>
            <img src="{{ $img('villa/divider-sun.svg') }}" alt="" class="size-[40px]" width="40" height="40" data-lum-villa-divider>
            <div class="h-px flex-1 bg-lum-espresso/40"></div>
        </div>
    </div>

    {{-- DESKTOP --}}
    <div class="relative hidden h-full desk:block">
        <p class="lum-script absolute left-1/2 top-[105px] -translate-x-1/2 whitespace-nowrap text-[32px] leading-none tracking-[1.6px] text-lum-espresso" data-lum-villa-eyebrow>{{ $villa['gallery']['eyebrow'] }}</p>

        <div class="absolute left-1/2 top-[188px] flex w-[856px] -translate-x-1/2 flex-col items-center gap-[24px] text-center" data-lum-scroll-reveal>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12">
            <h2 class="font-serif text-[88px] leading-[94px] text-lum-espresso">
                {{ $villa['gallery']['title_normal'] }}<br><span class="font-medium italic">{{ $villa['gallery']['title_italic'] }}</span>
            </h2>
            <p class="lum-body text-lum-espresso">{{ $villa['gallery']['body'] }}</p>
        </div>

        @foreach ($galleryPolaroids['desk'] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});" data-lum-villa-polaroid>
                <div class="relative" style="width: {{ $polaroid['fw'] }}; height: {{ $polaroid['fh'] }};">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="absolute inset-0 w-full drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                    <p class="absolute left-0 right-0 top-[24px] text-center text-[14px] leading-none tracking-[0.6px] text-lum-espresso">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img('villa/' . $polaroid['photo']) }}" alt="" class="absolute object-cover" style="left: {{ $polaroid['px'] }}; top: {{ $polaroid['py'] }}; width: {{ $polaroid['pw'] }}; height: {{ $polaroid['ph'] }};">
                    <p class="lum-script absolute bottom-[24px] left-0 right-0 px-[12px] text-center text-[18px] leading-[1.1] tracking-[1.4px] text-lum-green">{{ __('lum.polaroids.share') }}</p>
                </div>
            </div>
        @endforeach

        <p class="absolute left-1/2 top-[1495px] w-[856px] -translate-x-1/2 text-center lum-body text-lum-espresso" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.1">{{ $villa['gallery']['body_bottom'] }}</p>

        <div class="absolute bottom-[62px] left-[72px] flex w-[1776px] items-center gap-[22px]">
            <div class="h-px flex-1 bg-lum-espresso/40"></div>
            <img src="{{ $img('villa/divider-sun.svg') }}" alt="" class="size-[64px]" width="64" height="64" data-lum-villa-divider>
            <div class="h-px flex-1 bg-lum-espresso/40"></div>
        </div>
    </div>
</section>
