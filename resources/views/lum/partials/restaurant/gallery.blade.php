@php
    $galleryPolaroids = [
        'mob' => [
            ['left' => '20px', 'top' => '458px', 'rotate' => '8deg', 'fw' => 160, 'fh' => 226, 'px' => 13, 'py' => 21, 'pw' => 133, 'ph' => 141, 'dateSize' => 10, 'shareSize' => 9, 'dateTop' => 12, 'shareBottom' => 22, 'photo' => 'gallery-01.webp', 'date' => '06.08.2023'],
            ['left' => '195px', 'top' => '458px', 'rotate' => '-6deg', 'fw' => 160, 'fh' => 226, 'px' => 13, 'py' => 21, 'pw' => 133, 'ph' => 141, 'dateSize' => 10, 'shareSize' => 9, 'dateTop' => 12, 'shareBottom' => 22, 'photo' => 'gallery-02.webp', 'date' => '06.01.2024'],
        ],
        'tab' => [
            ['left' => '20px', 'top' => '430px', 'rotate' => '6deg', 'fw' => 450, 'fh' => 635, 'px' => 37, 'py' => 59, 'pw' => 374, 'ph' => 418, 'dateSize' => 13, 'shareSize' => 17, 'dateTop' => 34, 'shareBottom' => 92, 'photo' => 'gallery-01.webp', 'date' => '06.08.2023'],
            ['left' => '490px', 'top' => '430px', 'rotate' => '-4deg', 'fw' => 450, 'fh' => 635, 'px' => 37, 'py' => 59, 'pw' => 374, 'ph' => 418, 'dateSize' => 13, 'shareSize' => 17, 'dateTop' => 34, 'shareBottom' => 92, 'photo' => 'gallery-02.webp', 'date' => '06.01.2024'],
        ],
        'desk' => [
            ['left' => '72px', 'top' => '695px', 'rotate' => '5deg', 'fw' => 549, 'fh' => 775, 'px' => 45, 'py' => 72, 'pw' => 456, 'ph' => 509, 'dateSize' => 16, 'shareSize' => 23, 'dateTop' => 42, 'shareBottom' => 106, 'photo' => 'gallery-01.webp', 'date' => '06.08.2023'],
            ['left' => '685px', 'top' => '695px', 'rotate' => '-3deg', 'fw' => 549, 'fh' => 775, 'px' => 45, 'py' => 72, 'pw' => 456, 'ph' => 509, 'dateSize' => 16, 'shareSize' => 23, 'dateTop' => 42, 'shareBottom' => 106, 'photo' => 'gallery-02.webp', 'date' => '06.01.2024'],
            ['left' => '1299px', 'top' => '695px', 'rotate' => '7deg', 'fw' => 549, 'fh' => 775, 'px' => 45, 'py' => 72, 'pw' => 456, 'ph' => 509, 'dateSize' => 16, 'shareSize' => 23, 'dateTop' => 42, 'shareBottom' => 106, 'photo' => 'gallery-03.webp', 'date' => '07.03.2023'],
        ],
    ];
@endphp

