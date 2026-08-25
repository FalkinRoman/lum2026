@php
    use App\Support\ListingLayout;
    use App\Support\Content;

    $activities = collect($activities ?? []);
    $count = $activities->count();
    $isRu = app()->getLocale() === 'ru';

    $relaxTitle1 = Content::pageText('relax', 'intro', 'title_line1');
    $relaxTitleItalic = Content::pageText('relax', 'intro', 'title_italic');
    $relaxTitle2 = Content::pageText('relax', 'intro', 'title_line2');
    $relaxEyebrow1 = Content::pageText('relax', 'intro', 'eyebrow_line1');
    $relaxEyebrow2 = Content::pageText('relax', 'intro', 'eyebrow_line2');

    $mobileLayout = ListingLayout::mobileStack($count, 540, 430);
    $tabletLayout = ListingLayout::grid2($count, [20, 490], 588, 565);
    $desktopLayout = ListingLayout::grid2($count, [72, 686, 1299], 894, 804);

    $mobileHeight = ListingLayout::sectionHeight($mobileLayout, 'top', 510);
    $tabletHeight = ListingLayout::sectionHeight($tabletLayout, 'top', 645);
    $desktopHeight = ListingLayout::sectionHeight($desktopLayout, 'top', 900);
@endphp

<section id="relax" class="lum-container relative bg-lum-ivory" data-lum-relax-page>
    {{-- MOBILE — Figma 101:533 --}}
    <div class="relative  tab:hidden" style="height: {{ $mobileHeight }}px" data-lum-stay-intro data-lum-intro-first-row="1">
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute left-1/2 top-[124px] flex w-[335px] -translate-x-1/2 flex-col items-center text-center" data-lum-stay-hero>
            <div class="flex w-full flex-col items-center gap-[16px]">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6" data-lum-stay-intro-item="dot">
                <h1 class="font-serif text-[42px] leading-[45px] text-lum-espresso" data-lum-stay-intro-item="title">
                    {{ $relaxTitle1 }}<br>
                    <span class="font-medium italic">{{ $relaxTitleItalic }}</span>@if ($isRu)<br>@endif{{ $relaxTitle2 }}
                </h1>
            </div>

            <p class="mt-[16px] text-center lum-text-3 font-medium uppercase leading-[18px] text-lum-espresso" data-lum-stay-intro-item="eyebrow">
                {{ $relaxEyebrow1 }}<br>
                {{ $relaxEyebrow2 }}
            </p>

            @include('lum.partials.stay.scroll-arrow', ['img' => $img, 'variant' => 'mob', 'marginClass' => 'mt-[44px]'])
        </div>

        @foreach ($activities as $index => $activity)
            @php $layout = $mobileLayout[$index]; @endphp

            <a href="{{ route('relax.show', $activity['slug']) }}" class="lum-dining-card absolute left-1/2 h-[390px] w-[335px] -translate-x-1/2 overflow-hidden" style="top: {{ $layout['top'] }}px" data-lum-stay-property-image data-lum-stay-property="{{ $index }}">
                @include('lum.partials.relax.card', [
                    'img' => $img,
                    'activity' => $activity,
                    'width' => 335,
                    'height' => 390,
                    'labelTop' => 32,
                    'labelPadX' => 'px-[32px]',
                    'labelPadY' => 'py-[2px]',
                    'labelClass' => 'text-[16px] leading-[20px] tracking-[-0.16px]',
                    'nameTop' => 351,
                    'lineClass' => 'w-[30px]',
                    'nameClass' => 'text-[14px] leading-[14px] tracking-[0.6px]',
                ])
            </a>
        @endforeach

        @include('lum.partials.divider-logomark', [
            'img' => $img,
            'size' => 'mob',
            'class' => 'absolute left-[20px] top-[1870px]',
        ])
    </div>

    {{-- TABLET — Figma 101:486 --}}
    <div class="relative hidden  tab:block desk:hidden" style="height: {{ $tabletHeight }}px" data-lum-stay-intro data-lum-intro-first-row="3">
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute left-1/2 top-[160px] flex w-[577px] -translate-x-1/2 flex-col items-center text-center" data-lum-stay-hero>
            <div class="flex flex-col items-center gap-[12px]">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8" data-lum-stay-intro-item="dot">
                <h1 class="font-serif text-[52px] leading-[52px] text-lum-espresso" data-lum-stay-intro-item="title">
                    {{ $relaxTitle1 }}<br>
                    <span class="font-medium italic">{{ $relaxTitleItalic }}</span>@if ($isRu)<br>@endif{{ $relaxTitle2 }}
                </h1>
            </div>

            <p class="mt-[12px] max-w-[480px] text-center text-[14px] font-medium uppercase leading-[22px] tracking-[0.16px] text-lum-espresso" data-lum-stay-intro-item="eyebrow">
                {{ $relaxEyebrow1 }}<br>
                {{ $relaxEyebrow2 }}
            </p>

            @include('lum.partials.stay.scroll-arrow', ['img' => $img, 'variant' => 'tab', 'marginClass' => 'mt-[56px]'])
        </div>

        @foreach ($activities as $index => $activity)
            @php $layout = $tabletLayout[$index]; @endphp

            <a href="{{ route('relax.show', $activity['slug']) }}" class="lum-dining-card absolute h-[525px] w-[450px] overflow-hidden" style="left: {{ $layout['left'] }}px; top: {{ $layout['top'] }}px" data-lum-stay-property-image data-lum-stay-property="{{ $index }}">
                @include('lum.partials.relax.card', [
                    'img' => $img,
                    'activity' => $activity,
                    'width' => 450,
                    'height' => 525,
                    'labelTop' => 32,
                    'labelPadX' => 'px-[32px]',
                    'labelPadY' => 'py-[2px]',
                    'labelClass' => 'text-[16px] leading-[20px] tracking-[-0.16px]',
                    'nameTop' => 481,
                    'nameClass' => 'text-[16px] leading-[16px] tracking-[1.6px]',
                ])
            </a>
        @endforeach

        @include('lum.partials.divider-logomark', [
            'img' => $img,
            'size' => 'tab',
            'class' => 'absolute left-[20px] top-[1798px]',
        ])
    </div>

    {{-- DESKTOP — Figma 101:387 --}}
    <div class="relative hidden  desk:block" style="height: {{ $desktopHeight }}px" data-lum-stay-intro data-lum-intro-first-row="3">
        @include('lum.partials.header', ['headerTone' => 'espresso', 'headerActive' => 'relax'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="absolute left-1/2 top-[292px] flex w-[1162px] -translate-x-1/2 flex-col items-center text-center" data-lum-stay-hero>
            <div class="flex w-full flex-col items-center gap-[24px]">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12" data-lum-stay-intro-item="dot">
                <h1 class="font-serif text-[88px] leading-[94px] text-lum-espresso" data-lum-stay-intro-item="title">
                    {{ $relaxTitle1 }}<br>
                    <span class="font-medium italic">{{ $relaxTitleItalic }}</span>@if ($isRu)<br>@endif{{ $relaxTitle2 }}
                </h1>
            </div>

            <p class="mt-[20px] max-w-[1162px] text-center text-[18px] font-medium uppercase leading-[18px] tracking-[1.8px] text-lum-espresso" data-lum-stay-intro-item="eyebrow">
                {{ $relaxEyebrow1 }}<br>
                {{ $relaxEyebrow2 }}
            </p>

            @include('lum.partials.stay.scroll-arrow', ['img' => $img, 'variant' => 'desk', 'marginClass' => 'mt-[64px]'])
        </div>

        @foreach ($activities as $index => $activity)
            @php $layout = $desktopLayout[$index]; @endphp

            <a href="{{ route('relax.show', $activity['slug']) }}" class="lum-dining-card absolute h-[740px] w-[549px] overflow-hidden" style="left: {{ $layout['left'] }}px; top: {{ $layout['top'] }}px" data-lum-stay-property-image data-lum-stay-property="{{ $index }}">
                @include('lum.partials.relax.card', [
                    'img' => $img,
                    'activity' => $activity,
                    'width' => 549,
                    'height' => 740,
                    'labelTop' => 44,
                    'nameTop' => 687,
                ])
            </a>
        @endforeach
    </div>
</section>
