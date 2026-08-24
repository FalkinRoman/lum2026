@php
    $gallery = $excursion['gallery'];
    $rawPolaroids = is_array($gallery['polaroids'] ?? null) ? $gallery['polaroids'] : [];
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

    $rotations = [
        'mob' => [1 => ['5deg'], 2 => ['8deg', '-6deg']],
        'tab' => [1 => ['4deg'], 2 => ['6deg', '-4deg']],
        'desk' => [1 => ['3deg'], 2 => ['4deg', '-3deg'], 3 => ['5deg', '-3deg', '7deg']],
    ];

    $galleryPolaroids = ['mob' => [], 'tab' => [], 'desk' => []];
    $countMob = min($polaroidCount, 2);
    $countTab = min($polaroidCount, 2);
    $countDesk = min($polaroidCount, 3);

    if ($countMob > 0) {
        foreach (array_slice($cmsPolaroids, 0, $countMob) as $i => $item) {
            $galleryPolaroids['mob'][] = array_merge(['rotate' => $rotations['mob'][$countMob][$i], 'fw' => 160, 'fh' => 226, 'dateSize' => 10, 'shareSize' => 9, 'dateTop' => 8, 'shareBottom' => 22], $item);
        }
    }

    if ($countTab > 0) {
        foreach (array_slice($cmsPolaroids, 0, $countTab) as $i => $item) {
            $galleryPolaroids['tab'][] = array_merge(['rotate' => $rotations['tab'][$countTab][$i], 'fw' => 450, 'fh' => 635, 'dateSize' => 13, 'shareSize' => 17, 'dateTop' => 34, 'shareBottom' => 92], $item);
        }
    }

    if ($countDesk > 0) {
        foreach (array_slice($cmsPolaroids, 0, $countDesk) as $i => $item) {
            $galleryPolaroids['desk'][] = array_merge(['rotate' => $rotations['desk'][$countDesk][$i], 'fw' => 549, 'fh' => 775, 'dateSize' => 16, 'shareSize' => 23, 'dateTop' => 42, 'shareBottom' => 106], $item);
        }
    }
@endphp

