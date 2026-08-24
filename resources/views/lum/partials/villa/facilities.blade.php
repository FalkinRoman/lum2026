@php
    $facilities = array_merge([
        'eyebrow' => __('lum.villa.facilities.eyebrow'),
        'title_normal' => __('lum.villa.facilities.title_normal'),
        'title_italic' => __('lum.villa.facilities.title_italic'),
        'items' => [],
        'image_left' => 'villa/facilities-left.webp',
        'image_right' => 'villa/facilities-right.webp',
    ], $villa['facilities'] ?? []);

    $items = is_array($facilities['items'] ?? null) ? array_values($facilities['items']) : [];
    if ($items === []) {
        $fallback = __('lum.villa.facilities.items');
        $items = is_array($fallback) ? array_values($fallback) : [];
    }

    $imgLeft = $facilities['image_left'];
    $imgRight = $facilities['image_right'];
@endphp

{{-- Single centered list (discover package includes pattern) + side photos on desk --}}
<section class="lum-container relative overflow-hidden bg-lum-ivory" data-lum-villa-panel data-lum-facilities>
    {{-- MOBILE --}}
    <div class="relative tab:hidden">
        <div class="flex flex-col items-center px-[20px] pb-[64px] pt-[44px]">
            <p class="lum-script w-full text-center text-[24px] leading-none tracking-[1.2px] text-lum-espresso">{{ $facilities['eyebrow'] }}</p>

            <h2 class="mt-[44px] w-[302px] text-center font-serif text-[36px] leading-[45px] text-lum-espresso">
                {{ $facilities['title_normal'] }}<br><span class="font-medium italic">{{ $facilities['title_italic'] }}</span>
            </h2>

            <div class="mt-[44px] flex w-[335px] flex-col">
                @foreach ($items as $index => $item)
                    @if ($index === 0)
                        <img src="{{ $img('discover/package-line.svg') }}" alt="" class="h-px w-full" width="335" height="1">
                    @endif
                    <p class="py-[11px] text-center text-[14px] font-medium leading-[14px] tracking-[0.1px] text-lum-espresso">{{ $item }}</p>
                    <img src="{{ $img('discover/package-line.svg') }}" alt="" class="h-px w-full" width="335" height="1">
                @endforeach
            </div>

            <div class="mt-[64px] flex w-full flex-col gap-[40px]">
                <div class="h-[396px] w-full overflow-hidden shadow-[3px_3px_0_rgba(0,0,0,0.25)]">
                    <img src="{{ $img($imgLeft) }}" alt="" class="h-full w-full object-cover" width="335" height="396" loading="lazy" decoding="async" data-lum-facilities-img>
                </div>
                <div class="h-[396px] w-full overflow-hidden shadow-[3px_3px_0_rgba(0,0,0,0.25)]">
                    <img src="{{ $img($imgRight) }}" alt="" class="h-full w-full object-cover" width="335" height="396" loading="lazy" decoding="async" data-lum-facilities-img>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLET --}}
    <div class="relative hidden tab:block desk:hidden">
        <div class="flex flex-col items-center px-[20px] pb-[80px] pt-[80px]">
            <p class="lum-script whitespace-nowrap text-center text-[28px] leading-none tracking-[1.4px] text-lum-espresso">{{ $facilities['eyebrow'] }}</p>

            <h2 class="mt-[44px] text-center font-serif text-[52px] leading-[52px] text-lum-espresso">
                {{ $facilities['title_normal'] }}<br><span class="font-medium italic">{{ $facilities['title_italic'] }}</span>
            </h2>

            <div class="mt-[44px] flex w-[640px] flex-col">
                @foreach ($items as $index => $item)
                    @if ($index === 0)
                        <img src="{{ $img('discover/package-line.svg') }}" alt="" class="h-px w-full" width="640" height="1">
                    @endif
                    <p class="py-[9.5px] text-center lum-text-2 font-medium text-lum-espresso">{{ $item }}</p>
                    <img src="{{ $img('discover/package-line.svg') }}" alt="" class="h-px w-full" width="640" height="1">
                @endforeach
            </div>

            <div class="mt-[64px] flex w-full gap-[20px]">
                <div class="h-[532px] w-[450px] overflow-hidden shadow-[3px_3px_0_rgba(0,0,0,0.25)]">
                    <img src="{{ $img($imgLeft) }}" alt="" class="h-full w-full object-cover" width="450" height="532" loading="lazy" decoding="async" data-lum-facilities-img>
                </div>
                <div class="h-[532px] w-[450px] overflow-hidden shadow-[3px_3px_0_rgba(0,0,0,0.25)]">
                    <img src="{{ $img($imgRight) }}" alt="" class="h-full w-full object-cover" width="450" height="532" loading="lazy" decoding="async" data-lum-facilities-img>
                </div>
            </div>
        </div>
    </div>

    {{-- DESKTOP — list center, photos left/right (same as discover package) --}}
    <div class="relative hidden desk:block">
        <div class="flex flex-col items-center pb-[120px] pt-[120px]">
            <p class="lum-script whitespace-nowrap text-center text-[32px] leading-none tracking-[1.6px] text-lum-espresso">{{ $facilities['eyebrow'] }}</p>

            <h2 class="mt-[44px] w-[856px] text-center font-serif text-[88px] leading-[94px] text-lum-espresso">
                {{ $facilities['title_normal'] }}<br><span class="font-medium italic">{{ $facilities['title_italic'] }}</span>
            </h2>

            <div class="relative mt-[80px] flex w-[1776px] items-start justify-between">
                <div class="h-[532px] w-[396px] shrink-0 overflow-hidden shadow-[3px_3px_0_rgba(0,0,0,0.25)]">
                    <img src="{{ $img($imgLeft) }}" alt="" class="h-full w-full object-cover" width="396" height="532" loading="lazy" decoding="async" data-lum-facilities-img>
                </div>

                <div class="flex w-[856px] flex-col items-center">
                    <div class="flex w-full flex-col">
                        @foreach ($items as $index => $item)
                            @if ($index === 0)
                                <img src="{{ $img('discover/package-line.svg') }}" alt="" class="h-px w-full" width="856" height="1">
                            @endif
                            <p class="py-[9.5px] text-center lum-text-2 font-medium text-lum-espresso">{{ $item }}</p>
                            <img src="{{ $img('discover/package-line.svg') }}" alt="" class="h-px w-full" width="856" height="1">
                        @endforeach
                    </div>
                </div>

                <div class="h-[532px] w-[396px] shrink-0 overflow-hidden shadow-[3px_3px_0_rgba(0,0,0,0.25)]">
                    <img src="{{ $img($imgRight) }}" alt="" class="h-full w-full object-cover" width="396" height="532" loading="lazy" decoding="async" data-lum-facilities-img>
                </div>
            </div>
        </div>
    </div>
</section>
