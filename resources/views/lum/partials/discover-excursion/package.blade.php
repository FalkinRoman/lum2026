@php
    $package = $excursion['package'];
    $items = $package['items'];
@endphp

<section class="lum-container relative overflow-hidden bg-lum-ivory" data-lum-villa-panel data-lum-excursion-package>
    {{-- MOBILE — Figma 196:643 — section pt 44 after gallery divider --}}
    <div class="relative tab:hidden">
        <div class="flex flex-col items-center px-[20px] pb-[44px] pt-[44px]">
            <p class="lum-script w-[335px] text-center text-[24px] leading-none tracking-[1.2px] text-[#752a23]" data-lum-villa-eyebrow>{{ $package['eyebrow'] }}</p>

            <h2 class="mt-[44px] w-[335px] text-center font-serif text-[42px] leading-[45px] text-lum-espresso" data-lum-scroll-reveal>
                {{ $package['title_normal'] }}<span class="font-medium italic">{{ $package['title_italic'] }}</span>
            </h2>

            <div class="mt-[44px] flex w-[335px] flex-col" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.08">
                @foreach ($items as $index => $item)
                    @if ($index === 0)
                        <img src="{{ $img('discover/package-line.svg') }}" alt="" class="h-px w-full" width="335" height="1">
                    @endif
                    <p class="py-[11px] text-center text-[14px] font-medium leading-[14px] tracking-[0.1px] text-lum-espresso">{{ $item }}</p>
                    <img src="{{ $img('discover/package-line.svg') }}" alt="" class="h-px w-full" width="335" height="1">
                @endforeach
            </div>

            <a href="{{ $excursion['book_url'] ?? \App\Support\Site::bookUrl() }}" class="lum-btn lum-btn-info mt-[64px] whitespace-nowrap text-[14px] leading-[23px] tracking-[2.84px]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.12">{{ __('lum.excursion.book') }}</a>

            <p class="mt-[32px] whitespace-nowrap text-center text-[12px] font-medium leading-[14px] tracking-[0.6px] text-[#752a23]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.14">{{ $package['cost'] }}</p>

            <div class="mt-[80px] flex w-full flex-col gap-[40px]">
                <div class="h-[396px] w-full overflow-hidden" data-lum-villa-card>
                    <img src="{{ $img($assetBase . '/package-01.webp') }}" alt="" class="h-full w-full object-cover" width="335" height="396" loading="lazy">
                </div>
                <div class="h-[396px] w-full overflow-hidden" data-lum-villa-card>
                    <img src="{{ $img($assetBase . '/package-02.webp') }}" alt="" class="h-full w-full object-cover" width="335" height="396" loading="lazy">
                </div>
            </div>
        </div>
    </div>

    {{-- TABLET — Figma 196:533 — section pt 80 after gallery divider --}}
    <div class="relative hidden tab:block desk:hidden">
        <div class="flex flex-col items-center px-[20px] pb-[80px] pt-[80px]">
            <p class="lum-script whitespace-nowrap text-center text-[28px] leading-none tracking-[1.4px] text-[#752a23]" data-lum-villa-eyebrow>{{ $package['eyebrow'] }}</p>

            <h2 class="mt-[44px] text-center font-serif text-[52px] leading-[52px] text-lum-espresso" data-lum-scroll-reveal>
                {{ $package['title_normal'] }}<span class="font-medium italic">{{ $package['title_italic'] }}</span>
            </h2>

            <div class="mt-[44px] flex w-[640px] flex-col" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.08">
                @foreach ($items as $index => $item)
                    @if ($index === 0)
                        <img src="{{ $img('discover/package-line.svg') }}" alt="" class="h-px w-full" width="640" height="1">
                    @endif
                    <p class="py-[9.5px] text-center lum-text-2 font-medium text-lum-espresso">{{ $item }}</p>
                    <img src="{{ $img('discover/package-line.svg') }}" alt="" class="h-px w-full" width="640" height="1">
                @endforeach
            </div>

            <a href="{{ $excursion['book_url'] ?? \App\Support\Site::bookUrl() }}" class="lum-btn lum-btn-info mt-[64px] whitespace-nowrap lum-text-2 tracking-[3.2px]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.12">{{ __('lum.excursion.book') }}</a>

            <p class="mt-[32px] whitespace-nowrap text-center text-[14px] font-medium leading-[14px] tracking-[0.6px] text-[#752a23]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.14">{{ $package['cost'] }}</p>

            <div class="mt-[80px] flex w-full gap-[20px]">
                <div class="h-[532px] w-[450px] overflow-hidden" data-lum-villa-card>
                    <img src="{{ $img($assetBase . '/package-01.webp') }}" alt="" class="h-full w-full object-cover" width="450" height="532" loading="lazy">
                </div>
                <div class="h-[532px] w-[450px] overflow-hidden" data-lum-villa-card>
                    <img src="{{ $img($assetBase . '/package-02.webp') }}" alt="" class="h-full w-full object-cover" width="450" height="532" loading="lazy">
                </div>
            </div>
        </div>
    </div>

    {{-- DESKTOP — Figma 196:418 — section pt 120 after gallery divider --}}
    <div class="relative hidden desk:block">
        <div class="flex flex-col items-center pb-0 pt-[120px]">
            <p class="lum-script whitespace-nowrap text-center text-[28px] leading-none tracking-[1.4px] text-[#752a23]" data-lum-villa-eyebrow>{{ $package['eyebrow'] }}</p>

            <h2 class="mt-[44px] w-[856px] text-center font-serif text-[88px] leading-[94px] text-lum-espresso" data-lum-scroll-reveal>
                {{ $package['title_normal'] }}<br><span class="font-medium italic">{{ $package['title_italic'] }}</span>
            </h2>

            <div class="relative mt-[80px] flex w-[1776px] items-start justify-between">
                <div class="h-[532px] w-[396px] shrink-0 overflow-hidden" data-lum-villa-card>
                    <img src="{{ $img($assetBase . '/package-02.webp') }}" alt="" class="h-full w-full object-cover" width="396" height="532" loading="lazy">
                </div>

                <div class="flex w-[856px] flex-col items-center">
                    <div class="flex w-full flex-col" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.08">
                        @foreach ($items as $index => $item)
                            @if ($index === 0)
                                <img src="{{ $img('discover/package-line.svg') }}" alt="" class="h-px w-full" width="856" height="1">
                            @endif
                            <p class="py-[9.5px] text-center lum-text-2 font-medium text-lum-espresso">{{ $item }}</p>
                            <img src="{{ $img('discover/package-line.svg') }}" alt="" class="h-px w-full" width="856" height="1">
                        @endforeach
                    </div>

                    <a href="{{ $excursion['book_url'] ?? \App\Support\Site::bookUrl() }}" class="lum-btn lum-btn-info mt-[120px] whitespace-nowrap lum-text-2 tracking-[3.2px]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.12">{{ __('lum.excursion.book') }}</a>

                    <p class="mt-[44px] whitespace-nowrap text-center text-[14px] font-medium leading-[14px] tracking-[0.6px] text-[#752a23]" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.14">{{ $package['cost'] }}</p>
                </div>

                <div class="h-[532px] w-[396px] shrink-0 overflow-hidden" data-lum-villa-card>
                    <img src="{{ $img($assetBase . '/package-01.webp') }}" alt="" class="h-full w-full object-cover" width="396" height="532" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>
