@php
    $rawPolaroids = is_array($villa['gallery']['polaroids'] ?? null) ? $villa['gallery']['polaroids'] : [];
    $cmsPolaroids = [];

    foreach (array_slice($rawPolaroids, 0, 3) as $item) {
        $path = is_array($item) && filled($item['path'] ?? null)
            ? (string) $item['path']
            : null;

        if (! $path) {
            continue;
        }

        $cmsPolaroids[] = [
            'path' => $path,
            'date' => is_array($item) && filled($item['date'] ?? null) ? (string) $item['date'] : '',
        ];
    }

    $polaroidCount = count($cmsPolaroids);
    $hasPolaroids = $polaroidCount > 0;

    $slots = [
        'mob' => [
            1 => [
                ['left' => '108px', 'top' => '430px', 'rotate' => '5deg'],
            ],
            2 => [
                ['left' => '20px', 'top' => '430px', 'rotate' => '8deg'],
                ['left' => '195px', 'top' => '430px', 'rotate' => '-6deg'],
            ],
        ],
        'tab' => [
            1 => [
                ['left' => '255px', 'top' => '385px', 'rotate' => '4deg'],
            ],
            2 => [
                ['left' => '20px', 'top' => '385px', 'rotate' => '6deg'],
                ['left' => '490px', 'top' => '385px', 'rotate' => '-4deg'],
            ],
        ],
        'desk' => [
            1 => [
                ['left' => '685px', 'top' => '560px', 'rotate' => '3deg'],
            ],
            2 => [
                ['left' => '372px', 'top' => '560px', 'rotate' => '4deg'],
                ['left' => '999px', 'top' => '560px', 'rotate' => '-3deg'],
            ],
            3 => [
                ['left' => '72px', 'top' => '560px', 'rotate' => '5deg'],
                ['left' => '685px', 'top' => '560px', 'rotate' => '-3deg'],
                ['left' => '1299px', 'top' => '560px', 'rotate' => '7deg'],
            ],
        ],
    ];

    $countMob = min($polaroidCount, 2);
    $countTab = min($polaroidCount, 2);
    $countDesk = min($polaroidCount, 3);

    $galleryPolaroids = [
        'mob' => [],
        'tab' => [],
        'desk' => [],
    ];

    if ($countMob > 0) {
        foreach (array_slice($cmsPolaroids, 0, $countMob) as $i => $item) {
            $slot = $slots['mob'][$countMob][$i];
            $galleryPolaroids['mob'][] = array_merge($slot, ['fw' => 160, 'fh' => 226, 'px' => 13, 'py' => 21, 'pw' => 133, 'ph' => 141, 'dateSize' => 10, 'shareSize' => 9, 'dateTop' => 8, 'shareBottom' => 22], $item);
        }
    }

    if ($countTab > 0) {
        foreach (array_slice($cmsPolaroids, 0, $countTab) as $i => $item) {
            $slot = $slots['tab'][$countTab][$i];
            $galleryPolaroids['tab'][] = array_merge($slot, ['fw' => 450, 'fh' => 635, 'px' => 37, 'py' => 59, 'pw' => 374, 'ph' => 418, 'dateSize' => 13, 'shareSize' => 17, 'dateTop' => 34, 'shareBottom' => 92], $item);
        }
    }

    if ($countDesk > 0) {
        foreach (array_slice($cmsPolaroids, 0, $countDesk) as $i => $item) {
            $slot = $slots['desk'][$countDesk][$i];
            $galleryPolaroids['desk'][] = array_merge($slot, ['fw' => 549, 'fh' => 775, 'px' => 45, 'py' => 72, 'pw' => 456, 'ph' => 509, 'dateSize' => 16, 'shareSize' => 23, 'dateTop' => 42, 'shareBottom' => 106], $item);
        }
    }
@endphp

