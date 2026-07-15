@php
    $locale = app()->getLocale();
    $otherLocale = $locale === 'en' ? 'ru' : 'en';
    $currentShort = $locale === 'en' ? __('lum.lang.en_short') : __('lum.lang.ru_short');
    $villaUrl = fn (string $slug) => route('villa.show', $slug);
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

        {{-- 160:415 lang toggle --}}
        <a
            href="{{ route('locale.switch', $otherLocale) }}"
            class="absolute left-[20px] top-[87px] z-50 flex h-[32px] w-[40px] items-center justify-center whitespace-nowrap text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-espresso transition-opacity duration-300 hover:opacity-70"
            data-lum-menu-reveal="1"
            aria-current="true"
            aria-label="{{ __('lum.lang.select') }}"
        >✓{{ $currentShort }}</a>
        {{-- 160:414 --}}
        <div class="absolute left-[70px] top-[91px] z-50 h-[24px] w-px bg-lum-espresso/16" data-lum-menu-reveal="1" aria-hidden="true"></div>
        {{-- 160:413 --}}
        <p class="absolute left-[89px] top-[103px] z-50 -translate-y-1/2 text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-espresso" data-lum-menu-reveal="1">{{ __('lum.lang.select') }}</p>
        {{-- 160:407 --}}
        <div class="absolute left-[20px] top-[125px] h-px w-[335px] bg-lum-espresso/16" data-lum-menu-reveal="1" aria-hidden="true"></div>

        {{-- 160:393 nav --}}
        <nav class="absolute left-[20px] top-[146px] z-10 flex w-[160px] flex-col gap-[6px]" data-lum-menu-reveal="2">
            <a href="{{ route('stay') }}" class="flex w-fit items-center gap-[6px] font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso">
                {{ __('lum.nav.stay') }}
                <img src="{{ asset('images/lum/ui/point-active.svg') }}" alt="" class="size-[6px]" width="6" height="6">
            </a>
            <a href="{{ route('dining') }}" class="font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso">{{ __('lum.nav.dining') }}</a>
            <a href="{{ route('relax') }}" class="font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso">{{ __('lum.nav.relax') }}</a>
            <a href="{{ route('discover') }}" class="font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso">{{ __('lum.nav.discover') }}</a>
            <div class="flex items-start gap-[6px] whitespace-nowrap font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso">
                <a href="{{ route('shop') }}">{{ __('lum.nav.shop') }}</a>
                <span class="text-lum-espresso/16">/</span>
                <a href="{{ route('contacts') }}">{{ __('lum.nav.contacts') }}</a>
                <span class="text-lum-espresso/16">/</span>
                <a href="{{ route('blog') }}">{{ __('lum.nav.blog') }}</a>
            </div>
        </nav>

        {{-- 160:406 --}}
        <div class="absolute left-[20px] top-[330px] h-px w-[335px] bg-lum-espresso/16" data-lum-menu-reveal="3" aria-hidden="true"></div>
        {{-- 160:410 --}}
        <p class="absolute left-[20px] top-[361px] -translate-y-1/2 text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-espresso-40" data-lum-menu-reveal="3">{{ __('lum.nav.projects') }}</p>
        {{-- 160:409, 160:408, 160:412, 160:411 --}}
        <a href="{{ $villaUrl('residence') }}" class="absolute left-[20px] top-[394px] -translate-y-1/2 text-[14px] font-medium leading-[14px] tracking-[0.6px] text-lum-espresso" data-lum-menu-reveal="3">{{ __('lum.nav.lum_residence') }}</a>
        <a href="{{ $villaUrl('villas') }}" class="absolute left-[196px] top-[394px] -translate-y-1/2 text-[14px] font-medium leading-[14px] tracking-[0.6px] text-lum-espresso" data-lum-menu-reveal="3">{{ __('lum.nav.lum_villas') }}</a>
        <a href="{{ $villaUrl('oculus') }}" class="absolute left-[20px] top-[418px] -translate-y-1/2 text-[14px] font-medium leading-[14px] tracking-[0.6px] text-lum-espresso" data-lum-menu-reveal="3">{{ __('lum.nav.oculus') }}</a>
        <a href="{{ $villaUrl('ocean') }}" class="absolute left-[196px] top-[418px] -translate-y-1/2 text-[14px] font-medium leading-[14px] tracking-[0.6px] text-lum-espresso" data-lum-menu-reveal="3">{{ __('lum.nav.lum_ocean') }}</a>
    </div>

    {{-- 160:417 image — 375×375 --}}
    <div class="relative h-[375px] w-full overflow-hidden" data-lum-menu-reveal="4">
        <img src="{{ asset('images/lum/menu/map.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-black/32"></div>
        {{-- 160:419 — top 303 − translate-y-full = top 255 --}}
        <p class="absolute left-[20px] top-[255px] w-[335px] font-serif text-[22px] font-medium leading-[24px] tracking-[0.194px] text-lum-ivory">
            {!! __('lum.footer.address_menu') !!}
        </p>
        {{-- 160:420/421 --}}
        <div class="absolute left-[20px] top-[323px]">
            <a href="#" class="lum-btn-ivory inline-flex px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.844px]">{{ __('lum.location.see_on_map_upper') }}</a>
        </div>
    </div>
</div>
