@php
    $rawPolaroids = is_array($activity['gallery']['polaroids'] ?? null) ? $activity['gallery']['polaroids'] : [];
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
            1 => [['left' => '108px', 'top' => '458px', 'rotate' => '5deg']],
            2 => [
                ['left' => '20px', 'top' => '458px', 'rotate' => '8deg'],
                ['left' => '195px', 'top' => '458px', 'rotate' => '-6deg'],
            ],
        ],
        'tab' => [
            1 => [['left' => '255px', 'top' => '430px', 'rotate' => '4deg']],
            2 => [
                ['left' => '20px', 'top' => '430px', 'rotate' => '6deg'],
                ['left' => '490px', 'top' => '430px', 'rotate' => '-4deg'],
            ],
        ],
        'desk' => [
            1 => [['left' => '685px', 'top' => '695px', 'rotate' => '3deg']],
            2 => [
                ['left' => '372px', 'top' => '695px', 'rotate' => '4deg'],
                ['left' => '999px', 'top' => '695px', 'rotate' => '-3deg'],
            ],
            3 => [
                ['left' => '72px', 'top' => '695px', 'rotate' => '5deg'],
                ['left' => '685px', 'top' => '695px', 'rotate' => '-3deg'],
                ['left' => '1299px', 'top' => '695px', 'rotate' => '7deg'],
            ],
        ],
    ];

    $countMob = min($polaroidCount, 2);
    $countTab = min($polaroidCount, 2);
    $countDesk = min($polaroidCount, 3);

    $galleryPolaroids = ['mob' => [], 'tab' => [], 'desk' => []];

    if ($countMob > 0) {
        foreach (array_slice($cmsPolaroids, 0, $countMob) as $i => $item) {
            $galleryPolaroids['mob'][] = array_merge($slots['mob'][$countMob][$i], ['fw' => 160, 'fh' => 226, 'dateSize' => 10, 'shareSize' => 9, 'dateTop' => 8, 'shareBottom' => 22], $item);
        }
    }

    if ($countTab > 0) {
        foreach (array_slice($cmsPolaroids, 0, $countTab) as $i => $item) {
            $galleryPolaroids['tab'][] = array_merge($slots['tab'][$countTab][$i], ['fw' => 450, 'fh' => 635, 'dateSize' => 13, 'shareSize' => 17, 'dateTop' => 34, 'shareBottom' => 92], $item);
        }
    }

    if ($countDesk > 0) {
        foreach (array_slice($cmsPolaroids, 0, $countDesk) as $i => $item) {
            $galleryPolaroids['desk'][] = array_merge($slots['desk'][$countDesk][$i], ['fw' => 549, 'fh' => 775, 'dateSize' => 16, 'shareSize' => 23, 'dateTop' => 42, 'shareBottom' => 106], $item);
        }
    }
@endphp