{{-- No scroll-hide: opacity:0 + heavy CMS polaroids = pause then pop --}}
<section @class([
    'lum-container relative bg-lum-ivory desk:w-[1920px]',
    'h-[952px] tab:h-[1400px] desk:h-[1756px]' => $hasPolaroids,
    'h-[700px] tab:h-[930px] desk:h-[1180px]' => ! $hasPolaroids,
]) data-lum-villa-panel data-lum-gallery>
    {{-- MOBILE — Figma 78:738 --}}
    <div class="relative h-full tab:hidden">
        <p class="lum-script absolute inset-x-0 top-[60px] whitespace-nowrap text-center text-[24px] leading-none tracking-[1.2px] text-lum-espresso">{{ $villa['gallery']['eyebrow'] }}</p>

        <div class="absolute left-[20px] top-[144px] flex w-[335px] flex-col items-center gap-[22px] text-center">
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
            <h2 class="font-serif text-[36px] leading-[45px] text-lum-espresso">
                {{ $villa['gallery']['title_normal'] }}<br><span class="font-medium italic">{{ $villa['gallery']['title_italic'] }}</span>
            </h2>
            <p class="text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">{{ $villa['gallery']['body'] }}</p>
        </div>

        @foreach ($galleryPolaroids['mob'] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});">
                <div class="relative" style="width: {{ $polaroid['fw'] }}px; height: {{ $polaroid['fh'] }}px;">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425" decoding="async">
                    <p class="lum-villa-polaroid__script absolute left-0 right-0 z-[3] text-center leading-none" style="top: {{ $polaroid['dateTop'] }}px; font-size: {{ $polaroid['dateSize'] }}px; letter-spacing: 0.23px;">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img($polaroid['path']) }}" alt="" class="lum-polaroid__photo" width="{{ $polaroid['pw'] }}" height="{{ $polaroid['ph'] }}" loading="lazy" decoding="async" data-lum-warm-img>
                    <p class="lum-villa-polaroid__script lum-villa-polaroid__share absolute left-0 right-0 z-[3] px-[4px] text-center leading-[1]" style="bottom: {{ $polaroid['shareBottom'] }}px; font-size: {{ $polaroid['shareSize'] }}px; letter-spacing: 0.2px;">{{ __('lum.polaroids.share') }}</p>
                </div>
            </div>
        @endforeach

        <p @class([
            'absolute left-[20px] w-[335px] text-center text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso',
            'top-[720px]' => $hasPolaroids,
            'top-[430px]' => ! $hasPolaroids,
        ])>{{ $villa['gallery']['body_bottom'] }}</p>

        <div class="absolute bottom-[31px] left-[20px] flex w-[335px] items-center gap-[22px]">
            <div class="h-px flex-1 bg-lum-espresso/40"></div>
            <img src="{{ $img('villa/divider-sun-mob.svg') }}" alt="" class="size-[32px]" width="32" height="32" data-lum-villa-divider>
            <div class="h-px flex-1 bg-lum-espresso/40"></div>
        </div>
    </div>

    {{-- TABLET — Figma 78:566 --}}
    <div class="relative hidden h-full tab:block desk:hidden">
        <p class="lum-script absolute inset-x-0 top-0 whitespace-nowrap text-center text-[28px] leading-none tracking-[1.4px] text-lum-espresso">{{ $villa['gallery']['eyebrow'] }}</p>

        <div class="absolute left-1/2 top-[101px] flex w-[800px] -translate-x-1/2 flex-col items-center gap-[20px] text-center">
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8">
            <h2 class="font-serif text-[52px] leading-[52px] text-lum-espresso">
                {{ $villa['gallery']['title_normal'] }}<br><span class="font-medium italic">{{ $villa['gallery']['title_italic'] }}</span>
            </h2>
            <p class="max-w-[560px] lum-text-2 text-lum-espresso">{{ $villa['gallery']['body'] }}</p>
        </div>

        @foreach ($galleryPolaroids['tab'] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});">
                <div class="relative" style="width: {{ $polaroid['fw'] }}px; height: {{ $polaroid['fh'] }}px;">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425" decoding="async">
                    <p class="lum-villa-polaroid__script absolute left-0 right-0 z-[3] text-center leading-none" style="top: {{ $polaroid['dateTop'] }}px; font-size: {{ $polaroid['dateSize'] }}px; letter-spacing: 0.4px;">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img($polaroid['path']) }}" alt="" class="lum-polaroid__photo" width="{{ $polaroid['pw'] }}" height="{{ $polaroid['ph'] }}" loading="lazy" decoding="async" data-lum-warm-img>
                    <p class="lum-villa-polaroid__script lum-villa-polaroid__share absolute left-0 right-0 z-[3] px-[10px] text-center leading-[1.05]" style="bottom: {{ $polaroid['shareBottom'] }}px; font-size: {{ $polaroid['shareSize'] }}px; letter-spacing: 0.5px;">{{ __('lum.polaroids.share') }}</p>
                </div>
            </div>
        @endforeach

        <p @class([
            'absolute left-1/2 w-[560px] -translate-x-1/2 text-center lum-text-2 text-lum-espresso',
            'top-[1140px]' => $hasPolaroids,
            'top-[690px]' => ! $hasPolaroids,
        ])>{{ $villa['gallery']['body_bottom'] }}</p>

        <div class="absolute bottom-[39px] left-[20px] flex w-[920px] items-center gap-[22px]">
            <div class="h-px flex-1 bg-lum-espresso/40"></div>
            <img src="{{ $img('villa/divider-sun-tab.svg') }}" alt="" class="size-[40px]" width="40" height="40" data-lum-villa-divider>
            <div class="h-px flex-1 bg-lum-espresso/40"></div>
        </div>
    </div>

    {{-- DESKTOP — Figma 78:376 --}}
    <div class="relative hidden h-full desk:block">
        <p class="lum-script absolute inset-x-0 top-[105px] whitespace-nowrap text-center text-[32px] leading-none tracking-[1.6px] text-lum-espresso">{{ $villa['gallery']['eyebrow'] }}</p>

        <div class="absolute left-1/2 top-[188px] flex w-[856px] -translate-x-1/2 flex-col items-center gap-[24px] text-center">
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12">
            <h2 class="font-serif text-[88px] leading-[94px] text-lum-espresso">
                {{ $villa['gallery']['title_normal'] }}<br><span class="font-medium italic">{{ $villa['gallery']['title_italic'] }}</span>
            </h2>
            <p class="lum-body text-lum-espresso">{{ $villa['gallery']['body'] }}</p>
        </div>

        @foreach ($galleryPolaroids['desk'] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});">
                <div class="relative" style="width: {{ $polaroid['fw'] }}px; height: {{ $polaroid['fh'] }}px;">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425" decoding="async">
                    <p class="lum-villa-polaroid__script absolute left-0 right-0 z-[3] text-center leading-none" style="top: {{ $polaroid['dateTop'] }}px; font-size: {{ $polaroid['dateSize'] }}px; letter-spacing: 0.79px;">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img($polaroid['path']) }}" alt="" class="lum-polaroid__photo" width="{{ $polaroid['pw'] }}" height="{{ $polaroid['ph'] }}" loading="lazy" decoding="async" data-lum-warm-img>
                    <p class="lum-villa-polaroid__script lum-villa-polaroid__share absolute left-0 right-0 z-[3] px-[12px] text-center leading-[1.05]" style="bottom: {{ $polaroid['shareBottom'] }}px; font-size: {{ $polaroid['shareSize'] }}px; letter-spacing: 1.14px;">{{ __('lum.polaroids.share') }}</p>
                </div>
            </div>
        @endforeach

        <p @class([
            'absolute left-1/2 w-[856px] -translate-x-1/2 text-center lum-body text-lum-espresso',
            'top-[1495px]' => $hasPolaroids,
            'top-[870px]' => ! $hasPolaroids,
        ])>{{ $villa['gallery']['body_bottom'] }}</p>

        <div class="absolute bottom-[62px] left-[72px] flex w-[1776px] items-center gap-[22px]">
            <div class="h-px flex-1 bg-lum-espresso/40"></div>
            <img src="{{ $img('villa/divider-sun-desk.svg') }}" alt="" class="size-[64px]" width="64" height="64" data-lum-villa-divider>
            <div class="h-px flex-1 bg-lum-espresso/40"></div>
        </div>
    </div>
</section>
