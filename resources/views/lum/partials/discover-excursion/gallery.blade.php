@php
    $gallery = $excursion['gallery'];
    $slug = $excursion['slug'] ?? '';
    $assetBase = 'discover/detail/'.$slug;
    $cmsPolaroids = $gallery['polaroids'] ?? [];
    $pick = function (int $i, string $fallbackPhoto, string $fallbackDate) use ($cmsPolaroids, $assetBase): array {
        $item = $cmsPolaroids[$i] ?? null;
        $path = is_array($item) && filled($item['path'] ?? null)
            ? (string) $item['path']
            : $assetBase.'/'.$fallbackPhoto;
        $date = is_array($item) && filled($item['date'] ?? null)
            ? (string) $item['date']
            : $fallbackDate;

        return ['path' => $path, 'date' => $date];
    };

    $p0 = $pick(0, 'gallery-01.webp', '06.08.2023');
    $p1 = $pick(1, 'gallery-02.webp', '06.01.2024');
    $p2 = $pick(2, 'gallery-03.webp', '07.03.2023');

    $galleryPolaroids = [
        'mob' => [
            ['rotate' => '8deg', 'fw' => 160, 'fh' => 226, 'dateSize' => 10, 'shareSize' => 9, 'dateTop' => 8, 'shareBottom' => 22, 'path' => $p0['path'], 'date' => $p0['date']],
            ['rotate' => '-6deg', 'fw' => 160, 'fh' => 226, 'dateSize' => 10, 'shareSize' => 9, 'dateTop' => 8, 'shareBottom' => 22, 'path' => $p1['path'], 'date' => $p1['date']],
        ],
        'tab' => [
            ['rotate' => '6deg', 'fw' => 450, 'fh' => 635, 'dateSize' => 13, 'shareSize' => 17, 'dateTop' => 34, 'shareBottom' => 92, 'path' => $p0['path'], 'date' => $p0['date']],
            ['rotate' => '-4deg', 'fw' => 450, 'fh' => 635, 'dateSize' => 13, 'shareSize' => 17, 'dateTop' => 34, 'shareBottom' => 92, 'path' => $p1['path'], 'date' => $p1['date']],
        ],
        'desk' => [
            ['rotate' => '5deg', 'fw' => 549, 'fh' => 775, 'dateSize' => 16, 'shareSize' => 23, 'dateTop' => 42, 'shareBottom' => 106, 'path' => $p0['path'], 'date' => $p0['date']],
            ['rotate' => '-3deg', 'fw' => 549, 'fh' => 775, 'dateSize' => 16, 'shareSize' => 23, 'dateTop' => 42, 'shareBottom' => 106, 'path' => $p1['path'], 'date' => $p1['date']],
            ['rotate' => '7deg', 'fw' => 549, 'fh' => 775, 'dateSize' => 16, 'shareSize' => 23, 'dateTop' => 42, 'shareBottom' => 106, 'path' => $p2['path'], 'date' => $p2['date']],
        ],
    ];
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

            <div class="mt-[40px] flex w-full items-start justify-center gap-[15px]">
                @foreach ($galleryPolaroids['mob'] as $polaroid)
                    <div class="relative shrink-0" style="width: {{ $polaroid['fw'] }}px; height: {{ $polaroid['fh'] }}px; transform: rotate({{ $polaroid['rotate'] }});" data-lum-villa-polaroid>
                        <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                        <p class="lum-villa-polaroid__script absolute left-0 right-0 z-[3] text-center leading-none" style="top: {{ $polaroid['dateTop'] }}px; font-size: {{ $polaroid['dateSize'] }}px; letter-spacing: 0.23px;">{{ $polaroid['date'] }}</p>
                        <img src="{{ $img($polaroid['path']) }}" alt="" class="lum-polaroid__photo">
                        <p class="lum-villa-polaroid__script lum-villa-polaroid__share absolute left-0 right-0 z-[3] px-[4px] text-center leading-[1]" style="bottom: {{ $polaroid['shareBottom'] }}px; font-size: {{ $polaroid['shareSize'] }}px; letter-spacing: 0.2px;">{{ __('lum.polaroids.share') }}</p>
                    </div>
                @endforeach
            </div>

            <p class="mt-[64px] w-[335px] text-center text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso mix-blend-multiply" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.1">{{ $gallery['body_bottom'] }}</p>

            <img src="{{ $img('dining/detail/shared/divider-mob.svg') }}" alt="" class="mt-[69px] h-[31px] w-[335px]" width="335" height="31">
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

            <div class="mt-[81px] flex w-full items-start justify-center gap-[20px]">
                @foreach ($galleryPolaroids['tab'] as $polaroid)
                    <div class="relative shrink-0" style="width: {{ $polaroid['fw'] }}px; height: {{ $polaroid['fh'] }}px; transform: rotate({{ $polaroid['rotate'] }});" data-lum-villa-polaroid>
                        <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                        <p class="lum-villa-polaroid__script absolute left-0 right-0 z-[3] text-center leading-none" style="top: {{ $polaroid['dateTop'] }}px; font-size: {{ $polaroid['dateSize'] }}px; letter-spacing: 0.4px;">{{ $polaroid['date'] }}</p>
                        <img src="{{ $img($polaroid['path']) }}" alt="" class="lum-polaroid__photo">
                        <p class="lum-villa-polaroid__script lum-villa-polaroid__share absolute left-0 right-0 z-[3] px-[10px] text-center leading-[1.05]" style="bottom: {{ $polaroid['shareBottom'] }}px; font-size: {{ $polaroid['shareSize'] }}px; letter-spacing: 0.5px;">{{ __('lum.polaroids.share') }}</p>
                    </div>
                @endforeach
            </div>

            <p class="mt-[119px] w-[560px] text-center lum-text-2 text-lum-espresso mix-blend-multiply" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.1">{{ $gallery['body_bottom'] }}</p>

            <img src="{{ $img('dining/detail/shared/divider-tab.svg') }}" alt="" class="mt-[121px] h-[39px] w-[920px]" width="920" height="39">
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

            <div class="mt-[120px] flex w-full items-start justify-center gap-[64px]">
                @foreach ($galleryPolaroids['desk'] as $polaroid)
                    <div class="relative shrink-0" style="width: {{ $polaroid['fw'] }}px; height: {{ $polaroid['fh'] }}px; transform: rotate({{ $polaroid['rotate'] }});" data-lum-villa-polaroid>
                        <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="lum-polaroid__frame drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
                        <p class="lum-villa-polaroid__script absolute left-0 right-0 z-[3] text-center leading-none" style="top: {{ $polaroid['dateTop'] }}px; font-size: {{ $polaroid['dateSize'] }}px; letter-spacing: 0.79px;">{{ $polaroid['date'] }}</p>
                        <img src="{{ $img($polaroid['path']) }}" alt="" class="lum-polaroid__photo">
                        <p class="lum-villa-polaroid__script lum-villa-polaroid__share absolute left-0 right-0 z-[3] px-[12px] text-center leading-[1.05]" style="bottom: {{ $polaroid['shareBottom'] }}px; font-size: {{ $polaroid['shareSize'] }}px; letter-spacing: 1.14px;">{{ __('lum.polaroids.share') }}</p>
                    </div>
                @endforeach
            </div>

            <p class="mt-[160px] w-[856px] text-center lum-body text-lum-espresso mix-blend-multiply" data-lum-scroll-reveal data-lum-scroll-reveal-delay="0.1">{{ $gallery['body_bottom'] }}</p>

            <img src="{{ $img('dining/detail/shared/divider.svg') }}" alt="" class="mt-[120px] h-[63px] w-[1776px]" width="1776" height="63">
        </div>
    </div>
</section>
