@php
    $properties = trans('lum.stay.properties');

    $mobileLayout = [
        ['imageTop' => 495, 'textTop' => 901],
        ['imageTop' => 1041, 'textTop' => 1447],
        ['imageTop' => 1587, 'textTop' => 1993],
        ['imageTop' => 2133, 'textTop' => 2539],
    ];

    $tabletLayout = [
        ['left' => 20, 'imageTop' => 615, 'textTop' => 1172],
        ['left' => 490, 'imageTop' => 615, 'textTop' => 1172],
        ['left' => 20, 'imageTop' => 1340, 'textTop' => 1897],
        ['left' => 490, 'imageTop' => 1340, 'textTop' => 1897],
    ];

    $desktopLayout = [
        ['left' => 225, 'imageTop' => 942, 'textTop' => 1794],
        ['left' => 992, 'imageTop' => 942, 'textTop' => 1794],
        ['left' => 225, 'imageTop' => 1968, 'textTop' => 2820],
        ['left' => 992, 'imageTop' => 1968, 'textTop' => 2820],
    ];
@endphp

<section id="stay" class="lum-container relative bg-lum-ivory">
    {{-- MOBILE — Figma 73:673 --}}
    <div class="relative h-[2719px] tab:hidden">
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])

        <div class="absolute left-1/2 top-[124px] flex w-[335px] -translate-x-1/2 flex-col items-center gap-[16px] text-center" data-lum-scroll-reveal>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
            <h1 class="font-serif text-[42px] leading-[45px] text-lum-espresso">
                {{ __('lum.stay.title_line1') }}<br>
                {{ __('lum.stay.title_line2') }}<br>
                <span class="font-medium italic">{{ __('lum.stay.title_italic') }}</span>
            </h1>
        </div>

        <p class="absolute left-1/2 top-[313px] -translate-x-1/2 whitespace-nowrap lum-text-3 font-medium uppercase text-lum-espresso" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.08" data-lum-sticky-trigger>{{ __('lum.stay.eyebrow') }}</p>

        @include('lum.partials.stay.scroll-arrow', ['img' => $img, 'variant' => 'mob', 'top' => 371])

        @foreach ($properties as $index => $property)
            @php $layout = $mobileLayout[$index]; @endphp

            <div class="absolute left-1/2 h-[390px] w-[335px] -translate-x-1/2 overflow-hidden" style="top: {{ $layout['imageTop'] }}px" data-lum-scroll-reveal data-lum-scroll-fade data-lum-scroll-start="top 90%">
                <img src="{{ $img('stay/' . $property['image']) }}" alt="" class="h-full w-full object-cover" width="335" height="390" loading="lazy">
                <div class="absolute inset-0 bg-black/24"></div>
                <img src="{{ $img('stay/logomark.svg') }}" alt="" class="absolute left-1/2 top-[326px] size-[32px] -translate-x-1/2" width="32" height="32">
            </div>

            <div class="absolute left-1/2 flex w-[335px] -translate-x-1/2 flex-col items-center gap-[16px] text-center" style="top: {{ $layout['textTop'] }}px" data-lum-scroll-reveal>
                <h2 class="font-serif text-[22px] font-medium leading-[24px] tracking-[0.19px] text-lum-espresso">
                    @if ($property['title_normal'] !== '')
                        <span class="font-medium not-italic">{{ $property['title_normal'] }}</span>
                    @endif
                    <span class="italic">{{ $property['title_italic'] }}</span>
                </h2>
                <img src="{{ $img('stay/divider-full.svg') }}" alt="" class="h-px w-full" width="335" height="1">
                <p class="text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">{{ $property['subtitle'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- TABLET — Figma 73:579 --}}
    <div class="relative hidden h-[2125px] tab:block desk:hidden">
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])

        <div class="absolute left-1/2 top-[160px] flex -translate-x-1/2 flex-col items-center gap-[12px] text-center" data-lum-scroll-reveal>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8">
            <h1 class="whitespace-nowrap font-serif text-[52px] leading-[52px] text-lum-espresso">
                {{ __('lum.stay.title_line1') }}<br>
                {{ __('lum.stay.title_line2') }}<br>
                <span class="font-medium italic">{{ __('lum.stay.title_italic') }}</span>
            </h1>
        </div>

        <p class="absolute left-1/2 top-[368px] -translate-x-1/2 whitespace-nowrap lum-text-2 font-medium uppercase text-lum-espresso" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.08" data-lum-sticky-trigger>{{ __('lum.stay.eyebrow') }}</p>

        @include('lum.partials.stay.scroll-arrow', ['img' => $img, 'variant' => 'tab', 'top' => 449])

        @foreach ($properties as $index => $property)
            @php $layout = $tabletLayout[$index]; @endphp

            <div class="absolute h-[525px] w-[450px] overflow-hidden" style="left: {{ $layout['left'] }}px; top: {{ $layout['imageTop'] }}px" data-lum-scroll-reveal data-lum-scroll-fade data-lum-scroll-start="top 90%">
                <img src="{{ $img('stay/' . $property['image']) }}" alt="" class="h-full w-full object-cover" width="450" height="525" loading="lazy">
                <div class="absolute inset-0 bg-black/24"></div>
                <img src="{{ $img('stay/logomark.svg') }}" alt="" class="absolute left-1/2 top-[440px] size-[40px] -translate-x-1/2" width="40" height="40">
            </div>

            <div class="absolute flex w-[450px] flex-col items-center gap-[12px] text-center" style="left: {{ $layout['left'] }}px; top: {{ $layout['textTop'] }}px" data-lum-scroll-reveal>
                <h2 class="font-serif text-[28px] font-medium leading-[34px] tracking-[0.36px] text-lum-espresso">
                    @if ($property['title_normal'] !== '')
                        <span class="font-medium not-italic">{{ $property['title_normal'] }}</span>
                    @endif
                    <span class="italic">{{ $property['title_italic'] }}</span>
                </h2>
                <img src="{{ $img('stay/divider-full.svg') }}" alt="" class="h-px w-full" width="450" height="1">
                <p class="lum-text-2 text-lum-espresso">{{ $property['subtitle'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- DESKTOP — Figma 73:487 --}}
    <div class="relative hidden h-[3074px] desk:block">
        @include('lum.partials.header', ['headerTone' => 'espresso', 'headerActive' => 'stay'])

        <div class="absolute left-1/2 top-[292px] flex w-[552px] -translate-x-1/2 flex-col items-center gap-[24px] text-center" data-lum-scroll-reveal>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12">
            <h1 class="font-serif text-[88px] leading-[94px] text-lum-espresso">
                {{ __('lum.stay.title_line1') }}<br>
                {{ __('lum.stay.title_line2') }}<br>
                <span class="font-medium italic">{{ __('lum.stay.title_italic') }}</span>
            </h1>
        </div>

        <p class="absolute left-1/2 top-[654px] -translate-x-1/2 whitespace-nowrap lum-eyebrow text-lum-espresso" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.08" data-lum-sticky-trigger>{{ __('lum.stay.eyebrow') }}</p>

        @include('lum.partials.stay.scroll-arrow', ['img' => $img, 'variant' => 'desk', 'top' => 736])

        @foreach ($properties as $index => $property)
            @php $layout = $desktopLayout[$index]; @endphp

            <div class="absolute h-[820px] w-[703px] overflow-hidden" style="left: {{ $layout['left'] }}px; top: {{ $layout['imageTop'] }}px" data-lum-scroll-reveal data-lum-scroll-fade data-lum-scroll-start="top 90%">
                <img src="{{ $img('stay/' . $property['image']) }}" alt="" class="h-full w-full object-cover" width="703" height="820" loading="lazy">
                <div class="absolute inset-0 bg-black/24"></div>
                <img src="{{ $img('stay/logomark.svg') }}" alt="" class="absolute left-1/2 top-[684px] size-[64px] -translate-x-1/2" width="64" height="64">
            </div>

            <div class="absolute flex w-[703px] flex-col items-center gap-[16px] text-center" style="left: {{ $layout['left'] }}px; top: {{ $layout['textTop'] }}px" data-lum-scroll-reveal>
                <h2 class="font-serif text-[32px] font-medium leading-[36px] tracking-[0.32px] text-lum-espresso">
                    @if ($property['title_normal'] !== '')
                        <span class="font-medium not-italic">{{ $property['title_normal'] }}</span>
                    @endif
                    <span class="italic">{{ $property['title_italic'] }}</span>
                </h2>
                <img src="{{ $img('stay/divider-full.svg') }}" alt="" class="h-px w-full" width="703" height="1">
                <p class="lum-body text-lum-espresso">{{ $property['subtitle'] }}</p>
            </div>
        @endforeach
    </div>
</section>
