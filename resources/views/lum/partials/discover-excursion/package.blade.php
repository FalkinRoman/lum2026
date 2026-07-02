@php
    $package = $excursion['package'];
    $items = $package['items'];
@endphp

<section class="lum-container relative overflow-hidden bg-lum-ivory h-[1580px] tab:h-[1200px] desk:h-[992px]" data-lum-villa-panel data-lum-excursion-package>
    {{-- MOBILE — Figma 103:879 --}}
    <div class="relative h-full tab:hidden">
        <p class="lum-script absolute left-1/2 top-[44px] w-[335px] -translate-x-1/2 text-center text-[24px] leading-none tracking-[1.2px] text-[#752a23]" data-lum-villa-eyebrow>{{ $package['eyebrow'] }}</p>

        <h2 class="absolute left-1/2 top-[104px] w-[335px] -translate-x-1/2 text-center font-serif text-[42px] leading-[45px] text-lum-espresso" data-lum-scroll-reveal>
            {{ $package['title_normal'] }}<span class="font-medium italic">{{ $package['title_italic'] }}</span>
        </h2>

        <div class="absolute left-[20px] top-[287px] flex w-[335px] flex-col" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.08">
            @foreach ($items as $item)
                <div class="flex flex-col items-center gap-[8px] py-[8px]">
                    <img src="{{ $img('dining/line-left.svg') }}" alt="" class="h-px w-full max-w-[335px]" width="335" height="1">
                    <p class="text-center text-[14px] font-medium leading-[22px] tracking-[0.1px] text-lum-espresso">{{ $item }}</p>
                    <img src="{{ $img('dining/line-right.svg') }}" alt="" class="h-px w-full max-w-[335px]" width="335" height="1">
                </div>
            @endforeach
        </div>

        <a href="#" class="lum-btn-green absolute left-1/2 top-[620px] -translate-x-1/2 whitespace-nowrap text-[14px] leading-[23px] tracking-[2.84px]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.12">{{ __('lum.excursion.book') }}</a>

        <p class="absolute left-1/2 top-[668px] -translate-x-1/2 whitespace-nowrap text-center text-[12px] font-medium leading-[14px] tracking-[0.6px] text-[#752a23]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.14">{{ $package['cost'] }}</p>

        <div class="absolute left-[20px] top-[704px] h-[390px] w-[335px] overflow-hidden" data-lum-villa-card>
            <img src="{{ $img($assetBase . '/package-01.webp') }}" alt="" class="h-full w-full object-cover" width="335" height="390" loading="lazy">
        </div>
        <div class="absolute left-[20px] top-[1140px] h-[390px] w-[335px] overflow-hidden" data-lum-villa-card>
            <img src="{{ $img($assetBase . '/package-02.webp') }}" alt="" class="h-full w-full object-cover" width="335" height="390" loading="lazy">
        </div>
    </div>

    {{-- TABLET — Figma 103:769 --}}
    <div class="relative hidden h-full tab:block desk:hidden">
        <p class="lum-script absolute left-1/2 top-[80px] -translate-x-1/2 whitespace-nowrap text-center text-[28px] leading-none tracking-[1.4px] text-[#752a23]" data-lum-villa-eyebrow>{{ $package['eyebrow'] }}</p>

        <h2 class="absolute left-1/2 top-[152px] -translate-x-1/2 whitespace-nowrap text-center font-serif text-[52px] leading-[52px] text-lum-espresso" data-lum-scroll-reveal>
            {{ $package['title_normal'] }}<span class="font-medium italic">{{ $package['title_italic'] }}</span>
        </h2>

        <div class="absolute left-1/2 top-[332px] flex w-[560px] -translate-x-1/2 flex-col" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.08">
            @foreach ($items as $item)
                <div class="flex flex-col items-center gap-[8px] py-[8px]">
                    <img src="{{ $img('dining/line-left.svg') }}" alt="" class="h-px w-full" width="560" height="1">
                    <p class="text-center lum-text-2 font-medium text-lum-espresso">{{ $item }}</p>
                    <img src="{{ $img('dining/line-right.svg') }}" alt="" class="h-px w-full" width="560" height="1">
                </div>
            @endforeach
        </div>

        <a href="#" class="lum-btn-green absolute left-1/2 top-[700px] -translate-x-1/2 whitespace-nowrap lum-text-2 tracking-[3.2px]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.12">{{ __('lum.excursion.book') }}</a>

        <p class="absolute left-1/2 top-[756px] -translate-x-1/2 whitespace-nowrap text-center text-[14px] font-medium leading-[14px] tracking-[0.6px] text-[#752a23]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.14">{{ $package['cost'] }}</p>

        <div class="absolute left-[20px] top-[820px] h-[340px] w-[450px] overflow-hidden" data-lum-villa-card>
            <img src="{{ $img($assetBase . '/package-01.webp') }}" alt="" class="h-full w-full object-cover" width="450" height="340" loading="lazy">
        </div>
        <div class="absolute left-[490px] top-[820px] h-[340px] w-[450px] overflow-hidden" data-lum-villa-card>
            <img src="{{ $img($assetBase . '/package-02.webp') }}" alt="" class="h-full w-full object-cover" width="450" height="340" loading="lazy">
        </div>
    </div>

    {{-- DESKTOP — Figma 103:654 --}}
    <div class="relative hidden h-full desk:block">
        <p class="lum-script absolute left-1/2 top-[120px] -translate-x-1/2 whitespace-nowrap text-center text-[28px] leading-none tracking-[1.4px] text-[#752a23]" data-lum-villa-eyebrow>{{ $package['eyebrow'] }}</p>

        <h2 class="absolute left-1/2 top-[192px] w-[856px] -translate-x-1/2 text-center font-serif text-[88px] leading-[94px] text-lum-espresso" data-lum-scroll-reveal>
            {{ $package['title_normal'] }}<br><span class="font-medium italic">{{ $package['title_italic'] }}</span>
        </h2>

        <div class="absolute left-[72px] top-[460px] h-[532px] w-[396px] overflow-hidden" data-lum-villa-card>
            <img src="{{ $img($assetBase . '/package-02.webp') }}" alt="" class="h-full w-full object-cover" width="396" height="532" loading="lazy">
        </div>
        <div class="absolute left-[1452px] top-[460px] h-[532px] w-[396px] overflow-hidden" data-lum-villa-card>
            <img src="{{ $img($assetBase . '/package-01.webp') }}" alt="" class="h-full w-full object-cover" width="396" height="532" loading="lazy">
        </div>

        <div class="absolute left-[532px] top-[460px] flex w-[856px] flex-col" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.08">
            @foreach ($items as $item)
                <div class="flex flex-col items-center gap-[8px] py-[8px]">
                    <img src="{{ $img('dining/line-left.svg') }}" alt="" class="h-px w-full" width="856" height="1">
                    <p class="text-center lum-text-2 font-medium text-lum-espresso">{{ $item }}</p>
                    <img src="{{ $img('dining/line-right.svg') }}" alt="" class="h-px w-full" width="856" height="1">
                </div>
            @endforeach
        </div>

        <a href="#" class="lum-btn-green absolute left-1/2 top-[796px] -translate-x-1/2 whitespace-nowrap lum-text-2 tracking-[3.2px]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.12">{{ __('lum.excursion.book') }}</a>

        <p class="absolute left-1/2 top-[876px] -translate-x-1/2 whitespace-nowrap text-center text-[14px] font-medium leading-[14px] tracking-[0.6px] text-[#752a23]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.14">{{ $package['cost'] }}</p>
    </div>
</section>