<section @class([
    'lum-container relative overflow-visible bg-lum-ivory desk:w-[1920px]',
    'h-[980px] tab:h-[1403px] desk:h-[1890px]' => $hasPolaroids,
    'h-[730px] tab:h-[980px] desk:h-[1330px]' => ! $hasPolaroids,
]) data-lum-villa-panel>
    {{-- MOBILE — Figma 190:729 --}}
    <div class="relative h-full tab:hidden">
        <p class="lum-script absolute inset-x-0 top-[88px] whitespace-nowrap text-center text-[24px] leading-none tracking-[1.2px] text-[#752a23]" data-lum-villa-eyebrow>{{ $activity['gallery']['eyebrow'] }}</p>

        <div class="absolute left-[20px] top-[172px] flex w-[335px] flex-col items-center text-center" data-lum-scroll-reveal>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
            <div class="mt-[22px] flex w-full flex-col items-center gap-[24px]">
                <h2 class="font-serif text-[36px] leading-[45px] text-lum-espresso">
                    {{ $activity['gallery']['title_normal'] }}<br><span class="font-medium italic">{{ $activity['gallery']['title_italic'] }}</span>
                </h2>
                <p class="text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">{{ $activity['gallery']['body'] }}</p>
            </div>
        </div>

        @foreach ($galleryPolaroids['mob'] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});" data-lum-villa-polaroid>
                <div class="relative" style="width: {{ $polaroid['fw'] }}px; height: {{ $polaroid['fh'] }}px;">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                    <p class="lum-villa-polaroid__script absolute left-0 right-0 z-[3] text-center leading-none" style="top: {{ $polaroid['dateTop'] }}px; font-size: {{ $polaroid['dateSize'] }}px; letter-spacing: 0.23px;">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img($polaroid['path']) }}" alt="" class="lum-polaroid__photo">
                    <p class="lum-villa-polaroid__script lum-villa-polaroid__share absolute left-0 right-0 z-[3] px-[4px] text-center leading-[1]" style="bottom: {{ $polaroid['shareBottom'] }}px; font-size: {{ $polaroid['shareSize'] }}px; letter-spacing: 0.2px;">{{ __('lum.polaroids.share') }}</p>
                </div>
            </div>
        @endforeach

        <p @class([
            'absolute left-[43px] w-[290px] text-center text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso',
            'top-[748px]' => $hasPolaroids,
            'top-[470px]' => ! $hasPolaroids,
        ]) data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.1">{{ $activity['gallery']['body_bottom'] }}</p>

        <img src="{{ $img('dining/detail/shared/divider-mob.svg') }}" alt="" class="absolute bottom-0 left-[20px] h-[31px] w-[335px]" width="335" height="31">
    </div>

    {{-- TABLET — Figma 190:581 --}}
    <div class="relative hidden h-full tab:block desk:hidden">
        <p class="lum-script absolute inset-x-0 top-[44px] whitespace-nowrap text-center text-[28px] leading-none tracking-[1.4px] text-[#752a23]" data-lum-villa-eyebrow>{{ $activity['gallery']['eyebrow'] }}</p>

        <div class="absolute left-1/2 top-[145px] flex w-[800px] -translate-x-1/2 flex-col items-center text-center" data-lum-scroll-reveal>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8">
            <div class="mt-[20px] flex w-full flex-col items-center gap-[32px]">
                <h2 class="font-serif text-[52px] leading-[52px] text-lum-espresso">
                    {{ $activity['gallery']['title_normal'] }}<br><span class="font-medium italic">{{ $activity['gallery']['title_italic'] }}</span>
                </h2>
                <p class="max-w-[560px] lum-text-2 text-lum-espresso">{{ $activity['gallery']['body'] }}</p>
            </div>
        </div>

        @foreach ($galleryPolaroids['tab'] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});" data-lum-villa-polaroid>
                <div class="relative" style="width: {{ $polaroid['fw'] }}px; height: {{ $polaroid['fh'] }}px;">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                    <p class="lum-villa-polaroid__script absolute left-0 right-0 z-[3] text-center leading-none" style="top: {{ $polaroid['dateTop'] }}px; font-size: {{ $polaroid['dateSize'] }}px; letter-spacing: 0.4px;">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img($polaroid['path']) }}" alt="" class="lum-polaroid__photo">
                    <p class="lum-villa-polaroid__script lum-villa-polaroid__share absolute left-0 right-0 z-[3] px-[10px] text-center leading-[1.05]" style="bottom: {{ $polaroid['shareBottom'] }}px; font-size: {{ $polaroid['shareSize'] }}px; letter-spacing: 0.5px;">{{ __('lum.polaroids.share') }}</p>
                </div>
            </div>
        @endforeach

        <p @class([
            'absolute left-1/2 w-[560px] -translate-x-1/2 text-center lum-text-2 text-lum-espresso',
            'top-[1184px]' => $hasPolaroids,
            'top-[760px]' => ! $hasPolaroids,
        ]) data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.1">{{ $activity['gallery']['body_bottom'] }}</p>

        <img src="{{ $img('dining/detail/shared/divider-tab.svg') }}" alt="" class="absolute bottom-0 left-[20px] h-[39px] w-[920px]" width="920" height="39">
    </div>

    {{-- DESKTOP — Figma 190:402 --}}
    <div class="relative hidden h-full desk:block">
        <p class="lum-script absolute inset-x-0 top-[240px] whitespace-nowrap text-center text-[32px] leading-none tracking-[1.6px] text-[#752a23]" data-lum-villa-eyebrow>{{ $activity['gallery']['eyebrow'] }}</p>

        <div class="absolute left-1/2 top-[323px] flex w-[856px] -translate-x-1/2 flex-col items-center text-center" data-lum-scroll-reveal>
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12">
            <div class="mt-[36px] flex w-full flex-col items-center gap-[44px]">
                <h2 class="font-serif text-[88px] leading-[94px] text-lum-espresso">
                    {{ $activity['gallery']['title_normal'] }}<br><span class="font-medium italic">{{ $activity['gallery']['title_italic'] }}</span>
                </h2>
                <p class="lum-body text-lum-espresso">{{ $activity['gallery']['body'] }}</p>
            </div>
        </div>

        @foreach ($galleryPolaroids['desk'] as $polaroid)
            <div class="absolute" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});" data-lum-villa-polaroid>
                <div class="relative" style="width: {{ $polaroid['fw'] }}px; height: {{ $polaroid['fh'] }}px;">
                    <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                    <p class="lum-villa-polaroid__script absolute left-0 right-0 z-[3] text-center leading-none" style="top: {{ $polaroid['dateTop'] }}px; font-size: {{ $polaroid['dateSize'] }}px; letter-spacing: 0.79px;">{{ $polaroid['date'] }}</p>
                    <img src="{{ $img($polaroid['path']) }}" alt="" class="lum-polaroid__photo">
                    <p class="lum-villa-polaroid__script lum-villa-polaroid__share absolute left-0 right-0 z-[3] px-[12px] text-center leading-[1.05]" style="bottom: {{ $polaroid['shareBottom'] }}px; font-size: {{ $polaroid['shareSize'] }}px; letter-spacing: 1.14px;">{{ __('lum.polaroids.share') }}</p>
                </div>
            </div>
        @endforeach

        <p @class([
            'absolute left-1/2 w-[856px] -translate-x-1/2 text-center lum-body text-lum-espresso',
            'top-[1630px]' => $hasPolaroids,
            'top-[1020px]' => ! $hasPolaroids,
        ]) data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.1">{{ $activity['gallery']['body_bottom'] }}</p>

        <img src="{{ $img('dining/detail/shared/divider.svg') }}" alt="" class="absolute bottom-0 left-[72px] h-[63px] w-[1776px]" width="1776" height="63">
    </div>
</section>