<section class="lum-container relative overflow-visible bg-lum-ivory h-[980px] tab:h-[1403px] desk:h-[1890px] desk:w-[1920px]" data-lum-villa-panel>
    {{-- Ovals live in hero (mob/tab/desk) so they stack above the hero media --}}

    {{-- MOBILE — Figma 186:698 --}}
    <div class="relative h-full tab:hidden">
        <p class="lum-script absolute inset-x-0 top-[88px] whitespace-nowrap text-center text-[24px] leading-none tracking-[1.2px] text-lum-espresso" data-lum-villa-eyebrow>{{ $restaurant['gallery']['eyebrow'] }}</p>

        <div class="absolute left-[20px] top-[172px] flex w-[335px] flex-col items-center text-center" data-lum-scroll-reveal>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
            <div class="mt-[22px] flex w-full flex-col items-center gap-[24px]">
                <h2 class="font-serif text-[36px] leading-[45px] text-lum-espresso">
                    {{ $restaurant['gallery']['title_normal'] }}<br><span class="font-medium italic">{{ $restaurant['gallery']['title_italic'] }}</span>
                </h2>
                <p class="text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">{{ $restaurant['gallery']['body'] }}</p>
            </div>
        </div>

        @foreach ($galleryPolaroids['mob'] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});" data-lum-villa-polaroid>
                <div class="relative" style="width: {{ $polaroid['fw'] }}px; height: {{ $polaroid['fh'] }}px;">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                    <p class="lum-villa-polaroid__script absolute left-0 right-0 z-[3] text-center leading-none" style="top: {{ $polaroid['dateTop'] }}px; font-size: {{ $polaroid['dateSize'] }}px; letter-spacing: 0.23px;">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img($assetBase . '/' . $polaroid['photo']) }}" alt="" class="lum-polaroid__photo">
                    <p class="lum-villa-polaroid__script lum-villa-polaroid__share absolute left-0 right-0 z-[3] px-[4px] text-center leading-[1]" style="bottom: {{ $polaroid['shareBottom'] }}px; font-size: {{ $polaroid['shareSize'] }}px; letter-spacing: 0.2px;">{{ __('lum.polaroids.share') }}</p>
                </div>
            </div>
        @endforeach

        <p class="absolute left-[43px] top-[748px] w-[290px] text-center text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.1">{{ $restaurant['gallery']['body_bottom'] }}</p>

        <img src="{{ $img('dining/detail/shared/divider-mob.svg') }}" alt="" class="absolute bottom-0 left-[20px] h-[31px] w-[335px]" width="335" height="31">
    </div>

    {{-- TABLET — Figma 186:555 (oval lives in hero) --}}
    <div class="relative hidden h-full tab:block desk:hidden">
        <p class="lum-script absolute inset-x-0 top-[44px] whitespace-nowrap text-center text-[28px] leading-none tracking-[1.4px] text-lum-espresso" data-lum-villa-eyebrow>{{ $restaurant['gallery']['eyebrow'] }}</p>

        <div class="absolute left-1/2 top-[145px] flex w-[800px] -translate-x-1/2 flex-col items-center text-center" data-lum-scroll-reveal>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8">
            <div class="mt-[20px] flex w-full flex-col items-center gap-[32px]">
                <h2 class="font-serif text-[52px] leading-[52px] text-lum-espresso">
                    {{ $restaurant['gallery']['title_normal'] }}<br><span class="font-medium italic">{{ $restaurant['gallery']['title_italic'] }}</span>
                </h2>
                <p class="max-w-[560px] lum-text-2 text-lum-espresso">{{ $restaurant['gallery']['body'] }}</p>
            </div>
        </div>

        @foreach ($galleryPolaroids['tab'] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});" data-lum-villa-polaroid>
                <div class="relative" style="width: {{ $polaroid['fw'] }}px; height: {{ $polaroid['fh'] }}px;">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                    <p class="lum-villa-polaroid__script absolute left-0 right-0 z-[3] text-center leading-none" style="top: {{ $polaroid['dateTop'] }}px; font-size: {{ $polaroid['dateSize'] }}px; letter-spacing: 0.4px;">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img($assetBase . '/' . $polaroid['photo']) }}" alt="" class="lum-polaroid__photo">
                    <p class="lum-villa-polaroid__script lum-villa-polaroid__share absolute left-0 right-0 z-[3] px-[10px] text-center leading-[1.05]" style="bottom: {{ $polaroid['shareBottom'] }}px; font-size: {{ $polaroid['shareSize'] }}px; letter-spacing: 0.5px;">{{ __('lum.polaroids.share') }}</p>
                </div>
            </div>
        @endforeach

        <p class="absolute left-1/2 top-[1184px] w-[560px] -translate-x-1/2 text-center lum-text-2 text-lum-espresso" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.1">{{ $restaurant['gallery']['body_bottom'] }}</p>

        <img src="{{ $img('dining/detail/shared/divider-tab.svg') }}" alt="" class="absolute bottom-0 left-[20px] h-[39px] w-[920px]" width="920" height="39">
    </div>

    {{-- DESKTOP — Figma 186:391 --}}
    <div class="relative hidden h-full desk:block">
        <p class="lum-script absolute inset-x-0 top-[240px] whitespace-nowrap text-center text-[32px] leading-none tracking-[1.6px] text-lum-espresso" data-lum-villa-eyebrow>{{ $restaurant['gallery']['eyebrow'] }}</p>

        <div class="absolute left-1/2 top-[323px] flex w-[856px] -translate-x-1/2 flex-col items-center text-center" data-lum-scroll-reveal>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12">
            <div class="mt-[36px] flex w-full flex-col items-center gap-[44px]">
                <h2 class="font-serif text-[88px] leading-[94px] text-lum-espresso">
                    {{ $restaurant['gallery']['title_normal'] }}<br><span class="font-medium italic">{{ $restaurant['gallery']['title_italic'] }}</span>
                </h2>
                <p class="lum-body text-lum-espresso">{{ $restaurant['gallery']['body'] }}</p>
            </div>
        </div>

        @foreach ($galleryPolaroids['desk'] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});" data-lum-villa-polaroid>
                <div class="relative" style="width: {{ $polaroid['fw'] }}px; height: {{ $polaroid['fh'] }}px;">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                    <p class="lum-villa-polaroid__script absolute left-0 right-0 z-[3] text-center leading-none" style="top: {{ $polaroid['dateTop'] }}px; font-size: {{ $polaroid['dateSize'] }}px; letter-spacing: 0.79px;">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img($assetBase . '/' . $polaroid['photo']) }}" alt="" class="lum-polaroid__photo">
                    <p class="lum-villa-polaroid__script lum-villa-polaroid__share absolute left-0 right-0 z-[3] px-[12px] text-center leading-[1.05]" style="bottom: {{ $polaroid['shareBottom'] }}px; font-size: {{ $polaroid['shareSize'] }}px; letter-spacing: 1.14px;">{{ __('lum.polaroids.share') }}</p>
                </div>
            </div>
        @endforeach

        <p class="absolute left-1/2 top-[1630px] w-[856px] -translate-x-1/2 text-center lum-body text-lum-espresso" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.1">{{ $restaurant['gallery']['body_bottom'] }}</p>

        <img src="{{ $img('dining/detail/shared/divider.svg') }}" alt="" class="absolute bottom-0 left-[72px] h-[63px] w-[1776px]" width="1776" height="63">
    </div>
</section>
