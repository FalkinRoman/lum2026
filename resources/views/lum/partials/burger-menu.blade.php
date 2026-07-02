@php
    $locale = app()->getLocale();
    $villaUrl = fn (string $slug) => route('villa.show', $slug);
@endphp
<div
    id="lum-burger-menu"
    class="lum-burger-menu fixed inset-0 z-[5000] hidden"
    hidden
    aria-hidden="true"
    role="dialog"
    aria-modal="true"
    aria-label="{{ __('lum.aria.menu') }}"
>
    <div
        class="lum-burger-menu__backdrop pointer-events-none fixed inset-0 z-[1] bg-black/32 backdrop-blur-[8px]"
        aria-hidden="true"
    ></div>
    <div class="lum-burger-menu__scroll pointer-events-auto fixed inset-0 z-[2] flex min-h-full flex-col overflow-y-auto overscroll-contain">
        <div class="lum-burger-menu__drawer relative w-full shrink-0 overflow-hidden">
            <div class="lum-burger-menu__scaled flex flex-col origin-top-left">
                <div class="lum-burger-menu__panel relative bg-lum-ivory">
            {{-- MOBILE --}}
            <div class="relative h-[582px] w-full tab:hidden">
                <header class="absolute left-[20px] top-0 z-50 h-[80px] w-[335px] border-b border-lum-espresso/16">
                    <a href="/" class="absolute left-0 top-1/2 h-[32px] w-[84px] -translate-y-1/2">
                        <img src="{{ asset('images/lum/menu/logo-lum-espresso.svg') }}" alt="Lum" class="h-full w-full object-contain object-left" width="84" height="32">
                    </a>
                    <button type="button" class="lum-burger-btn lum-burger-btn--espresso absolute right-0 top-1/2 flex -translate-y-1/2 items-center" data-lum-menu-close aria-label="{{ __('lum.aria.close_menu') }}">
                        <img src="{{ asset('images/lum/menu/close.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                    </button>
                    <a href="#" class="lum-btn-outline absolute right-[82px] top-1/2 -translate-y-1/2 px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.nav.break') }}</a>
                </header>

                <p class="absolute left-[20px] top-[104px] text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-espresso-40" data-lum-menu-reveal="1">{{ __('lum.lang.select') }}</p>
                <div class="absolute right-[20px] top-[98px] z-50 flex gap-[10px]" data-lum-menu-reveal="1">
                    <a href="{{ route('locale.switch', 'ru') }}" @class(['lum-tab lum-tab--s', 'lum-tab--active' => $locale === 'ru', 'lum-tab--inactive' => $locale !== 'ru'])>@if ($locale === 'ru')✓@endif{{ __('lum.lang.ru_short') }}</a>
                    <a href="{{ route('locale.switch', 'en') }}" @class(['lum-tab lum-tab--s', 'lum-tab--active' => $locale === 'en', 'lum-tab--inactive' => $locale !== 'en'])>@if ($locale === 'en')✓@endif{{ __('lum.lang.en_short') }}</a>
                </div>

                <nav class="absolute left-[20px] top-[146px] z-10 flex w-[160px] flex-col gap-[6px]" data-lum-menu-reveal="2">
                    <a href="/" class="flex items-center gap-[6px] font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso">
                        {{ __('lum.nav.home') }}
                        <img src="{{ asset('images/lum/ui/point-active.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                    </a>
                    <a href="{{ route('shop') }}" class="font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso">{{ __('lum.nav.shop') }}</a>
                    <a href="{{ route('contacts') }}" class="font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso">{{ __('lum.nav.contacts') }}</a>
                    <a href="{{ route('blog') }}" class="font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso">{{ __('lum.nav.blog') }}</a>
                </nav>

                <div class="absolute left-[20px] top-[300px] h-px w-[335px] bg-lum-espresso/16" data-lum-menu-reveal="3"></div>

                <div class="absolute left-[20px] top-[325px] grid w-[335px] grid-cols-2 gap-x-[76px] gap-y-[12px] text-[14px] font-medium leading-[14px] tracking-[0.6px] text-lum-espresso" data-lum-menu-reveal="3">
                    <a href="{{ $villaUrl('residence') }}">{{ __('lum.nav.lum_residence') }}</a>
                    <a href="{{ $villaUrl('villas') }}">{{ __('lum.nav.lum_villas') }}</a>
                    <a href="{{ $villaUrl('oculus') }}">{{ __('lum.nav.oculus') }}</a>
                    <a href="{{ $villaUrl('ocean') }}">{{ __('lum.nav.lum_ocean') }}</a>
                </div>

                <div class="absolute left-[20px] top-[387px] z-10 h-[175px] w-[335px] overflow-hidden" data-lum-menu-reveal="4">
                    <img src="{{ asset('images/lum/menu/map.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-black/32"></div>
                    <div class="absolute left-1/2 top-1/2 flex w-[197px] -translate-x-1/2 -translate-y-1/2 flex-col items-center gap-[16px] text-center">
                        <p class="font-serif text-[22px] font-medium leading-[24px] tracking-[0.19px] text-lum-ivory">
                            {!! __('lum.footer.address_menu') !!}
                        </p>
                        <a href="#" class="lum-btn-ivory px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.location.see_on_map_upper') }}</a>
                    </div>
                </div>
            </div>

            {{-- TABLET --}}
            <div class="relative hidden h-[868px] w-full tab:block desk:hidden">
                <header class="absolute left-[20px] top-0 z-50 h-[80px] w-[920px] border-b border-lum-espresso/16">
                    <a href="/" class="absolute left-0 top-1/2 h-[32px] w-[84px] -translate-y-1/2">
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
                                aria-controls="lum-lang-panel-burger-tab"
                            >
                                <img src="{{ asset('images/lum/hero/language.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                            </button>
                            @include('lum.partials.language-switcher', ['panelId' => 'lum-lang-panel-burger-tab'])
                        </div>
                        <a href="#" class="lum-btn-outline px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.nav.take_a_break') }}</a>
                        <a href="{{ route('contacts') }}" class="lum-icon-btn lum-icon-btn--espresso-filled" aria-label="{{ __('lum.aria.contact') }}">
                            <img src="{{ asset('images/lum/hero/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                        </a>
                        <button type="button" class="lum-burger-btn lum-burger-btn--espresso flex items-center" data-lum-menu-close aria-label="{{ __('lum.aria.close_menu') }}">
                            <img src="{{ asset('images/lum/menu/close.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                        </button>
                    </div>
                </header>

                <nav class="absolute left-[20px] top-[144px] z-10 flex w-[920px] flex-col gap-[6px]" data-lum-menu-reveal="2">
                    <a href="/" class="font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">{{ __('lum.nav.home') }}</a>
                    <div class="flex flex-wrap items-center gap-[12px] font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">
                        <a href="{{ $villaUrl('residence') }}">{{ __('lum.nav.residence', [], 'en') }}</a>
                        <span class="text-lum-espresso/16">/</span>
                        <a href="{{ $villaUrl('oculus') }}">{{ __('lum.nav.oculus', [], 'en') }}</a>
                        <span class="text-lum-espresso/16">/</span>
                        <a href="{{ $villaUrl('ocean') }}">{{ __('lum.nav.ocean', [], 'en') }}</a>
                        <img src="{{ asset('images/lum/ui/point-active.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                        <span class="text-lum-espresso/16">/</span>
                        <a href="{{ $villaUrl('villas') }}">{{ __('lum.nav.villas', [], 'en') }}</a>
                    </div>
                    <a href="{{ route('shop') }}" class="font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">{{ __('lum.nav.shop') }}</a>
                    <a href="{{ route('contacts') }}" class="font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">{{ __('lum.nav.contacts') }}</a>
                    <a href="{{ route('blog') }}" class="font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">{{ __('lum.nav.blog') }}</a>
                </nav>

                <div class="absolute left-[20px] top-[368px] z-10 h-[480px] w-[920px] overflow-hidden bg-lum-green" data-lum-menu-reveal="4">
                    <img src="{{ asset('images/lum/menu/map.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-black/32"></div>
                    <div class="absolute bottom-[31px] left-[36px] font-serif text-[28px] font-medium leading-[34px] tracking-[0.36px] text-lum-ivory">
                        {!! __('lum.footer.address_menu') !!}
                    </div>
                    <a href="#" class="lum-btn-ivory absolute bottom-[36px] right-[36px] px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.location.see_on_map_upper') }}</a>
                </div>
            </div>

            {{-- DESKTOP --}}
            <div class="relative hidden h-[732px] w-full desk:block">
                <header class="absolute left-1/2 top-0 z-50 h-[132px] w-[1776px] -translate-x-1/2 border-b border-lum-espresso/16">
                    <button type="button" class="lum-burger-btn lum-burger-btn--espresso absolute left-0 top-1/2 flex -translate-y-1/2 items-center" data-lum-menu-close aria-label="{{ __('lum.aria.close_menu') }}">
                        <img src="{{ asset('images/lum/menu/close.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                    </button>
                    <div class="absolute left-[112px] top-1/2 h-[18px] w-px -translate-y-1/2 bg-lum-espresso/16"></div>
                    <nav class="absolute left-[153px] top-[54px] flex items-start gap-[40px] overflow-visible text-[16px] font-medium leading-[25px] tracking-[0.16px] text-lum-espresso">
                        <a href="{{ route('stay') }}" @class(['lum-nav-link--inline', 'is-active' => request()->routeIs('stay')])>
                            <span>{{ __('lum.nav.stay') }}</span>
                            <span class="lum-nav-link__dot" aria-hidden="true"></span>
                        </a>
                        <a href="{{ route('dining') }}" @class(['lum-nav-link--inline', 'is-active' => request()->routeIs('dining')])>
                            <span>{{ __('lum.nav.dining') }}</span>
                            <span class="lum-nav-link__dot" aria-hidden="true"></span>
                        </a>
                        <a href="{{ route('relax') }}" @class(['lum-nav-link--inline', 'is-active' => request()->routeIs('relax')])>
                            <span>{{ __('lum.nav.relax') }}</span>
                            <span class="lum-nav-link__dot" aria-hidden="true"></span>
                        </a>
                        <a href="{{ route('discover') }}" @class(['lum-nav-link--inline', 'is-active' => request()->routeIs('discover', 'discover.show')])>
                            <span>{{ __('lum.nav.discover') }}</span>
                            @unless (request()->routeIs('discover.show'))
                                <span class="lum-nav-link__dot" aria-hidden="true"></span>
                            @endunless
                        </a>
                    </nav>
                    <a href="/" class="absolute left-1/2 top-1/2 h-[40px] w-[105px] -translate-x-1/2 -translate-y-1/2">
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
                                aria-controls="lum-lang-panel-burger-desk"
                            >
                                <img src="{{ asset('images/lum/hero/language.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                            </button>
                            @include('lum.partials.language-switcher', ['panelId' => 'lum-lang-panel-burger-desk'])
                        </div>
                        <a href="#" class="lum-btn-outline">{{ __('lum.nav.take_a_break') }}</a>
                        <a href="{{ route('contacts') }}" class="lum-icon-btn lum-icon-btn--espresso-filled" aria-label="{{ __('lum.aria.contact') }}">
                            <img src="{{ asset('images/lum/hero/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                        </a>
                    </div>
                </header>

                <nav class="absolute left-[72px] top-[320px] z-10 flex flex-col" data-lum-menu-reveal="2">
                    <a href="/" class="font-serif text-[56px] leading-[68px] tracking-[-0.25px] text-lum-espresso">{{ __('lum.nav.home') }}</a>
                    <div class="flex flex-wrap items-center gap-[16px] font-serif text-[56px] leading-[68px] tracking-[-0.25px] text-lum-espresso">
                        <a href="{{ $villaUrl('residence') }}">{{ __('lum.nav.residence', [], 'en') }}</a>
                        <span class="text-lum-espresso/16">/</span>
                        <a href="{{ $villaUrl('oculus') }}">{{ __('lum.nav.oculus', [], 'en') }}</a>
                        <span class="text-lum-espresso/16">/</span>
                        <a href="{{ $villaUrl('ocean') }}">{{ __('lum.nav.ocean', [], 'en') }}</a>
                        <img src="{{ asset('images/lum/ui/point-active.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                        <span class="text-lum-espresso/16">/</span>
                        <a href="{{ $villaUrl('villas') }}">{{ __('lum.nav.villas', [], 'en') }}</a>
                    </div>
                    <a href="{{ route('shop') }}" class="font-serif text-[56px] leading-[68px] tracking-[-0.25px] text-lum-espresso">{{ __('lum.nav.shop') }}</a>
                    <a href="{{ route('contacts') }}" class="font-serif text-[56px] leading-[68px] tracking-[-0.25px] text-lum-espresso">{{ __('lum.nav.contacts') }}</a>
                    <a href="{{ route('blog') }}" class="font-serif text-[56px] leading-[68px] tracking-[-0.25px] text-lum-espresso">{{ __('lum.nav.blog') }}</a>
                </nav>

                <div class="absolute right-[72px] top-[168px] z-10 h-[528px] w-[703px] overflow-hidden bg-lum-green" data-lum-menu-reveal="4">
                    <img src="{{ asset('images/lum/menu/map.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-black/32"></div>
                    <div class="absolute bottom-[40px] left-[44px] font-serif text-[32px] font-medium leading-[36px] tracking-[0.32px] text-lum-ivory">
                        {!! __('lum.footer.address_menu') !!}
                    </div>
                    <a href="#" class="lum-btn-ivory absolute bottom-[44px] right-[44px]">{{ __('lum.location.see_on_map_upper') }}</a>
                </div>
            </div>
        </div>

                @include('lum.partials.burger-menu-footer')
            </div>
        </div>

        <button
            type="button"
            class="lum-burger-menu__hitarea block min-h-0 w-full shrink-0 flex-1 border-0 bg-transparent p-0"
            data-lum-menu-backdrop
            aria-label="{{ __('lum.aria.close_menu') }}"
        ></button>
    </div>
</div>