<section class="lum-container relative bg-lum-ivory desk:w-[1920px]" data-lum-villa-panel>
    {{-- MOBILE — Figma 196:600 — body→divider 69, divider→next 44 --}}
    <div class="relative tab:hidden">
        <div class="flex flex-col items-center px-[20px] pt-[60px]">
            <p class="lum-script whitespace-nowrap text-center text-[24px] leading-none tracking-[1.2px] text-[#752a23]" data-lum-villa-eyebrow>{{ $gallery['eyebrow'] }}</p>

            <div class="mt-[56px] flex w-[335px] flex-col items-center gap-[22px] text-center" data-lum-scroll-reveal>
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                <h2 class="font-serif text-[36px] leading-[45px] text-lum-espresso">
                    {{ $gallery['title_normal'] }}<br><span class="font-medium italic">{{ $gallery['title_italic'] }}</span>
                </h2>
                <p class="text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply">{{ $gallery['body'] }}</p>
            </div>

            <div @class([
                'flex w-full items-start justify-center gap-[15px]',
                'mt-[40px]' => $hasPolaroids,
                'mt-[12px]' => ! $hasPolaroids,
            ])>
                @foreach ($galleryPolaroids['mob'] as $polaroid)
                    <div class="relative shrink-0" style="width: {{ $polaroid['fw'] }}px; height: {{ $polaroid['fh'] }}px; transform: rotate({{ $polaroid['rotate'] }});" data-lum-villa-polaroid>
                        <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                        <p class="lum-villa-polaroid__script absolute left-0 right-0 z-[3] text-center leading-none" style="top: {{ $polaroid['dateTop'] }}px; font-size: {{ $polaroid['dateSize'] }}px; letter-spacing: 0.23px;">{{ $polaroid['date'] }}</p>
                        <img src="{{ $img($polaroid['path']) }}" alt="" class="lum-polaroid__photo">
                        <p class="lum-villa-polaroid__script lum-villa-polaroid__share absolute left-0 right-0 z-[3] px-[4px] text-center leading-[1]" style="bottom: {{ $polaroid['shareBottom'] }}px; font-size: {{ $polaroid['shareSize'] }}px; letter-spacing: 0.2px;">{{ __('lum.polaroids.share') }}</p>
                    </div>
                @endforeach
            </div>

            <p @class([
                'w-[335px] text-center text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply',
                'mt-[64px]' => $hasPolaroids,
                'mt-[40px]' => ! $hasPolaroids,
            ]) data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.1">{{ $gallery['body_bottom'] }}</p>

            @include('lum.partials.divider-logomark', [
                'img' => $img,
                'size' => 'mob',
                'class' => $hasPolaroids ? 'mt-[69px]' : 'mt-[44px]',
            ])
        </div>
    </div>

    {{-- TABLET — Figma 196:490 — body→divider 121, divider→next 80 --}}
    <div class="relative hidden tab:block desk:hidden">
        <div class="flex flex-col items-center px-[20px]">
            <p class="lum-script whitespace-nowrap text-center text-[28px] leading-none tracking-[1.4px] text-[#752a23]" data-lum-villa-eyebrow>{{ $gallery['eyebrow'] }}</p>

            <div class="mt-[64px] flex w-[800px] flex-col items-center gap-[20px] text-center" data-lum-scroll-reveal>
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8">
                <h2 class="font-serif text-[52px] leading-[52px] text-lum-espresso">
                    {{ $gallery['title_normal'] }}<br><span class="font-medium italic">{{ $gallery['title_italic'] }}</span>
                </h2>
                <p class="max-w-[560px] lum-text-2 text-lum-espresso mix-blend-multiply">{{ $gallery['body'] }}</p>
            </div>

            <div @class([
                'flex w-full items-start justify-center gap-[20px]',
                'mt-[81px]' => $hasPolaroids,
                'mt-[20px]' => ! $hasPolaroids,
            ])>
                @foreach ($galleryPolaroids['tab'] as $polaroid)
                    <div class="relative shrink-0" style="width: {{ $polaroid['fw'] }}px; height: {{ $polaroid['fh'] }}px; transform: rotate({{ $polaroid['rotate'] }});" data-lum-villa-polaroid>
                        <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                        <p class="lum-villa-polaroid__script absolute left-0 right-0 z-[3] text-center leading-none" style="top: {{ $polaroid['dateTop'] }}px; font-size: {{ $polaroid['dateSize'] }}px; letter-spacing: 0.4px;">{{ $polaroid['date'] }}</p>
                        <img src="{{ $img($polaroid['path']) }}" alt="" class="lum-polaroid__photo">
                        <p class="lum-villa-polaroid__script lum-villa-polaroid__share absolute left-0 right-0 z-[3] px-[10px] text-center leading-[1.05]" style="bottom: {{ $polaroid['shareBottom'] }}px; font-size: {{ $polaroid['shareSize'] }}px; letter-spacing: 0.5px;">{{ __('lum.polaroids.share') }}</p>
                    </div>
                @endforeach
            </div>

            <p @class([
                'w-[560px] text-center lum-text-2 text-lum-espresso mix-blend-multiply',
                'mt-[119px]' => $hasPolaroids,
                'mt-[60px]' => ! $hasPolaroids,
            ]) data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.1">{{ $gallery['body_bottom'] }}</p>

            @include('lum.partials.divider-logomark', [
                'img' => $img,
                'size' => 'tab',
                'class' => $hasPolaroids ? 'mt-[121px]' : 'mt-[80px]',
            ])
        </div>
    </div>

    {{-- DESKTOP — Figma 196:360 — body→divider 120, divider→next 120 --}}
    <div class="relative hidden desk:block">
        <div class="flex flex-col items-center px-[72px] pt-[105px]">
            <p class="lum-script whitespace-nowrap text-center text-[28px] leading-none tracking-[1.6px] text-[#752a23]" data-lum-villa-eyebrow>{{ $gallery['eyebrow'] }}</p>

            <div class="mt-[46px] flex w-[856px] flex-col items-center gap-[24px] text-center" data-lum-scroll-reveal>
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12">
                <h2 class="font-serif text-[88px] leading-[94px] text-lum-espresso">
                    {{ $gallery['title_normal'] }}<br><span class="font-medium italic">{{ $gallery['title_italic'] }}</span>
                </h2>
                <p class="lum-body text-lum-espresso mix-blend-multiply">{{ $gallery['body'] }}</p>
            </div>

            <div @class([
                'flex w-full items-start justify-center gap-[64px]',
                'mt-[120px]' => $hasPolaroids,
                'mt-[32px]' => ! $hasPolaroids,
            ])>
                @foreach ($galleryPolaroids['desk'] as $polaroid)
                    <div class="relative shrink-0" style="width: {{ $polaroid['fw'] }}px; height: {{ $polaroid['fh'] }}px; transform: rotate({{ $polaroid['rotate'] }});" data-lum-villa-polaroid>
                        <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                        <p class="lum-villa-polaroid__script absolute left-0 right-0 z-[3] text-center leading-none" style="top: {{ $polaroid['dateTop'] }}px; font-size: {{ $polaroid['dateSize'] }}px; letter-spacing: 0.79px;">{{ $polaroid['date'] }}</p>
                        <img src="{{ $img($polaroid['path']) }}" alt="" class="lum-polaroid__photo">
                        <p class="lum-villa-polaroid__script lum-villa-polaroid__share absolute left-0 right-0 z-[3] px-[12px] text-center leading-[1.05]" style="bottom: {{ $polaroid['shareBottom'] }}px; font-size: {{ $polaroid['shareSize'] }}px; letter-spacing: 1.14px;">{{ __('lum.polaroids.share') }}</p>
                    </div>
                @endforeach
            </div>

            <p @class([
                'w-[856px] text-center lum-body text-lum-espresso mix-blend-multiply',
                'mt-[160px]' => $hasPolaroids,
                'mt-[80px]' => ! $hasPolaroids,
            ]) data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.1">{{ $gallery['body_bottom'] }}</p>

            @include('lum.partials.divider-logomark', [
                'img' => $img,
                'size' => 'desk',
                'class' => $hasPolaroids ? 'mt-[120px]' : 'mt-[88px]',
            ])
        </div>
    </div>
</section>
