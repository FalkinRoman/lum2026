@php
    $facilities = trans('lum.villa.facilities');
@endphp

<section class="lum-container relative bg-lum-ivory h-[1594px] tab:h-[1204px] desk:h-[992px]" data-lum-villa-panel>
    {{-- MOBILE --}}
    <div class="relative h-full tab:hidden">
        <p class="lum-script absolute left-1/2 top-[44px] -translate-x-1/2 whitespace-nowrap text-[24px] leading-none tracking-[1.2px] text-lum-espresso" data-lum-villa-eyebrow>{{ $facilities['eyebrow'] }}</p>

        <div class="absolute left-1/2 top-[104px] w-[302px] -translate-x-1/2 text-center" data-lum-scroll-reveal>
            <h2 class="font-serif text-[36px] leading-[45px] text-lum-espresso">
                {{ $facilities['title_normal'] }}<br><span class="font-medium italic">{{ $facilities['title_italic'] }}</span>
            </h2>
        </div>

        <div class="absolute left-[20px] top-[238px] w-[335px]" data-lum-scroll-stagger>
            @foreach (array_merge($facilities['items_left'], $facilities['items_right']) as $item)
                <div class="flex h-[36px] flex-col justify-between border-y border-lum-espresso/40 py-[11px] text-center text-[12px] font-medium uppercase leading-[14px] tracking-[0.6px] text-lum-espresso" data-lum-scroll-item>{{ $item }}</div>
            @endforeach
        </div>

        <img src="{{ $img('villa/facilities-left.webp') }}" alt="" class="absolute left-[20px] top-[458px] h-[396px] w-[335px] object-cover shadow-[3px_3px_0_rgba(0,0,0,0.25)]" width="335" height="396" loading="lazy" data-lum-villa-card>
        <img src="{{ $img('villa/facilities-right.webp') }}" alt="" class="absolute left-[20px] top-[1118px] h-[396px] w-[335px] object-cover shadow-[3px_3px_0_rgba(0,0,0,0.25)]" width="335" height="396" loading="lazy" data-lum-villa-card>
    </div>

    {{-- TABLET --}}
    <div class="relative hidden h-full tab:block desk:hidden">
        <p class="lum-script absolute left-1/2 top-[80px] -translate-x-1/2 whitespace-nowrap text-[28px] leading-none tracking-[1.4px] text-lum-espresso" data-lum-villa-eyebrow>{{ $facilities['eyebrow'] }}</p>

        <div class="absolute left-1/2 top-[152px] w-[374px] -translate-x-1/2 text-center" data-lum-scroll-reveal>
            <h2 class="font-serif text-[52px] leading-[52px] text-lum-espresso">
                {{ $facilities['title_normal'] }}<br><span class="font-medium italic">{{ $facilities['title_italic'] }}</span>
            </h2>
        </div>

        <div class="absolute left-[20px] top-[316px] w-[450px]" data-lum-scroll-stagger>
            @foreach ($facilities['items_left'] as $item)
                <div class="flex h-[44px] flex-col justify-center border-y border-lum-espresso/40 text-center lum-text-2 font-medium uppercase text-lum-espresso" data-lum-scroll-item>{{ $item }}</div>
            @endforeach
        </div>
        <div class="absolute left-[490px] top-[316px] w-[450px]" data-lum-scroll-stagger>
            @foreach ($facilities['items_right'] as $item)
                <div class="flex h-[44px] flex-col justify-center border-y border-lum-espresso/40 text-center lum-text-2 font-medium uppercase text-lum-espresso" data-lum-scroll-item>{{ $item }}</div>
            @endforeach
        </div>

        <img src="{{ $img('villa/facilities-left.webp') }}" alt="" class="absolute left-[20px] top-[592px] h-[532px] w-[450px] object-cover shadow-[3px_3px_0_rgba(0,0,0,0.25)]" width="450" height="532" loading="lazy" data-lum-villa-card>
        <img src="{{ $img('villa/facilities-right.webp') }}" alt="" class="absolute left-[490px] top-[592px] h-[532px] w-[450px] object-cover shadow-[3px_3px_0_rgba(0,0,0,0.25)]" width="450" height="532" loading="lazy" data-lum-villa-card>
    </div>

    {{-- DESKTOP --}}
    <div class="relative hidden h-full desk:block">
        <p class="lum-script absolute left-1/2 top-[120px] -translate-x-1/2 whitespace-nowrap text-[32px] leading-none tracking-[1.6px] text-lum-espresso" data-lum-villa-eyebrow>{{ $facilities['eyebrow'] }}</p>

        <div class="absolute left-1/2 top-[192px] w-[856px] -translate-x-1/2 text-center" data-lum-scroll-reveal>
            <h2 class="font-serif text-[88px] leading-[94px] text-lum-espresso">
                {{ $facilities['title_normal'] }}<br><span class="font-medium italic">{{ $facilities['title_italic'] }}</span>
            </h2>
        </div>

        <div class="absolute left-[532px] top-[460px] w-[396px]" data-lum-scroll-stagger>
            @foreach ($facilities['items_left'] as $item)
                <div class="flex h-[44px] flex-col justify-center border-y border-lum-espresso/40 text-center lum-text-2 font-medium uppercase text-lum-espresso" data-lum-scroll-item>{{ $item }}</div>
            @endforeach
        </div>
        <div class="absolute left-[992px] top-[460px] w-[396px]" data-lum-scroll-stagger>
            @foreach ($facilities['items_right'] as $item)
                <div class="flex h-[44px] flex-col justify-center border-y border-lum-espresso/40 text-center lum-text-2 font-medium uppercase text-lum-espresso" data-lum-scroll-item>{{ $item }}</div>
            @endforeach
        </div>

        <img src="{{ $img('villa/facilities-left.webp') }}" alt="" class="absolute left-[72px] top-[460px] h-[532px] w-[396px] object-cover shadow-[3px_3px_0_rgba(0,0,0,0.25)]" width="396" height="532" loading="lazy" data-lum-villa-card>
        <img src="{{ $img('villa/facilities-right.webp') }}" alt="" class="absolute left-[1452px] top-[460px] h-[532px] w-[396px] object-cover shadow-[3px_3px_0_rgba(0,0,0,0.25)]" width="396" height="532" loading="lazy" data-lum-villa-card>
    </div>
</section>
