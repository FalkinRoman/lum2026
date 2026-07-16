@php
    $locale = app()->getLocale();
    $otherLocale = $locale === 'en' ? 'ru' : 'en';
    $currentShort = $locale === 'en' ? __('lum.lang.en_short') : __('lum.lang.ru_short');
    $villaUrl = $villaUrl ?? fn (string $slug) => route('villa.show', $slug);
    $menuActive = $menuActive ?? [];
@endphp
{{-- Figma 160:305 mobile open burger — 375×1010 (457 + 375 + 178 footer) --}}
<div class="relative w-full tab:hidden">
    {{-- 160:388 burger panel — h 457 --}}
    <div class="relative h-[457px] w-full bg-lum-ivory">
        <header class="absolute left-[20px] top-0 z-50 h-[80px] w-[335px] border-b border-lum-espresso/16">
            <a href="/" class="absolute left-0 top-1/2 h-[32px] w-[83.81px] -translate-y-1/2">
                <img src="{{ asset('images/lum/menu/logo-lum-espresso.svg') }}" alt="Lum" class="h-full w-full object-contain object-left" width="84" height="32">
            </a>
            <button type="button" class="lum-burger-btn lum-burger-btn--espresso-compact absolute right-0 top-1/2 flex -translate-y-1/2 items-center" data-lum-menu-close aria-label="{{ __('lum.aria.close_menu') }}">
                <img src="{{ asset('images/lum/menu/close.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </button>
            <a href="#" class="lum-btn-outline absolute right-[66px] top-1/2 -translate-y-1/2 px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.844px]">{{ __('lum.nav.break') }}</a>
        </header>

        {{-- 160:415 / 160:414 / 160:413 — lang row --}}
        <div class="absolute left-[20px] top-[87px] z-50 flex h-[32px] w-[335px] items-center gap-[10px]" data-lum-menu-reveal="1">
            <a
                href="{{ route('locale.switch', $otherLocale) }}"
                class="flex h-full shrink-0 items-center justify-center whitespace-nowrap text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-espresso transition-opacity duration-300 hover:opacity-70"
                aria-current="true"
                aria-label="{{ __('lum.lang.select') }}"
            >✓{{ $currentShort }}</a>
            <div class="h-[24px] w-px shrink-0 bg-lum-espresso/16" aria-hidden="true"></div>
            <p class="text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-espresso">{{ __('lum.lang.select') }}</p>
        </div>
        {{-- 160:407 --}}
        <div class="absolute left-[20px] top-[125px] h-px w-[335px] bg-lum-espresso/16" data-lum-menu-reveal="1" aria-hidden="true"></div>

        {{-- 160:393 nav --}}
        <nav class="absolute left-[20px] top-[146px] z-10 flex w-auto min-w-[160px] flex-col gap-[6px] font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso" data-lum-menu-nav>
            @include('lum.partials.burger-menu-link', ['href' => route('stay'), 'label' => __('lum.nav.stay'), 'active' => $menuActive['stay'] ?? false])
            @include('lum.partials.burger-menu-link', ['href' => route('dining'), 'label' => __('lum.nav.dining'), 'active' => $menuActive['dining'] ?? false])
            @include('lum.partials.burger-menu-link', ['href' => route('relax'), 'label' => __('lum.nav.relax'), 'active' => $menuActive['relax'] ?? false])
            @include('lum.partials.burger-menu-link', ['href' => route('discover'), 'label' => __('lum.nav.discover'), 'active' => $menuActive['discover'] ?? false])
            <div class="flex items-center gap-[6px] whitespace-nowrap">
                @include('lum.partials.burger-menu-link', ['href' => route('shop'), 'label' => __('lum.nav.shop'), 'active' => $menuActive['shop'] ?? false])
                <span class="text-lum-espresso/16">/</span>
                @include('lum.partials.burger-menu-link', ['href' => route('contacts'), 'label' => __('lum.nav.contacts'), 'active' => $menuActive['contacts'] ?? false])
                <span class="text-lum-espresso/16">/</span>
                @include('lum.partials.burger-menu-link', ['href' => route('blog'), 'label' => __('lum.nav.blog'), 'active' => $menuActive['blog'] ?? false])
            </div>
        </nav>

        {{-- 160:406 --}}
        <div class="absolute left-[20px] top-[330px] h-px w-[335px] bg-lum-espresso/16" data-lum-menu-reveal="3" aria-hidden="true"></div>
        {{-- 160:410 --}}
        <p class="absolute left-[20px] top-[361px] -translate-y-1/2 text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-espresso-40" data-lum-menu-reveal="3">{{ __('lum.nav.projects') }}</p>
        {{-- 160:409, 160:408, 160:412, 160:411 --}}
        <a href="{{ $villaUrl('residence') }}" @class(['absolute left-[20px] top-[394px] inline-flex -translate-y-1/2 items-center gap-[6px] text-[14px] font-medium leading-[14px] tracking-[0.6px] text-lum-espresso', 'is-active' => $menuActive['residence'] ?? false]) data-lum-menu-reveal="3">
            {{ __('lum.nav.lum_residence') }}
            @if ($menuActive['residence'] ?? false)<span class="lum-menu-dot" data-lum-menu-dot aria-hidden="true"></span>@endif
        </a>
        <a href="{{ $villaUrl('villas') }}" @class(['absolute left-[196px] top-[394px] inline-flex -translate-y-1/2 items-center gap-[6px] text-[14px] font-medium leading-[14px] tracking-[0.6px] text-lum-espresso', 'is-active' => $menuActive['villas'] ?? false]) data-lum-menu-reveal="3">
            {{ __('lum.nav.lum_villas') }}
            @if ($menuActive['villas'] ?? false)<span class="lum-menu-dot" data-lum-menu-dot aria-hidden="true"></span>@endif
        </a>
        <a href="{{ $villaUrl('oculus') }}" @class(['absolute left-[20px] top-[418px] inline-flex -translate-y-1/2 items-center gap-[6px] text-[14px] font-medium leading-[14px] tracking-[0.6px] text-lum-espresso', 'is-active' => $menuActive['oculus'] ?? false]) data-lum-menu-reveal="3">
            {{ __('lum.nav.oculus') }}
            @if ($menuActive['oculus'] ?? false)<span class="lum-menu-dot" data-lum-menu-dot aria-hidden="true"></span>@endif
        </a>
        <a href="{{ $villaUrl('ocean') }}" @class(['absolute left-[196px] top-[418px] inline-flex -translate-y-1/2 items-center gap-[6px] text-[14px] font-medium leading-[14px] tracking-[0.6px] text-lum-espresso', 'is-active' => $menuActive['ocean'] ?? false]) data-lum-menu-reveal="3">
            {{ __('lum.nav.lum_ocean') }}
            @if ($menuActive['ocean'] ?? false)<span class="lum-menu-dot" data-lum-menu-dot aria-hidden="true"></span>@endif
        </a>
    </div>

    {{-- 160:417 image — 375×375 --}}
    <div class="relative h-[375px] w-full overflow-hidden" data-lum-menu-reveal="4">
        <img src="{{ asset('images/lum/menu/map.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-black/32"></div>
        <p class="absolute left-[20px] top-[255px] w-[335px] font-serif text-[22px] font-medium leading-[24px] tracking-[0.194px] text-lum-ivory">
            {!! __('lum.footer.address_menu') !!}
        </p>
        <div class="absolute left-[20px] top-[323px]">
            <a href="#" class="lum-btn-ivory inline-flex px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.844px]">{{ __('lum.location.see_on_map_upper') }}</a>
        </div>
    </div>
</div>
