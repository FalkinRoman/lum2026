@props([
    'activeNav' => null,
])

@php
    $activeNav = $activeNav ?? match (true) {
        request()->routeIs('restaurant.show') => null,
        request()->routeIs('stay', 'villa.show') => 'stay',
        request()->routeIs('dining') => 'dining',
        request()->routeIs('relax') => 'relax',
        request()->routeIs('discover', 'discover.show') => 'discover',
        default => null,
    };
    $hideDiscoverDot = request()->routeIs('discover.show');
@endphp

<header
    id="lum-sticky-header"
    class="lum-sticky-header fixed inset-x-0 top-0 z-[200] overflow-visible"
    aria-hidden="true"
    {{ $attributes }}
>
    <div class="lum-sticky-header__scaled origin-top-left">
        <div class="lum-sticky-header__inner">
            {{-- MOBILE --}}
            <div class="relative h-[80px] w-full border-b border-lum-espresso/16 bg-lum-ivory tab:hidden">
                <div class="absolute left-[20px] top-0 h-[80px] w-[335px]">
                    <a href="{{ route('home') }}" class="absolute left-0 top-1/2 h-[32px] w-[84px] -translate-y-1/2">
                        <img src="{{ asset('images/lum/menu/logo-lum-espresso.svg') }}" alt="Lum" class="h-full w-full object-contain object-left" width="84" height="32">
                    </a>

                    <button type="button" class="lum-burger-btn lum-burger-btn--espresso absolute right-0 top-1/2 flex -translate-y-1/2 items-center" aria-label="{{ __('lum.aria.menu') }}" data-lum-menu-toggle aria-controls="lum-burger-menu" aria-expanded="false">
                        <img src="{{ asset('images/lum/hero/burger.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                    </button>

                    <a href="#" class="lum-btn-outline absolute right-[82px] top-1/2 -translate-y-1/2 px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.nav.break') }}</a>
                </div>
            </div>

            {{-- TABLET --}}
            <div class="relative hidden h-[80px] w-full border-b border-lum-espresso/16 bg-lum-ivory tab:block desk:hidden">
                <div class="absolute left-[20px] top-0 h-[80px] w-[920px]">
                    <a href="{{ route('home') }}" class="absolute left-0 top-1/2 h-[32px] w-[84px] -translate-y-1/2">
                        <img src="{{ asset('images/lum/menu/logo-lum-espresso.svg') }}" alt="Lum" class="h-full w-full object-contain object-left" width="84" height="32">
                    </a>

                    <div class="absolute right-0 top-[24px] flex items-center gap-[10px]">
                        <div class="relative z-[5100]">
                            <button
                                type="button"
                                class="lum-icon-btn lum-icon-btn--espresso-outline"
                                data-lum-lang-toggle
                                aria-label="{{ __('lum.aria.language') }}"
                                aria-expanded="false"
                                aria-controls="lum-lang-panel-sticky"
                            >
                                <img src="{{ asset('images/lum/hero/language.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                            </button>
                            @include('lum.partials.language-switcher', ['panelId' => 'lum-lang-panel-sticky'])
                        </div>

                        <a href="#" class="lum-btn-outline px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.nav.take_a_break') }}</a>

                        <button type="button" class="lum-icon-btn lum-icon-btn--espresso-filled" aria-label="{{ __('lum.aria.contact') }}">
                            <img src="{{ asset('images/lum/hero/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                        </button>

                        <button type="button" class="lum-burger-btn lum-burger-btn--espresso flex items-center" aria-label="{{ __('lum.aria.menu') }}" data-lum-menu-toggle aria-controls="lum-burger-menu" aria-expanded="false">
                            <img src="{{ asset('images/lum/hero/burger.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                        </button>
                    </div>
                </div>
            </div>

            {{-- DESKTOP --}}
            <div class="relative hidden h-[132px] w-full border-b border-lum-espresso/16 bg-lum-ivory desk:block">
                <div class="absolute left-1/2 top-0 h-[132px] w-[1776px] -translate-x-1/2">
                    <button type="button" class="lum-burger-btn lum-burger-btn--espresso absolute left-0 top-1/2 flex -translate-y-1/2 items-center" aria-label="{{ __('lum.aria.menu') }}" data-lum-menu-toggle aria-controls="lum-burger-menu" aria-expanded="false">
                        <img src="{{ asset('images/lum/hero/burger.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                    </button>

                    <div class="absolute left-[112px] top-1/2 h-[18px] w-px -translate-y-1/2 bg-lum-espresso/16"></div>

                    <nav class="absolute left-[153px] top-[54px] flex items-start gap-[40px] overflow-visible lum-text-2 font-medium text-lum-espresso">
                        <a href="{{ route('stay') }}" @class(['lum-nav-link--inline', 'is-active' => $activeNav === 'stay'])>
                            <span>{{ __('lum.nav.stay') }}</span>
                            <span class="lum-nav-link__dot" aria-hidden="true"></span>
                        </a>
                        <a href="{{ route('dining') }}" @class(['lum-nav-link--inline', 'is-active' => $activeNav === 'dining'])>
                            <span>{{ __('lum.nav.dining') }}</span>
                            <span class="lum-nav-link__dot" aria-hidden="true"></span>
                        </a>
                        <a href="{{ route('relax') }}" @class(['lum-nav-link--inline', 'is-active' => $activeNav === 'relax'])>
                            <span>{{ __('lum.nav.relax') }}</span>
                            <span class="lum-nav-link__dot" aria-hidden="true"></span>
                        </a>
                        <a href="{{ route('discover') }}" @class(['lum-nav-link--inline', 'is-active' => $activeNav === 'discover'])>
                            <span>{{ __('lum.nav.discover') }}</span>
                            @unless ($hideDiscoverDot && $activeNav === 'discover')
                                <span class="lum-nav-link__dot" aria-hidden="true"></span>
                            @endunless
                        </a>
                    </nav>

                    <a href="{{ route('home') }}" class="absolute left-1/2 top-1/2 h-[40px] w-[105px] -translate-x-1/2 -translate-y-1/2">
                        <img src="{{ asset('images/lum/menu/logo-lum-espresso.svg') }}" alt="Lum" class="h-[40px] w-[105px]" width="105" height="40">
                    </a>

                    <div class="absolute right-0 top-[48px] flex items-center gap-[10px]">
                        <div class="relative z-[5100]">
                            <button
                                type="button"
                                class="lum-icon-btn lum-icon-btn--espresso-outline"
                                data-lum-lang-toggle
                                aria-label="{{ __('lum.aria.language') }}"
                                aria-expanded="false"
                                aria-controls="lum-lang-panel-sticky-desk"
                            >
                                <img src="{{ asset('images/lum/hero/language.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                            </button>
                            @include('lum.partials.language-switcher', ['panelId' => 'lum-lang-panel-sticky-desk'])
                        </div>
                        <a href="#" class="lum-btn-outline">{{ __('lum.nav.take_a_break') }}</a>
                        <button type="button" class="lum-icon-btn lum-icon-btn--espresso-filled" aria-label="{{ __('lum.aria.contact') }}">
                            <img src="{{ asset('images/lum/hero/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
