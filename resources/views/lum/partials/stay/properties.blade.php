@php
    use App\Support\Exely;
    use App\Support\ListingLayout;

    $properties = collect($properties ?? []);
    $count = $properties->count();
    $isRu = app()->getLocale() === 'ru';
    $exelyEnabled = Exely::enabled();

    // Карточки после booking-блока — топы от 0
    $mobileLayout = ListingLayout::mobileStay($count, 0);
    $tabletLayout = ListingLayout::stayTablet($count, 0);
    $desktopLayout = ListingLayout::stayDesktop($count, 0);

    $mobileHeight = ListingLayout::sectionHeight($mobileLayout, 'textTop', 180);
    $tabletHeight = ListingLayout::sectionHeight($tabletLayout, 'textTop', 180);
    $desktopHeight = ListingLayout::sectionHeight($desktopLayout, 'textTop', 200);
@endphp

<section id="stay" class="lum-container relative bg-lum-ivory" data-lum-stay-page>
    {{-- MOBILE intro --}}
    <div class="relative tab:hidden" data-lum-stay-intro data-lum-stay-bp="mob">
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="mx-auto flex w-[335px] flex-col items-center pt-[124px] text-center" data-lum-stay-hero>
            <div class="flex w-full flex-col items-center gap-[16px]">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6" data-lum-stay-intro-item="dot">
                <h1 class="font-serif text-[42px] leading-[45px] text-lum-espresso" data-lum-stay-intro-item="title">
                    {{ __('lum.stay.title_line1') }}<br>
                    {{ __('lum.stay.title_line2') }}<br>
                    <span class="font-medium italic">{{ __('lum.stay.title_italic') }}</span>
                </h1>
            </div>

            <p class="mt-[16px] whitespace-nowrap lum-text-3 font-medium uppercase text-lum-espresso" data-lum-stay-intro-item="eyebrow">{{ __('lum.stay.eyebrow') }}</p>

            @include('lum.partials.stay.scroll-arrow', ['img' => $img, 'variant' => 'mob', 'marginClass' => 'mt-[44px]'])
        </div>
    </div>

    {{-- TABLET intro --}}
    <div class="relative hidden tab:block desk:hidden" data-lum-stay-intro data-lum-stay-bp="tab">
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="mx-auto flex w-[920px] flex-col items-center pt-[160px] text-center" data-lum-stay-hero>
            <div class="flex flex-col items-center gap-[12px]">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8" data-lum-stay-intro-item="dot">
                <h1 class="whitespace-nowrap font-serif text-[52px] leading-[52px] text-lum-espresso" data-lum-stay-intro-item="title">
                    {{ __('lum.stay.title_line1') }}<br>
                    {{ __('lum.stay.title_line2') }}<br>
                    <span class="font-medium italic">{{ __('lum.stay.title_italic') }}</span>
                </h1>
            </div>

            <p class="mt-[12px] whitespace-nowrap lum-text-2 font-medium uppercase text-lum-espresso" data-lum-stay-intro-item="eyebrow">{{ __('lum.stay.eyebrow') }}</p>

            @include('lum.partials.stay.scroll-arrow', ['img' => $img, 'variant' => 'tab', 'marginClass' => 'mt-[56px]'])
        </div>
    </div>

    {{-- DESKTOP intro --}}
    <div class="relative hidden desk:block" data-lum-stay-intro data-lum-stay-bp="desk">
        @include('lum.partials.header', ['headerTone' => 'espresso', 'headerActive' => 'stay'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div @class(['mx-auto flex flex-col items-center pt-[292px] text-center', 'w-[640px]' => $isRu, 'w-[552px]' => ! $isRu]) data-lum-stay-hero>
            <div class="flex w-full flex-col items-center gap-[24px]">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12" data-lum-stay-intro-item="dot">
                <h1 class="font-serif text-[88px] leading-[94px] text-lum-espresso" data-lum-stay-intro-item="title">
                    {{ __('lum.stay.title_line1') }}<br>
                    {{ __('lum.stay.title_line2') }}<br>
                    <span class="font-medium italic">{{ __('lum.stay.title_italic') }}</span>
                </h1>
            </div>

            <p class="mt-[28px] whitespace-nowrap lum-eyebrow text-lum-espresso" data-lum-stay-intro-item="eyebrow">{{ __('lum.stay.eyebrow') }}</p>

            @include('lum.partials.stay.scroll-arrow', ['img' => $img, 'variant' => 'desk', 'marginClass' => 'mt-[64px]'])
        </div>
    </div>

    @if ($exelyEnabled)
        <div class="lum-stay-booking" data-lum-stay-booking>
            @include('lum.exely.search', ['variant' => 'inline'])
        </div>
    @endif

    {{-- MOBILE properties --}}
    <div class="relative tab:hidden" style="height: {{ $mobileHeight }}px" data-lum-stay-properties="mob">
        @foreach ($properties as $index => $property)
            @php $layout = $mobileLayout[$index]; @endphp

            <a href="{{ route('villa.show', $property['slug']) }}" class="lum-stay-property-link absolute left-1/2 block h-[390px] w-[335px] -translate-x-1/2 overflow-hidden" style="top: {{ $layout['imageTop'] }}px" data-lum-stay-property-image data-lum-stay-property="{{ $index }}">
                <img src="{{ $img('stay/' . $property['image']) }}" alt="" class="lum-stay-property-link__photo h-full w-full object-cover" width="335" height="390" loading="lazy">
                <span class="lum-stay-property-link__shade pointer-events-none absolute inset-0 z-[1] bg-black/24" aria-hidden="true"></span>
                <img src="{{ $img('stay/logomark.svg') }}" alt="" class="absolute left-1/2 top-[326px] z-[2] size-[32px] -translate-x-1/2" width="32" height="32">
            </a>

            <div class="absolute left-1/2 flex w-[335px] -translate-x-1/2 flex-col items-center gap-[16px] text-center" style="top: {{ $layout['textTop'] }}px" data-lum-stay-property-copy data-lum-stay-property="{{ $index }}">
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

    {{-- TABLET properties --}}
    <div class="relative hidden tab:block desk:hidden" style="height: {{ $tabletHeight }}px" data-lum-stay-properties="tab">
        @foreach ($properties as $index => $property)
            @php $layout = $tabletLayout[$index]; @endphp

            <a href="{{ route('villa.show', $property['slug']) }}" class="lum-stay-property-link absolute block h-[525px] w-[450px] overflow-hidden" style="left: {{ $layout['left'] }}px; top: {{ $layout['imageTop'] }}px" data-lum-stay-property-image data-lum-stay-property="{{ $index }}">
                <img src="{{ $img('stay/' . $property['image']) }}" alt="" class="lum-stay-property-link__photo h-full w-full object-cover" width="450" height="525" loading="lazy">
                <span class="lum-stay-property-link__shade pointer-events-none absolute inset-0 z-[1] bg-black/24" aria-hidden="true"></span>
                <img src="{{ $img('stay/logomark.svg') }}" alt="" class="absolute left-1/2 top-[440px] z-[2] size-[40px] -translate-x-1/2" width="40" height="40">
            </a>

            <div class="absolute flex w-[450px] flex-col items-center gap-[12px] text-center" style="left: {{ $layout['left'] }}px; top: {{ $layout['textTop'] }}px" data-lum-stay-property-copy data-lum-stay-property="{{ $index }}">
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

    {{-- DESKTOP properties --}}
    <div class="relative hidden desk:block" style="height: {{ $desktopHeight }}px" data-lum-stay-properties="desk">
        @foreach ($properties as $index => $property)
            @php $layout = $desktopLayout[$index]; @endphp

            <a href="{{ route('villa.show', $property['slug']) }}" class="lum-stay-property-link absolute block h-[820px] w-[703px] overflow-hidden" style="left: {{ $layout['left'] }}px; top: {{ $layout['imageTop'] }}px" data-lum-stay-property-image data-lum-stay-property="{{ $index }}">
                <img src="{{ $img('stay/' . $property['image']) }}" alt="" class="lum-stay-property-link__photo h-full w-full object-cover" width="703" height="820" loading="lazy">
                <span class="lum-stay-property-link__shade pointer-events-none absolute inset-0 z-[1] bg-black/24" aria-hidden="true"></span>
                <img src="{{ $img('stay/logomark.svg') }}" alt="" class="absolute left-1/2 top-[684px] z-[2] size-[64px] -translate-x-1/2" width="64" height="64">
            </a>

            <div class="absolute flex w-[703px] flex-col items-center gap-[16px] text-center" style="left: {{ $layout['left'] }}px; top: {{ $layout['textTop'] }}px" data-lum-stay-property-copy data-lum-stay-property="{{ $index }}">
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
